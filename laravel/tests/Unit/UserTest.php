<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Blog\Post;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeUser(): void
    {
        $user = User::factory()->make();

        $this->assertInstanceOf(User::class, $user);
    }

    public function testCreateUser(): void
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);
    }

    public function testUserHasManyPosts(): void
    {
        $user = User::factory()
            ->has(Post::factory())
            ->make();

        $this->assertInstanceOf(Collection::class, $user->posts);
    }
}
