<?php

class CartController extends Controller
{
    private Cart $cart;
    private CartItem $cartItem;
    private Product $product;

    public function __construct()
    {
        parent::__construct();
        $this->cart = new Cart();
        $this->cartItem = new CartItem();
        $this->product = new Product();
    }

    public function index(): string
    {
        $cartId = $this->ensureCart();
        $items = $this->cartItem->forCart($cartId);
        Session::put('cart_items_count', $this->cartItem->countByCart($cartId));

        return $this->view('frontend/cart/index', [
            'title' => 'Giỏ hàng',
            'items' => $items,
            'csrf' => Security::csrfToken(),
        ]);
    }

    public function add(): void
    {
        if (!Security::validateCsrf($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            exit('Invalid CSRF token');
        }

        $cartId = $this->ensureCart();
        $productId = (int)($_POST['product_id'] ?? 0);
        $variantId = (int)($_POST['variant_id'] ?? 0);
        $quantity = max(1, (int)($_POST['quantity'] ?? 1));

        $product = $this->product->find($productId);
        if (!$product) {
            http_response_code(400);
            exit('Product not found');
        }

        $this->cartItem->upsert([
            'cart_id' => $cartId,
            'product_id' => $productId,
            'variant_id' => $variantId ?: null,
            'quantity' => $quantity,
        ]);

        Session::put('cart_items_count', $this->cartItem->countByCart($cartId));

        $this->redirect('/gio-hang');
    }

    public function redirectToContact(): void
    {
        $this->redirect('/lien-he');
    }

    private function ensureCart(): string
    {
        $cartId = Session::get('cart_id');
        if (!$cartId) {
            $cartId = $this->cart->createCart();
            Session::put('cart_id', $cartId);
        }
        return $cartId;
    }
}

