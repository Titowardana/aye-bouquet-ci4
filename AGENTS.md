# AGENTS.md — ci4_web_bucket_umkm

CodeIgniter 4 project for **Aye Bouquet** — UMKM bucket/gift/custom product catalog + WhatsApp ordering.

## Quick start

```bash
php spark serve                    # dev server at localhost:8080
php spark migrate                  # run migrations (db: db_bucket_umkm)
php spark db:seed InitialDataSeeder
```

## Architecture

- **Framework**: CodeIgniter 4.6.x, PHP 8.2+, MySQL, Tailwind CSS (CDN), Plus Jakarta Sans font, Material Symbols icons, SweetAlert2, Animate.css
- **Auth**: Two separate session-based auth systems — `UserAuth` filter (`logged_in` session key) for customers, `AdminAuth` filter (`admin_logged_in`) for admins
- **Routes use Indonesian paths**: `/katalog`, `/produk/{slug}`, `/keranjang`, `/checkout`, `/custom-order`, admin under `/admin/...`
- **Cart**: Session-based (`session('cart')` array), not database-persisted; product_id+variant_id uniqueness, qty increments on re-add
- **Checkout**: Saves order to DB (`orders`, `order_items`), then redirects to WhatsApp with encoded message
- **Views**: CI4 View Layout pattern (`$this->include()`, `$this->renderSection()`); main layout at `Views/layouts/main.php`
- **No tests directory exists** — no phpunit config at root; `composer test` runs `phpunit` but won't work yet
- **No php-cs-fixer config at root** (utils/ directory with it doesn't exist); `composer cs` / `composer cs-fix` won't work
- **Global lightbox**: Testimonial photo lightbox modal is in `Views/layouts/main.php`, JS in `public/assets/js/main.js` — available on every page

## Route structure (non-obvious)

| Pattern | Filter | Notes |
|---|---|---|
| `/keranjang/*` | `userAuth` | Login required |
| `/checkout/*` | `userAuth` | Login required |
| `/admin/*` | `adminAuth` | Except `/admin/login` and `/admin/logout` |
| `/custem-order`, `/custem_order` | none | Aliases for `/custom-order` (typo kept for backward compat) |
| `/tentang-kami` | none | Alias for `/tentang` |

## Key conventions

- **Controllers** extend `BaseController`; namespace `App\Controllers`; no auto-DI, manually instantiate models
- **Models** extend `CodeIgniter\Model`; table names match snake_case plural of class (e.g. `ProductModel` → `products`)
- **Product status**: `Ready`, `Pre-order`, `Habis` — affects button behavior (cart vs WhatsApp vs disabled)
- **CSRF**: All POST forms must include `<?= csrf_field() ?>`
- **Output escaping**: Use `<?= esc($var) ?>` in views
- **Brand**: "Aye Bouquet" (stored in title/view data, not hardcoded everywhere)
- **Colors**: Mauve primary (#795465), cream background (#fbf9f8), soft pink accents — see Tailwind config in `Views/layouts/main.php`
- **Phone number**: WhatsApp number stored in `settings` table, editable via admin contact page — never hardcode

## Product variant management

Variants (sizes S/M/L/XL/XXL/Jumbo with prices) are managed on a dedicated admin page at `/admin/produk/{id}/varian`, not inline in product create/edit form.

## Migration quirks

- `CreateUsersTable` default role is `user` (not `admin`) for safety
- `CreateOrdersTable` default status is `baru`
- `2026-06-03-010000_AddSkuProductUrlToOrderItems.php` is a supplemental migration for existing databases that already migrated before SKU/product_url columns were added
- `2026-06-06-020000_DropNameFromTestimonials.php` drops duplicate `name` column from `testimonials` (keep `customer_name`)

## Demo accounts (from seeder)

| Role | Email | Password |
|---|---|---|
| Admin | admin@bespokebloom.com | admin123 |
| Customer | pelanggan@example.com | user12345 |

## Working rules (do not violate)

1. **No rewrite** — never rewrite the entire project. Always make targeted fixes.
2. **No massive UI changes** — keep the existing design system (Tailwind, layout, style).
3. **No feature removal** — never delete working features.
4. **Brand is Aye Bouquet** — never change the brand name.
5. **Database changes only when necessary** — if needed, explain first and provide SQL/migration.
6. **Preserve form attributes** — never remove `csrf_field()`, `method`, `action`, `name`, `id`, `enctype`, or other critical form attributes.
7. **No new libraries unless required** — avoid adding dependencies.
8. **No fake/dummy data** — never display hardcoded ratings, review counts, or placeholder data that looks real. If no data exists, show "Belum ada ulasan" or similar empty state.
9. **Check before editing** — always check routes, controller, model, view, and JS/CSS files before making changes.
10. **PHP lint** — run `php -l` on every changed PHP file.
11. **No encoding corruption** — ensure no broken characters like â, Â, â€", â˜… appear in output.
12. **Don't store images as BLOB** — images are stored in upload folders; database only stores the filename/path.
13. **Sync field names** — form input names, controller getPost() keys, model allowedFields, and DB column names must match. Always DESCRIBE the table before changing field mappings.

## History of completed fixes

### 1. Category active/inactive toggle
- Toggle saves to database via standard POST form (not AJAX) to avoid CSRF regeneration issues.
- Inactive categories hidden from Beranda and Katalog.
- Products from inactive categories hidden from frontend.
- After toggle/delete, redirect to `/admin/kategori` — never use `redirect()->back()` because it may redirect to the frontend homepage.

### 2. Category delete
- Delete icon (trash) hover clickability fixed by adding `z-10 pointer-events-auto` to the action wrapper and `cursor-pointer` to the button.
- Categories without products can be deleted.
- Categories with products cannot be deleted (shows error message).

### 3. Testimonial submission & approval
- **Route**: `POST /testimoni` → `Testimoni::store()` added.
- Submission stores with `is_approved = 0` (pending).
- Admin can approve/unapprove and delete testimonials.
- Approved testimonials appear on `/testimoni` and Beranda.
- Pending testimonials never shown on frontend.
- Testimonial form rating stars: active = `text-primary` (brand mauve), inactive = `text-gray-300` (light gray). Hover preview works; mouse leave restores selected value.
- Photo display on `/testimoni`: `w-32 h-32`, centered, with lightbox modal.
- Photo display on Beranda: `w-24 h-24`, centered, same lightbox (global modal in layout, JS in main.js).

### 4. Rating dummy on Popular Products
- Hardcoded `(50)` review count and 5 filled stars removed from home.php.
- Replaced with "Belum ada ulasan" text.
- No product rating system exists yet (ratings only in `testimonials` table per testimonial, not aggregated per product).

## Database note — testimonials table

Always check the actual table structure before editing testimonial code:

```sql
DESCRIBE testimonials;
```

Current columns (after migrations): `id`, `city`, `customer_name`, `message`, `rating`, `product_id`, `photo`, `is_approved`, `created_at`, `updated_at`.

**Field mapping (form → DB):**

| Form input | Controller getPost | DB column |
|---|---|---|
| `name` | `getPost('name')` → `customer_name` | `customer_name` |
| `city` | `getPost('city')` | `city` |
| `review` | `getPost('review')` → `message` | `message` |
| `rating` | `getPost('rating')` | `rating` |
| `foto` | `getFile('foto')` → `photo` | `photo` |

## Upload guidelines

- Images stored in upload folders, not as BLOBs in the database.
- Upload paths:
  - `public/uploads/products/`
  - `public/uploads/categories/`
  - `public/uploads/testimonials/`
  - `public/uploads/gallery/`
- Database stores only the filename (string).
- Validate file type (JPG, JPEG, PNG, etc.) and file size (max 5MB for testimonials, 2MB for categories, etc.).
- When a record is deleted or an image is replaced, delete the old file if it is safe and not referenced by other data.
- Always call `$file->getRandomName()` before `$file->move()` to avoid filename collisions.

## Pending tasks

1. **Checkout & orders** — verify checkout saves orders and order items correctly, WhatsApp redirect works, order message is complete, admin can view and update order status.
2. **Admin feature audit** — verify all admin CRUD for: Products, Categories, Orders, Contact/Settings, Gallery, FAQ, Testimonials.
3. **Product rating system** — if needed in the future, aggregate testimonial ratings by `product_id` in the `testimonials` table. For now, no product rating system exists.

## General testing flow

1. Login as admin (`admin@bespokebloom.com` / `admin123`).
2. Test category active/inactive toggle — inactive should not appear on frontend.
3. Test category delete — with and without products.
4. Submit a testimonial as a guest — verify pending status.
5. Approve the testimonial in admin — verify it appears on `/testimoni` and Beranda.
6. Click testimonial photo — lightbox modal opens on both pages.
7. Test checkout flow — submit an order, verify WhatsApp redirect.
8. Check admin orders — status update works.
9. Test image upload — valid types pass, invalid types rejected, file size limits enforced.
10. Verify no hardcoded dummy data (ratings, review counts) exists anywhere.

## Constraints from project brief (do not violate)

- **No payment gateway** — all payments manual via WhatsApp
- **No stock tracking** — product status is manual (Ready/Pre-order/Habis)
- **Guest can browse** — login only required for cart/checkout
- **MVP scope** — avoid overbuilding features not in the checklist
- **WhatsApp number must be configurable** — stored in DB, not hardcoded
