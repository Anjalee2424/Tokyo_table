<?php
require_once 'db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $recipe_id = (int)$_GET['id'];

    // Fetch recipe + category
    $stmt = $pdo->prepare("
        SELECT recipes.*, categories.name AS category_name
        FROM recipes
        JOIN categories ON recipes.category_id = categories.id
        WHERE recipes.id = ?
    ");
    $stmt->execute([$recipe_id]);
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$recipe) {
        die('Recipe not found.');
    }
} else {
    die('Invalid recipe ID.');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($recipe['title']) ?> | Recipe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            margin: 0;
            background: #fffafc;
            color: #333;
        }

        header {
            padding: 30px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            font-size: 28px;
            color: #aa4b89;
            margin: 0;
        }

        nav a {
            margin: 0 20px;
            text-decoration: none;
            color: #000;
            font-weight: bold;
        }

        .content {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .content h2 {
            color: #701c56;
            font-size: 28px;
        }

        .content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 20px 0;
        }

        .section {
            margin-top: 30px;
        }

        .section h3 {
            font-size: 20px;
            color: #aa4b89;
            margin-bottom: 10px;
        }

        pre {
            white-space: pre-wrap;
            background: #f9f9f9;
            padding: 15px;
            border-left: 4px solid #fdd835;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <header>
        <h1><span style="color:#aa4b89">Tokyo</span>Table</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="categories.php">Categories</a>
        </nav>
    </header>

    <div class="content">
        <h2><?= htmlspecialchars($recipe['title']) ?></h2>
        <p><strong>Category:</strong> <?= htmlspecialchars($recipe['category_name']) ?></p>
        <?php if (!empty($recipe['image_path'])): ?>
            <img src="<?= htmlspecialchars($recipe['image_path']) ?>" alt="<?= htmlspecialchars($recipe['title']) ?>" />
        <?php endif; ?>

        <div class="section">
            <h3>Ingredients</h3>
            <pre><?= htmlspecialchars($recipe['ingredients']) ?></pre>
        </div>

        <div class="section">
            <h3>Steps</h3>
            <pre><?= htmlspecialchars($recipe['steps']) ?></pre>
        </div>

        <p><small>Posted on: <?= htmlspecialchars($recipe['created_at']) ?></small></p>
    </div>

</body>

</html>