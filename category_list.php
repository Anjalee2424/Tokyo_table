<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

// カテゴリー一覧取得
$categories = $pdo->query("SELECT id, name, image_path FROM categories ORDER BY name")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Category List - Tokyo Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f7;
            padding: 2rem;
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }

        th {
            background: #0077cc;
            color: white;
        }

        img {
            max-width: 100px;
            height: auto;
            border-radius: 6px;
        }

        a.edit-link {
            color: #0077cc;
            text-decoration: none;
        }

        a.edit-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h2>Admin Category List</h2>
    <?php if ($categories): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?= htmlspecialchars($cat['id']) ?></td>
                        <td><?= htmlspecialchars($cat['name']) ?></td>
                        <a href="recipes.php?category_id=<?= htmlspecialchars($cat['id']) ?>">
  <?= htmlspecialchars($cat['name']) ?>
</a>

                        <td>
                            <?php if ($cat['image_path']): ?>
                                <img src="<?= htmlspecialchars($cat['image_path']) ?>" alt="<?= htmlspecialchars($cat['name']) ?>" /><a href="recipes.php?category_id=<?= htmlspecialchars($cat['id']) ?>">
  <?= htmlspecialchars($cat['name']) ?>
</a>

                            <?php else: ?>
                                <span>No image</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a class="edit-link" href="edit_category.php?id=<?= urlencode($cat['id']) ?>">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No categories found.</p>
    <?php endif; ?>
</body>

</html>