<?php

if (! function_exists('session_cart_key')) {
    function session_cart_key(): string
    {
        $userId = session('user_id');
        return $userId ? 'cart_user_' . $userId : 'cart_guest';
    }
}

if (! function_exists('session_cart_items')) {
    function session_cart_items(): array
    {
        return session(session_cart_key()) ?? [];
    }
}

if (! function_exists('session_cart_badge_count')) {
    function session_cart_badge_count(): int
    {
        $items = session_cart_items();
        return array_sum(array_map(static fn($i) => (int) ($i['qty'] ?? 0), $items));
    }
}
