<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_api_returns_paginated_list(): void
    {
        $category = Category::factory()->create();
        Product::factory()->count(5)->create(['category_id' => $category->id]);

        $response = $this->getJson('/api/products');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'slug', 'price', 'stock', 'category'],
                ],
                'meta' => ['current_page', 'last_page', 'total'],
            ]);

        $this->assertCount(5, $response->json('data'));
    }

    public function test_unauthenticated_user_cannot_access_cart(): void
    {
        $this->getJson('/api/cart')->assertUnauthorized();
    }
}
