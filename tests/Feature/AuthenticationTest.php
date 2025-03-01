<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_attendees_api_is_reachable_only_with_correct_token(): void
    {
        $response = $this->get('/api/attendees?token=' . config('app.api-key'));

        $response->assertStatus(200);
    }

    public function test_attendees_api_cannot_be_reached_without_token(): void
    {
        $response = $this->get('/api/attendees');

        $response->assertStatus(403);
    }
}
