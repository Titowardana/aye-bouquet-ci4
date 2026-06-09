<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');
$routes->get('/katalog', 'Product::index');
$routes->get('/galeri', 'Galeri::index');
$routes->get('/produk/(:segment)', 'Product::detail/$1');
$routes->get('/custom-order', 'CustomOrder::index');
$routes->get('/login', 'Auth::login');
$routes->get('/register', 'Auth::register');

// Auth routes
$routes->post('/login', 'Auth::attemptLogin');
$routes->post('/register', 'Auth::attemptRegister');
$routes->post('/logout', 'Auth::logout');

// Cart & Checkout Protected Routes
$routes->group('', ['filter' => 'userAuth'], static function ($routes) {
    $routes->get('/keranjang', 'Cart::index');

    // Jika /keranjang/add dibuka langsung lewat browser, jangan 404.
    // Arahkan balik ke katalog.
    $routes->get('/keranjang/add', 'Cart::addRedirect');

    // Proses tambah keranjang tetap wajib POST dari form.
    $routes->post('/keranjang/add', 'Cart::add');

    $routes->post('/keranjang/update', 'Cart::update');
    $routes->post('/keranjang/remove', 'Cart::remove');
    $routes->post('/keranjang/clear', 'Cart::clear');

    $routes->get('/checkout', 'Checkout::index');
    $routes->post('/checkout/process', 'Checkout::process');
});

// Public Pages
$routes->get('/custem-order', 'CustomOrder::index');
$routes->get('/custem_order', 'CustomOrder::index');
$routes->get('/testimoni', 'Testimoni::index');
$routes->post('/testimoni', 'Testimoni::store');
$routes->get('/tentang', 'Tentang::index');
$routes->get('/tentang-kami', 'Tentang::index');
$routes->get('/kontak', 'Kontak::index');

// Admin Routes — login & logout are NOT protected by adminAuth filter
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
    // Auth — public (NO filter)
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::attemptLogin');
    $routes->post('logout', 'Auth::logout');

    // Protected pages — apply adminAuth filter
    $options = ['filter' => 'adminAuth'];

    $routes->get('/', 'Dashboard::index', $options);

    // Product CRUD
    $routes->get('produk', 'Product::index', $options);
    $routes->get('produk/create', 'Product::create', $options);
    $routes->post('produk/store', 'Product::store', $options);
    $routes->get('produk/edit/(:num)', 'Product::edit/$1', $options);
    $routes->post('produk/update/(:num)', 'Product::update/$1', $options);
    $routes->post('produk/delete/(:num)', 'Product::delete/$1', $options);
    $routes->post('produk/delete-image/(:num)', 'Product::deleteImage/$1', $options);

    // Category CRUD
    $routes->get('kategori', 'Category::index', $options);
    $routes->get('kategori/create', 'Category::create', $options);
    $routes->post('kategori/store', 'Category::store', $options);
    $routes->get('kategori/edit/(:num)', 'Category::edit/$1', $options);
    $routes->post('kategori/update/(:num)', 'Category::update/$1', $options);
    $routes->post('kategori/delete/(:num)', 'Category::delete/$1', $options);
    $routes->post('kategori/toggle-status/(:num)', 'Category::toggleStatus/$1', $options);

    // Custom Options CRUD
    $routes->get('custom-options', 'CustomOption::index', $options);
    $routes->post('custom-options/store', 'CustomOption::store', $options);
    $routes->post('custom-options/update/(:num)', 'CustomOption::update/$1', $options);
    $routes->post('custom-options/delete/(:num)', 'CustomOption::delete/$1', $options);
    $routes->post('custom-options/toggle-status/(:num)', 'CustomOption::toggleStatus/$1', $options);

    // Variant Management (dedicated page per product)
    $routes->get('produk/(:num)/varian', 'Variant::index/$1', $options);
    $routes->post('produk/(:num)/varian/store', 'Variant::store/$1', $options);
    $routes->post('varian/delete/(:num)', 'Variant::delete/$1', $options);

    // Gallery CRUD
    $routes->get('galeri', 'Gallery::index', $options);
    $routes->get('galeri/create', 'Gallery::create', $options);
    $routes->post('galeri/store', 'Gallery::store', $options);
    $routes->get('galeri/edit/(:num)', 'Gallery::edit/$1', $options);
    $routes->post('galeri/update/(:num)', 'Gallery::update/$1', $options);
    $routes->post('galeri/delete/(:num)', 'Gallery::delete/$1', $options);
    $routes->post('galeri/toggle-status/(:num)', 'Gallery::toggleStatus/$1', $options);

    // FAQ CRUD
    $routes->get('faqs', 'Faq::index', $options);
    $routes->get('faqs/create', 'Faq::create', $options);
    $routes->post('faqs/store', 'Faq::store', $options);
    $routes->get('faqs/edit/(:num)', 'Faq::edit/$1', $options);
    $routes->post('faqs/update/(:num)', 'Faq::update/$1', $options);
    $routes->post('faqs/delete/(:num)', 'Faq::delete/$1', $options);
    $routes->post('faqs/toggle-status/(:num)', 'Faq::toggleStatus/$1', $options);

    // Testimonial Management
    $routes->get('testimonials', 'Testimonial::index', $options);
    $routes->post('testimonials/delete/(:num)', 'Testimonial::delete/$1', $options);
    $routes->post('testimonials/toggle-status/(:num)', 'Testimonial::toggleStatus/$1', $options);

    // Order Management
    $routes->get('pesanan', 'Order::index', $options);
    $routes->get('pesanan/export-csv', 'Order::exportCsv', $options);
    $routes->get('pesanan/print', 'Order::print', $options);
    $routes->get('pesanan/detail/(:num)', 'Order::detail/$1', $options);
    $routes->post('pesanan/update-status/(:num)', 'Order::updateStatus/$1', $options);
    
    // Contact Settings
    $routes->get('contact', 'Contact::index', $options);
    $routes->post('contact/update', 'Contact::update', $options);
});


