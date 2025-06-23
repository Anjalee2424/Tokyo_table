<?php
require_once 'db.php'; // PDO接続

// 最新4件のレシピ取得
$recipes = $pdo->query("
    SELECT r.title, r.image_path, c.name AS category
    FROM recipes r
    JOIN categories c ON r.category_id = c.id
    ORDER BY r.created_at DESC
    LIMIT 4
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TokyoTable</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Open+Sans&display=swap" rel="stylesheet" />
</head>
<body>
  <div class="top-bar">
    <p>❤️ Your Daily Taste of Tokyo. <a href="#">Sign Up</a></p>
  </div>
  <header class="main-header">
    <h1 class="logo">Tokyo<span>Table</span></h1>
    <nav>
      <a href="#">Home</a>
      <a href="#">About</a>
      <a href="#">Recipes</a>
      <a href="login.php">Start Here</a>
    </nav>
    <div class="search">
      <input type="text" placeholder="Search our recipes" />
    </div>
  </header>

  <section class="tagline">
    <p>SIMPLE RECIPES MADE FOR <em>real, actual, everyday life</em>.</p>
  </section>

  <section class="featured-recipes">
    <div class="card">
      <img src="images/dessert-bars.jpg" alt="Dessert" />
      <a href="desserts.php"><button>DESSERTS</button></a>
    </div>
    <div class="card">
      <img src="images/popular.jpg" alt="Most Popular" />
      <button>MOST POPULAR</button>
    </div>
    <div class="card">
      <img src="images/dinner.jpg" alt="Dinner" />
      <button>DINNER</button>
    </div>
    <div class="card">
      <img src="images/healthy.jpg" alt="Healthy" />
      <button>HEALTHY</button>
    </div>
  </section>

  <!-- 最新レシピを動的に表示 -->
  <section class="recipe-thumbnails">
    <?php if (!empty($recipes)): ?>
      <?php foreach ($recipes as $recipe): ?>
        <div class="recipe-card">
          <img src="<?= htmlspecialchars($recipe['image_path']) ?>" alt="<?= htmlspecialchars($recipe['title']) ?>" />
          <span class="category"><?= htmlspecialchars($recipe['category']) ?></span>
          <h4><?= htmlspecialchars($recipe['title']) ?></h4>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No recipes found.</p>
    <?php endif; ?>
  </section>

  <!-- Footer -->
  <footer class="site-footer">
    <div class="footer-columns">
      <div class="footer-col">
        <h5>PINCH OF YUM</h5>
        <ul>
          <li><a href="#">About</a></li>
          <li><a href="#">Blog</a></li>
          <li><a href="#">Recipe Index</a></li>
          <li><a href="#">Blogging Resources</a></li>
          <li><a href="#">Income Reports</a></li>
          <li><a href="#">Media Mentions</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h5>FOOD & RECIPES</h5>
        <ul>
          <li><a href="#">Sugar Free January</a></li>
          <li><a href="#">Travel Meals 101</a></li>
          <li><a href="#">Quick and Easy Recipes</a></li>
          <li><a href="#">Slow Cooker Recipes</a></li>
          <li><a href="#">Pasta Recipes</a></li>
          <li><a href="#">Vegan Recipes</a></li>
          <li><a href="#">Soup Recipes</a></li>
          <li><a href="#">Taco Recipes</a></li>
          <li><a href="#">Meal Prep Recipes</a></li>
        </ul>
      </div>
    </div>

    <div class="footer-social-brand">
      <div class="footer-social">
        <a href="#"><img src="images/icon-instagram.jpg" alt="Instagram" /></a>
        <a href="#"><img src="images/icon-pinterest.jpg" alt="Pinterest" /></a>
        <a href="#"><img src="images/icon-tiktok.jpg" alt="TikTok" /></a>
        <a href="#"><img src="images/icon-facebook.jpg" alt="Facebook" /></a>
        <a href="#"><img src="images/icon-youtube.jpg" alt="YouTube" /></a>
      </div>
      <div class="footer-logo">
        <img src="images/logo-pinch-of-yum.png" alt="Tokyo Table" />
      </div>
    </div>

    <div class="footer-legal">
      <p>&copy; 2025 Pinch of Yum. All rights reserved. A Digital Partner Site.</p>
      <p><a href="#">Privacy Policy</a> | <a href="#">Terms</a></p>
      <p>Information from your device can be used to personalize your experience.</p>
      <p><a href="#">Do not sell or share my personal information.</a></p>
    </div>

    <div class="footer-brands">
      <p>OUR OTHER BRANDS</p>
      <img src="images/logo-food-blogger-pro.png" alt="Food Blogger Pro" />
      <img src="images/logo-clariti.png" alt="Clariti" />
    </div>
  </footer>

  <!-- Floating Like Button -->
  <div class="like-button">
    <img src="images/heart-icon.png" alt="Like" />
  </div>

  <footer>
    <p>&copy; 2025 TokyoTable. All Rights Reserved.</p>
  </footer>
</body>
</html>