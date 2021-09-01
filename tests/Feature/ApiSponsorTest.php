<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Sponsor;

class ApiSponsorTest extends TestCase
{
    /**
     * A basic feature test api login.
     *
     * @return void
     */
    public function test_api_sponsor_index() {
        $token = file_get_contents($this->getTokenFile());
        $tokenHeader = "Authorization: Bearer " . $token;
        $response = $this->withHeaders(["Content-Type: application/json",
                        "Accept: application/json",
                        $tokenHeader])
                    ->get('/api/sponsor/index');// postJson
        $response->assertStatus(200);
        $response->dump();
    }
    public function test_api_sponsor_create() {
        $token = file_get_contents($this->getTokenFile());
        $tokenHeader = "Authorization: Bearer " . $token;
        $sponsor = Sponsor::factory()->make(); // ram copy - not in db
        $toServer = ['name' => $sponsor->name, 'code' => $sponsor->code, 
                    'address' => $sponsor->address];
        $response = $this->withHeaders(["Content-Type: application/json",
                        "Accept: application/json",
                        $tokenHeader])
                    ->postJson('/api/sponsor/create', $toServer);// postJson
        $response->dump();
        $response->assertStatus(200);
        
    }
    public function test_api_sponsor_delete() {
        $token = file_get_contents($this->getTokenFile());
        $tokenHeader = "Authorization: Bearer " . $token;
        $sponsors = Sponsor::orderBy('id', 'desc')->limit(1)->get();
        $id = 0;
        foreach ($sponsors as $sposor) {
            $id = $sposor->id;
            break;
        }
        if ($id) {
            echo 'ID:' . $id . PHP_EOL;
            $toServer = ['id' => $id];
            $response = $this->withHeaders(["Content-Type: application/json",
                        "Accept: application/json",
                        $tokenHeader])
                    ->postJson('/api/sponsor/delete', $toServer);
            $response->dump();
            $response->assertStatus(200);
        } else {
            echo 'DB Empty' . PHP_EOL;
        }
    }
}
