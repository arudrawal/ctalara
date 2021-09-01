<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
/*
 *  To make a request to your application, you may invoke the get, post, put, patch,
 *  or delete methods within your test. These methods do not actually issue a "real" 
 *  HTTP request to your application. Instead, the entire network request is simulated 
 * internally.
 */
class SponsorTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /*public function test_list()
    {
		$user = User::factory()->create();
        // returned object: Illuminate\Testing\TestResponse
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/sponsor/index');
        $user->delete();
        
        $response->assertStatus(200);
    }*/
    /*public function test_create()
    {
        $sponsor = ['name' => 'American Pharma', 'code' => 'USPH-0101', 
                    'address' => '101 South Hillview Drive, Redwood, CA-96789 USA',
                    'contact' => 'Jack Nicolson', 'phone1'=>'934-678-9809'];
		$user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->json('POST', '/sponsor/ajax/create', $sponsor);
        $user->delete();
        $response->assertStatus(200);
    }*/
}
