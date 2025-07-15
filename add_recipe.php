<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = $_POST['category'];
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];

    $image_path = '';
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0755);
        $target_file = $target_dir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO recipes (category_id, title, ingredients, steps, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$category_id, $title, $ingredients, $steps, $image_path]);
        $message = "🎉 Recipe saved successfully!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}

$categories = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe - Tokyo Table</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to bottom right, #a0f0f9, #fce4ec);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .container {
            background: white;
            border-radius: 16px;
            padding: 2rem 2.5rem;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        h2 {
            margin-bottom: 1.5rem;
            color: #333;
            text-align: center;
        }

        select, input[type="text"], textarea, input[type="file"] {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        textarea {
            resize: vertical;
        }

        button {
            background: #ff4081;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.2rem;
            font-size: 1rem;
            width: 100%;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #e91e63;
        }

        .message {
            margin-top: 1rem;
            text-align: center;
            font-weight: bold;
            color: green;
        }

        .logout {
            margin-top: 1.5rem;
            text-align: center;
        }

        .logout a {
            color: #0077cc;
            text-decoration: none;
        }

        .logout a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>🍱 Add a New Recipe</h2>
    <form method="POST" enctype="multipart/form-data">
        <select name="category" required>
            <option value="">-- Select Category --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= htmlspecialchars($cat['id']) ?>">
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="title" placeholder="Recipe Title" required />
        <textarea name="ingredients" rows="4" placeholder="Ingredients (e.g. 1 cup rice, 2 tsp salt)" required></textarea>
        <textarea name="steps" rows="6" placeholder="Cooking Steps" required></textarea>
        <input type="file" name="image" accept="image/*" />
        <button type="submit">📌 Save Recipe</button>
    </form>

    <?php if ($message): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <div class="logout">
        <a href="logout.php">🔓 Logout</a>
    </div>
</div>

</body>
</html>
