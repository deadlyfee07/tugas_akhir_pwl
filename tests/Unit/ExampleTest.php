<?php

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_user_returns_true_for_is_admin(): void
    {
        $admin = User::factory()->admin()->create();
        $customer = User::factory()->create();

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($customer->isAdmin());
    }

    public function test_cart_total_calculates_correctly(): void
    {
        $cart = Cart::factory()->create();

        CartItem::factory()->count(3)->create([
            'cart_id' => $cart->id,
            'price' => 10000,
            'quantity' => 2,
        ]);

        $this->assertEquals(60000, $cart->fresh()->total());
    }
}
