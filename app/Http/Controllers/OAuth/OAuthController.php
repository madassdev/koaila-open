<?php

namespace App\Http\Controllers\OAuth;

use App\Http\Controllers\Controller;
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
                $url = Socialite::driver($provider)
                    ->scopes(['crm.objects.contacts.read','crm.objects.companies.read'])
                    ->redirect()
                    ->getTargetUrl();
                break;
            default:
                throw new \InvalidArgumentException('Invalid provider');
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
                throw new \InvalidArgumentException('Invalid provider');
        }
        $this->findOrCreateIntegration($provider, $user);

        return redirect(route('integrations'));
    }

    protected function findOrCreateIntegration($provider, $user)
    {
        $integration = \Auth::user()->integrations()->firstOrNew([
            'type' => $provider
        ])->fill([
            'data' => [
                'access_token' => $user->token,
                'refresh_token' => $user->refreshToken,
                'expiresIn' => $user->expiresIn,
                'email'=>$user->email,
                'id'=>$user->id,
            ]
        ])->save();

        return $integration;
    }
}
