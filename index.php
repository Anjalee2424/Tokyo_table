<?php
require_once 'db.php'; // PDO接続
$sql = "SELECT * FROM categories ORDER BY name";
$categories = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TokyoTable</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Open+Sans&display=swap" rel="stylesheet" />
  <style>
    /* Basic Reset */
    *, *::before, *::after {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      font-family: 'Open Sans', sans-serif;
      background-color: #fafafa;
      color: #333;
      line-height: 1.6;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    a {
      color: #ff6f91; /* soft pink accent */
      text-decoration: none;
      transition: color 0.25s ease;
    }
    a:hover {
      color: #008cba; /* subtle aqua accent */
    }

    /* Top Bar */
    .top-bar {
      width: 100%;
      background-color: #ff6f91;
      color: white;
      font-weight: 600;
      font-size: 0.95rem;
      padding: 0.5rem 0;
      text-align: center;
      user-select: none;
    }
    .top-bar a {
      color: white;
      font-weight: 700;
      margin-left: 0.5rem;
    }
    .top-bar a:hover {
      color: #ffe6ea;
    }

    /* Header */
    .main-header {
      max-width: 960px;
      width: 90%;
      margin: 2rem 0 1.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 1rem;
    }
    .logo {
      font-family: 'Playfair Display', serif;
      font-size: 2.5rem;
      font-weight: 700;
      color: #ff6f91;
      user-select: none;
      letter-spacing: 0.05em;
    }
    nav {
      display: flex;
      gap: 1.5rem;
      font-weight: 600;
    }
    nav a {
      font-size: 1rem;
      padding-bottom: 2px;
      border-bottom: 2px solid transparent;
    }
    nav a:hover {
      border-color: #ff6f91;
    }

    /* Search */
    .search {
      flex-grow: 1;
      max-width: 280px;
      margin-left: auto;
    }
    .search input {
      width: 100%;
      padding: 0.4rem 1rem;
      border: 1.5px solid #ddd;
      border-radius: 20px;
      font-size: 1rem;
      transition: border-color 0.3s ease;
    }
    .search input:focus {
      outline: none;
      border-color: #ff6f91;
      box-shadow: 0 0 6px #ff6f91aa;
      background: white;
    }

    /* Tagline */
    .tagline {
      max-width: 960px;
      width: 90%;
      text-align: center;
      font-family: 'Playfair Display', serif;
      font-size: 1.3rem;
      font-weight: 600;
      margin-bottom: 2rem;
      color: #444;
    }
    .tagline em {
      font-style: normal;
      color: #ff6f91;
      font-weight: 700;
    }

    /* Recipe Grid */
    .recipe-thumbnails {
      max-width: 960px;
      width: 90%;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1.6rem;
      margin-bottom: 3rem;
    }
    .recipe-card {
      background: white;
      border-radius: 8px;
      box-shadow: 0 1.5px 5px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      cursor: pointer;
      transition: box-shadow 0.3s ease, transform 0.25s ease;
      display: flex;
      flex-direction: column;
      user-select: none;
    }
    .recipe-card:hover {
      box-shadow: 0 8px 18px rgba(255, 111, 145, 0.3);
      transform: translateY(-5px);
    }
    .recipe-card img {
      width: 100%;
      height: 140px;
      object-fit: cover;
      display: block;
      border-bottom: 1px solid #eee;
    }
    .category {
      padding: 0.8rem 1rem;
      text-align: center;
      font-weight: 700;
      font-size: 1rem;
      color: #ff6f91;
      flex-grow: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      user-select: none;
    }

    /* Footer */
    .site-footer {
      max-width: 960px;
      width: 90%;
      padding: 2rem 1rem;
      border-top: 1px solid #eee;
      color: #777;
      font-size: 0.9rem;
      text-align: center;
      user-select: none;
      margin-bottom: 2rem;
    }
    .site-footer a {
      color: #ff6f91;
      font-weight: 600;
      margin: 0 0.3rem;
    }
    .site-footer a:hover {
      text-decoration: underline;
      color: #008cba;
    }

    /* Like Button */
    .like-button {
      position: fixed;
      bottom: 24px;
      right: 24px;
      width: 52px;
      height: 52px;
      background: #ff6f91;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      box-shadow: 0 2px 10px rgba(255, 111, 145, 0.4);
      transition: background-color 0.3s ease;
      user-select: none;
    }
    .like-button:hover {
      background: #e65575;
    }
    .like-button img {
      width: 24px;
      height: 24px;
      filter: brightness(0) invert(1);
    }

    /* Responsive tweaks */
    @media (max-width: 620px) {
      .main-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
      }
      .search {
        width: 100%;
        margin-left: 0;
      }
    }
  </style>
</head>

<body>

  <div class="top-bar">
    ❤️ Your Daily Taste of Tokyo. <a href="#">Sign Up</a>
  </div>

  <header class="main-header">
    <h1 class="logo">Tokyo<span>Table</span></h1>
    <nav>
      <a href="#">Home</a>
      <a href="about.php">About</a>
      <a href="#">Recipes</a>
      <a href="login.php">Start Here</a>
    </nav>
    <div class="search">
      <input type="text" placeholder="Search our recipes" aria-label="Search recipes" />
    </div>
  </header>

  <section class="tagline" aria-label="Site tagline">
    SIMPLE RECIPES MADE FOR <em>real, actual, everyday life</em>.
  </section>

  <section class="recipe-thumbnails" aria-label="Recipe categories">
    <?php if (!empty($categories)): ?>
      <?php foreach ($categories as $category): ?>
        <a href="recipe.php?category_id=<?= htmlspecialchars($category['id']) ?>" aria-label="<?= htmlspecialchars($category['name']) ?> category">
          <div class="recipe-card" title="<?= htmlspecialchars($category['name']) ?>">
            <img src="<?= htmlspecialchars($category['image_path']) ?>" alt="<?= htmlspecialchars($category['name']) ?>" loading="lazy" />
            <span class="category"><?= htmlspecialchars($category['name']) ?></span>
          </div>
        </a>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No recipes found.</p>
    <?php endif; ?>
  </section>

  <footer class="site-footer" role="contentinfo">
    <p>&copy; 2025 TokyoTable. All rights reserved. <a href="#">Privacy Policy</a> | <a href="#">Terms</a></p>
  </footer>

  <div class="like-button" title="Like">
    <img src="images/heart-icon.png" alt="Like" />
  </div>

</body>


</html>
