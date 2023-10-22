<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class PageTest extends TestCase
{
    use RefreshDatabase;

    public function testAbout(): void
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this
            ->actingAs($user)
            ->getJson(route('api.pages.about'));

        // $response->dd();
        $response->assertStatus(200);
    }
}
