<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>About Us – Cultural Food Journey</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
<style>
  /* Reset */
  * {
    box-sizing: border-box;
  }
  body {
    margin: 0; padding: 0;
    font-family: 'Poppins', sans-serif;
    background: url('images/about.jpg') no-repeat center center fixed;
    background-size: cover;
    color: #2c3e50;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 40px 20px;
  }
  nav {
    width: 900px;
    max-width: 100%;
    display: flex;
    justify-content: flex-end;
    gap: 2.5rem;
    background: linear-gradient(90deg, #ff6fa7, #00f2fe);
    padding: 1rem 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(255,111,167,0.3);
    margin-bottom: 30px;
  }
  nav a {
    color: white;
    font-weight: 600;
    text-decoration: none;
    font-size: 1.1rem;
    letter-spacing: 0.05em;
    transition: color 0.3s ease;
  }
  nav a:hover {
    color: #ffdde1;
    text-decoration: underline;
  }

  .about-container {
    background: white;
    max-width: 900px;
    width: 100%;
    padding: 50px 60px;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(44, 62, 80, 0.15);
    animation: fadeInUp 1s ease forwards;
  }
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  h1 {
    margin-bottom: 30px;
    font-weight: 600;
    font-size: 2.8rem;
    color: #e67e22;
    text-align: center;
    letter-spacing: 1.1px;
  }
  p {
    font-size: 1.15rem;
    line-height: 1.7;
    margin-bottom: 28px;
    color: #34495e;
  }
  p:first-of-type {
    font-weight: 600;
    color: #2c3e50;
  }
  /* Responsive */
  @media (max-width: 600px) {
    nav {
      justify-content: center;
      gap: 1.5rem;
      padding: 1rem;
    }
    .about-container {
      padding: 30px 20px;
    }
    h1 {
      font-size: 2rem;
    }
  }
</style>
</head>
<body>

<nav>
  <a href="index.php">Home</a>
  <a href="start_here.php">Start Here</a>
</nav>

<div class="about-container">
  <h1>🍽️ Explore the World Through Cultural Foods</h1>
  <p>
    Food is more than just nourishment — it’s a story of tradition, history, and identity. On this page, we highlight featured recipes that celebrate the unique flavors and rich heritage of cultures around the world. From the aromatic spices of Thai street food to the comforting warmth of Mediterranean home cooking, each dish tells a tale of the people and places it comes from.
  </p>
  <p>
    Whether you're discovering a new cuisine or reconnecting with familiar tastes from home, our featured cultural foods invite you on a journey across borders — all from your kitchen.
  </p>
</div>

</body>
</html>
