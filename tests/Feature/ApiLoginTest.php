<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Sponsor;

class ApiLoginTest extends TestCase
{
    /**
     * A basic feature test api login.
     *
     * @return void
     */
    public function test_api_bad_password()
    {
        $payload = ['email' => 'ajay@hotmail.com', 'password' => 'password123'];
        $response = $this->post('/api/login', $payload);
        $response->assertStatus(401);
    }    
    public function test_api_login()
    {
        $payload = ['email' => 'ajay@hotmail.com', 'password' => 'password'];
        // Illuminate\Testing\TestResponse
        $response = $this->withHeaders(["Content-Type: application/json",
                        "Accept: application/json"])
                    ->post('/api/login', $payload);// postJson
        $response->assertStatus(200);
        $response->dump();
        $data = $response->json('data');
        file_put_contents($this->getTokenFile(), $data['token']);
    }
}
