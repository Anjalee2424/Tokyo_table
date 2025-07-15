<?php
require_once 'db.php';

if (isset($_GET['category_id']) && is_numeric($_GET['category_id'])) {
  $category_id = (int)$_GET['category_id'];

  // Fetch category info
  $catStmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
  $catStmt->execute([$category_id]);
  $category = $catStmt->fetch(PDO::FETCH_ASSOC);

  if (!$category) {
    die('Category not found.');
  }

  // Fetch recipes for this category with category name joined
  $stmt = $pdo->prepare("
        SELECT recipes.*, categories.name AS category_name
        FROM recipes
        JOIN categories ON recipes.category_id = categories.id
        WHERE recipes.category_id = ?
    ");
  $stmt->execute([$category_id]);
  $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
  die('Invalid category ID.');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($category['name']) ?> Recipes</title>
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

    .hero {
      display: flex;
      align-items: center;
      background: #f4f4f4;
      padding: 50px 60px;
    }

    .hero img {
      width: 200px;
      height: 200px;
      object-fit: cover;
      border-radius: 50%;
      margin-right: 40px;
    }

    .hero-content h2 {
      font-size: 32px;
      color: #701c56;
      margin: 0;
    }

    .hero-content p {
      font-size: 16px;
      margin: 10px 0;
    }

    .hero-content a {
      font-weight: bold;
      color: #701c56;
      text-decoration: none;
    }

    .section-title {
      margin: 40px 60px 20px;
      font-size: 22px;
      font-weight: bold;
    }

    .card-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 25px;
      padding: 0 60px 60px;
    }

    .recipe-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      width: 250px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    .recipe-card img {
      width: 100%;
      height: 160px;
      object-fit: cover;
    }

    .card-title {
      background: #fdd835;
      padding: 12px;
      text-align: center;
      font-weight: bold;
      font-size: 16px;
    }

    .card-subtitle {
      text-align: center;
      color: #aa4b89;
      padding: 8px 12px 16px;
      font-size: 14px;
    }

    .no-results {
      text-align: center;
      padding: 40px;
      font-size: 18px;
      color: #999;
    }
  </style>
</head>

<body>

  <header>
    <h1><span style="color:#aa4b89">Tokyo</span>Table</h1>
    <nav>
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="categories.php">Categories</a>
      <a href="start.php">Start Here</a>
    </nav>
  </header>

  <section class="hero">
    <img src="<?= htmlspecialchars($category['image_path'] ?? 'images/default-category.jpg') ?>" alt="<?= htmlspecialchars($category['name']) ?>" />
    <div class="hero-content">
      <h2><?= htmlspecialchars($category['name']) ?></h2>
      <p><?= nl2br(htmlspecialchars($category['description'])) ?></p>
      <?php if (!empty($category['featured_recipe_name'])): ?>
        <p><strong>FEATURED RECIPE:</strong> <a href="#"><?= htmlspecialchars($category['featured_recipe_name']) ?></a></p>
      <?php endif; ?>
    </div>
  </section>

  <h2 class="section-title">More <?= htmlspecialchars($category['name']) ?> Ideas</h2>

  <?php if (count($recipes) > 0): ?>
    <div class="card-grid">
      <?php foreach ($recipes as $recipe): ?>
        <a href="recipe_detail.php?id=<?= $recipe['id'] ?>" style="text-decoration:none;color:inherit">
          <div class="recipe-card">
            <?php if (!empty($recipe['image_path'])): ?>
              <img src="<?= htmlspecialchars($recipe['image_path']) ?>" alt="<?= htmlspecialchars($recipe['title']) ?>" />
            <?php endif; ?>
            <div class="card-title"><?= htmlspecialchars($recipe['title']) ?></div>
            <div class="card-subtitle"><?= htmlspecialchars($recipe['category_name']) ?></div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="no-results">No recipes found in this category.</div>
  <?php endif; ?>

</body>

</html>