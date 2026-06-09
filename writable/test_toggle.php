<?php
// Bootstrap CI4
require __DIR__ . '/../app/Config/Paths.php';
$paths = new Config\Paths();
require rtrim($paths->systemDirectory, '\\/ ') . '/Boot.php';
$app = \CodeIgniter\Boot::bootWeb($paths);

// Simulate what the controller does
$categoryModel = new \App\Models\CategoryModel();

$id = 7;

// Step 1: Find category
$category = $categoryModel->find($id);
echo "Before toggle:" . PHP_EOL;
echo "  ID: " . $category['id'] . PHP_EOL;
echo "  Name: " . $category['name'] . PHP_EOL;
echo "  is_active: " . $category['is_active'] . PHP_EOL;
echo PHP_EOL;

$oldStatus = $category['is_active'];
$newStatus = $oldStatus ? 0 : 1;
echo "Old status: " . $oldStatus . PHP_EOL;
echo "New status: " . $newStatus . PHP_EOL;
echo PHP_EOL;

// Step 2: Update using model
echo "Method 1: Model::update()" . PHP_EOL;
$result1 = $categoryModel->update($id, ['is_active' => $newStatus]);
echo "  Result: " . ($result1 ? 'true' : 'false') . PHP_EOL;

$after1 = $categoryModel->find($id);
echo "  After update, is_active = " . $after1['is_active'] . PHP_EOL;

// Reset
$categoryModel->update($id, ['is_active' => $oldStatus]);
echo PHP_EOL;

// Step 3: Update using direct query builder
echo "Method 2: Query builder directly" . PHP_EOL;
$db = \Config\Database::connect();
$result2 = $db->table('categories')
    ->where('id', $id)
    ->update([
        'is_active' => $newStatus,
        'updated_at' => date('Y-m-d H:i:s')
    ]);
echo "  Result: " . ($result2 ? 'true' : 'false') . PHP_EOL;

$after2 = $categoryModel->find($id);
echo "  After update, is_active = " . $after2['is_active'] . PHP_EOL;

// Reset back
$categoryModel->update($id, ['is_active' => $oldStatus]);
echo PHP_EOL;

echo "Final state:" . PHP_EOL;
$final = $categoryModel->find($id);
echo "  ID: " . $final['id'] . " is_active: " . $final['is_active'] . PHP_EOL;
echo PHP_EOL;

echo "Test completed." . PHP_EOL;
