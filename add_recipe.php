<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$mysqli = new mysqli("localhost", "root", "", "tokyotable");
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];
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

    $stmt = $mysqli->prepare("INSERT INTO recipes (category, title, ingredients, steps, image_path) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $category, $title, $ingredients, $steps, $image_path);
    if ($stmt->execute()) {
        $message = "Recipe saved successfully!";
    } else {
        $message = "Error saving recipe: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Add Recipe - Tokyo Table</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background: #eef2f7;
    padding: 2rem;
  }
  h2 {
    color: #333;
  }
  form {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    max-width: 600px;
  }
  input[type=text], textarea, input[type=file] {
    width: 100%;
    padding: 0.6rem 0.8rem;
    margin-bottom: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
  }
  textarea {
    resize: vertical;
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
  .logout {
    margin-top: 1rem;
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
  <h2>Add a New Recipe</h2>
  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="category" placeholder="Category" required />
    <input type="text" name="title" placeholder="Title" required />
    <textarea name="ingredients" rows="4" placeholder="Ingredients" required></textarea>
    <textarea name="steps" rows="6" placeholder="Steps" required></textarea>
    <input type="file" name="image" accept="image/*" />
    <button type="submit">Save Recipe</button>
  </form>
  <?php if ($message): ?>
    <p class="message"><?= htmlspecialchars($message) ?></p>
  <?php endif; ?>
  <div class="logout">
    <a href="logout.php">Logout</a>
  </div>
</body>
</html>
