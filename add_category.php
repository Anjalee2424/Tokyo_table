<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

$message = '';
$category_message = '';

// カテゴリー追加処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $cat_name = trim($_POST['category_name']);
    $cat_image_path = '';

    if ($cat_name === '') {
        $category_message = 'Category name cannot be empty.';
    } else {
        // 画像アップロード処理（あれば）
        if (!empty($_FILES['category_image']['name'])) {
            $target_dir = "uploads/categories/";
            if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);
            $target_file = $target_dir . basename($_FILES['category_image']['name']);
            if (move_uploaded_file($_FILES['category_image']['tmp_name'], $target_file)) {
                $cat_image_path = $target_file;
            }
        }
        // DB登録
        try {
            $stmt = $pdo->prepare("INSERT INTO categories (name, image_path) VALUES (?, ?)");
            $stmt->execute([$cat_name, $cat_image_path]);
            $category_message = "Category added successfully!";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // 重複エラーコード
                $category_message = "Category name already exists.";
            } else {
                $category_message = "Error adding category: " . $e->getMessage();
            }
        }
    }
}

// レシピ追加処理（省略、元のコードと同じ）
// ...

// カテゴリー一覧取得
$categories = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Add Recipe - Tokyo Table</title>
<style>
/* 省略（元のCSSを使う） */
</style>
</head>
<body>

<h2>Add a New Category</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="category_name" placeholder="Category Name" required />
    <input type="file" name="category_image" accept="image/*" />
    <button type="submit" name="add_category">Add Category</button>
</form>
<?php if ($category_message): ?>
    <p class="message"><?= htmlspecialchars($category_message) ?></p>
<?php endif; ?>

<hr>

<h2>Add a New Recipe</h2>
<form method="POST" enctype="multipart/form-data">
    <select name="category" required>
        <option value="">-- Select Category --</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= htmlspecialchars($cat['id']) ?>">
                <!-- <?= htmlspecialchars($cat['name']) ?> -->
                 
            </option>
        <?php endforeach; ?>
    </select>
    <input type="text" name="title" placeholder="Title" required />
    <textarea name="ingredients" rows="4" placeholder="Ingredients" required></textarea>
    <textarea name="steps" rows="6" placeholder="Steps" required></textarea>
    <input type="file" name="image" accept="image/*" />
    <button type="submit" name="add_recipe">Save Recipe</button>
</form>
<?php if ($message): ?>
    <p class="message"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<div class="logout">
    <a href="logout.php">Logout</a>
</div>

</body>
</html>
