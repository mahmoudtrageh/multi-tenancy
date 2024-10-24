<?php

namespace App\Http\Controllers\Api\Tenant\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }

    public function showCart()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        return response()->json([
            'cart_items' => $cartItems,
            'total' => $cartItems->sum(fn($item) => $item->product->price * $item->quantity),
        ]);
    }
    public function addToCart(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // $product = Product::findOrFail($productId);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            // If the item already exists, increase the quantity
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Otherwise, create a new cart item
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $request->quantity,
            ]);
        }

        return [
            'message' => 'Product added to cart'
        ];
    }

    public function removeFromCart($productId)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->delete();

            return response()->json([
                'message' => 'Product removed from cart successfully!',
            ], 200);
        }

        return response()->json([
            'message' => 'Product not found in cart.',
        ], 404);
    }

    public function increaseQuantity(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            // Increase the quantity
            $cartItem->quantity += $request->quantity;
            $cartItem->save();

            return response()->json([
                'message' => 'Quantity updated successfully!',
                'cart_item' => [
                    'product_id' => $productId,
                    'quantity' => $cartItem->quantity,
                ],
            ], 200);
        }

        return response()->json([
            'message' => 'Product not found in cart.',
        ], 404);
    }
}
