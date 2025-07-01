<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

$message = '';

// GETパラメータからID取得
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid category ID.');
}

$category_id = (int)$_GET['id'];

// 編集用の既存データ取得
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$category_id]);
$category = $stmt->fetch();

if (!$category) {
    die('Category not found.');
}

// 更新処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $image_path = $category['image_path']; // 元画像パス保持

    if ($name === '') {
        $message = "Category name cannot be empty.";
    } else {
        // 画像アップロード（新しい画像が選択された場合のみ更新）
        if (!empty($_FILES['image']['name'])) {
            $target_dir = "uploads/categories/";
            if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);
            $target_file = $target_dir . basename($_FILES['image']['name']);
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image_path = $target_file;
                // 必要なら古い画像ファイル削除処理をここで
            } else {
                $message = "Failed to upload new image.";
            }
        }

        if ($message === '') {
            // DB更新
            try {
                $stmt = $pdo->prepare("UPDATE categories SET name = ?, image_path = ? WHERE id = ?");
                $stmt->execute([$name, $image_path, $category_id]);
                $message = "Category updated successfully!";
                // 更新後の最新データを再取得
                $category['name'] = $name;
                $category['image_path'] = $image_path;
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    $message = "Category name already exists.";
                } else {
                    $message = "Error updating category: " . $e->getMessage();
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Category - Tokyo Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f7;
            padding: 2rem;
        }

        form {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            max-width: 400px;
        }

        input[type=text],
        input[type=file] {
            width: 100%;
            padding: 0.6rem 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            background: #0077cc;
            color: white;
            padding: 0.7rem 1.2rem;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
        }

        button:hover {
            background: #005fa3;
        }

        .message {
            margin-top: 1rem;
            font-weight: bold;
            color: green;
        }

        .current-image {
            margin-bottom: 1rem;
        }

        .current-image img {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
        }

        a.back-link {
            display: inline-block;
            margin-top: 1rem;
            color: #0077cc;
            text-decoration: none;
        }

        a.back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <h2>Edit Category</h2>

    <form method="POST" enctype="multipart/form-data">
        <label for="name">Category Name</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($category['name']) ?>" required />

        <div class="current-image">
            <p>Current Image:</p>
            <?php if ($category['image_path']): ?>
                <img src="<?= htmlspecialchars($category['image_path']) ?>" alt="<?= htmlspecialchars($category['name']) ?>">
            <?php else: ?>
                <p>No image uploaded.</p>
            <?php endif; ?>
        </div>

        <label for="image">Change Image (optional)</label>
        <input type="file" name="image" id="image" accept="image/*" />

        <button type="submit">Update Category</button>
    </form>

    <?php if ($message): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <a class="back-link" href="category_list.php">← Back to Category List</a>

</body>

</html>