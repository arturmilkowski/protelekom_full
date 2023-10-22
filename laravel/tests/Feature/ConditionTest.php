<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product\Condition;


class ConditionTest extends TestCase
{
    use RefreshDatabase;

    private $user, $condition;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $this->condition = Condition::factory()->create();
    }

    public function testIndex(): void
    {
        $this->withoutExceptionHandling();
        $response = $this
            ->actingAs($this->user)
            ->getJson(route('api.products.conditions.index'));

        $response->assertStatus(200);
        // $response->assertJsonFragment(['name' => $this->condition->name]);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'slug',
                    'name',
                ]
            ]
        ]);
        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                $json->has('data', 1)
                    ->has(
                        'data.0',
                        fn (AssertableJson $json) =>
                        $json->where('id', $this->condition->id)
                            ->where('name', $this->condition->name)
                            ->etc()
                    )
            );
        // $response->dd();
    }

    public function testStore(): void
    {
        $this->withoutExceptionHandling();
        $condition = Condition::factory()->make([]);
        $response = $this->postJson(route('api.products.conditions.store'), $condition->toArray());

        $response->assertStatus(201)->assertJson(['name' => $condition->name]);
        $response->assertJsonIsObject();
        $response->assertJsonStructure(['name', 'slug']);
        $this->assertDatabaseHas('conditions', ['name' => $condition->name]);
    }

    public function testStoreWithValidationError(): void
    {
        $condition = Condition::factory()->make(['name' => '']);
        $response = $this->postJson(route('api.products.conditions.store'), $condition->toArray());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name' => 'The name field is required.'], $responseKey = 'errors');
        $this->assertDatabaseMissing('conditions', ['name' => $condition->title]);
    }

    public function testShow(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->getJson(route('api.products.conditions.show', $this->condition));

        $response->assertStatus(200)->assertJson(['data' => ['name' => $this->condition->name]]);
        // $response->dd();
    }

    public function testUpdate(): void
    {
        $condition1 = Condition::factory()->make();
        $response = $this->putJson(route('api.products.conditions.update', $this->condition), $condition1->toArray());

        $response->assertJsonIsObject();
        $response->assertStatus(200)->assertJson(['name' => $condition1->name]);
        $this->assertDatabaseHas('conditions', ['name' => $condition1->name]);
    }

    public function testUpdateWithValidationError(): void
    {
        $condition1 = Condition::factory()->make(['name' => '']);
        $response = $this->putJson(route('api.products.conditions.update', $this->condition), $condition1->toArray());

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('name', $responseKey = 'errors');
        $this->assertDatabaseMissing('conditions', ['name' => $condition1->name]);
    }

    public function testDestroy(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->deleteJson(route('api.products.conditions.destroy', $this->condition));

        // $response->assertStatus(204);
        $response->assertNoContent($status = 204);
        $this->assertDatabaseMissing('conditions', ['name' => $this->condition->name]);
    }
}
