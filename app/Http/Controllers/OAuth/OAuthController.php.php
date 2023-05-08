<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\EmailTakenException;
use App\Http\Controllers\Controller;
use App\Models\OAuthProvider;
use http\Exception\InvalidArgumentException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        foreach (['hubspot'] as $provider) {
            config([
                'services.' . $provider . '.redirect' => route('oauth.callback', $provider),
            ]);
        }
    }

    /**
     * Redirect the user to the provider authentication page.
     */
    public function getUrl($provider)
    {
        switch ($provider) {
            case 'hubspot':
                $url = Socialite::driver($provider)->redirect()->getTargetUrl();
                break;
            default:
                throw new InvalidArgumentException('Invalid provider');
        }
        return [
            'url' => $url,
        ];
    }

    public function redirect($provider)
    {
        return response()->redirectTo($this->getUrl($provider)['url']);
    }

    /**
     * Obtain the user information from the provider.
     */
    public function handleCallback($provider)
    {
        switch ($provider) {
            case 'hubspot':
                $user = Socialite::driver($provider)->stateless()->user();
                break;
            default:
                throw new InvalidArgumentException('Invalid provider');
        }

        $integration = $this->findOrCreateIntegration($provider, $user);

        $responseData = [
            'new_user' => $integration->justCreated ?? false,
            'token' => $user->token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->getPayload()->get('exp') - time(),
        ];

        if (request()->expectsJson()) {
            return response()->json($responseData);
        }

        return view('oauth/callback', $responseData);
    }

    protected function findOrCreateIntegration($provider, $user)
    {
        $integration = $user->integrations()->firstOrNew([
            'type' => $provider
        ])->fill([
            'data' => [
                'access_token' => $user->token,
                'refresh_token' => $user->refreshToken,
            ]
        ])->save();

        return $integration;
    }
}
