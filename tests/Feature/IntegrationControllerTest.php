<?php

namespace Tests\Feature;

use App\Models\User;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IntegrationControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_cannot_view_integrations_page_without_authenticaton()
    {
        $response = $this->get(route('integrations'));

        $response->assertRedirect('/login');
    }
    public function test_user_can_view_integrations_page_with_authenticaton()
    {
        $this->seedDatabase();
        $user = User::first();
        $this->actingAs($user);
        $response = $this->get(route('integrations'));
        $response->assertViewIs('integrations');
    }

    public function test_user_can_view_create_integrations_page_with_type()
    {
        $types = []
    }

    public function seedDatabase()
    {
        $data = $this->getTestUser();
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'company_name' => $data['company_name'],
        ]);

        // Create another test user
        User::create([
            'name' => 'Test 2',
            'email' => 'test2@app.com',
            'password' => Hash::make('password2'),
            'company_name' => 'test2_company',
        ]);
    }

    public function getTestUser()
    {
        return [
            'name' => 'Test User',
            'email' => 'testuser@app.com',
            'password' => 'password',
            'company_name' => 'test_company'
        ];
    }
}
