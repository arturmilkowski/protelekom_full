<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use App\Models\Product\Condition;

class ConditionTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeCondition(): void
    {
        $condition = Condition::factory()->make();

        $this->assertInstanceOf(Condition::class, $condition);
    }

    public function testCreateCondition(): void
    {
        $condition = Condition::factory()->create();

        $this->assertDatabaseHas('conditions', [
            'slug' => $condition->slug,
            'name' => $condition->name,
        ]);
    }
}
