<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "tokyotable");
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT password_hash FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hash);
    if ($stmt->fetch() && password_verify($password, $hash)) {
        $_SESSION['user'] = $username;
        header("Location: add_recipe.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - Tokyo Table</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #ff9a9e 0%, #00f2fe 100%);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: url('images/backgroundlogin.jpg') no-repeat center center fixed;
      background-size: cover;
    }
    .login-container {
      background: white;
      padding: 2.5rem 3rem;
      border-radius: 18px;
      box-shadow: 0 15px 40px rgba(0, 242, 254, 0.3), 0 5px 15px rgba(255, 154, 158, 0.3);
      width: 360px;
      text-align: center;
      animation: fadeIn 0.8s ease forwards;
    }
    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(20px);}
      to {opacity: 1; transform: translateY(0);}
    }
    h2 {
      margin-bottom: 1.8rem;
      color: #ff6fa7;
      font-weight: 600;
      font-size: 2rem;
    }
    input[type=text], input[type=password] {
      width: 100%;
      padding: 0.75rem 1rem;
      margin-bottom: 1.2rem;
      border: 2px solid #87e0fd;
      border-radius: 10px;
      font-size: 1rem;
      transition: 0.3s ease;
    }
    input[type=text]:focus,
    input[type=password]:focus {
      border-color: #ff6fa7;
      outline: none;
      box-shadow: 0 0 8px rgba(255, 111, 167, 0.4);
    }
    button {
      width: 100%;
      padding: 0.9rem;
      background: linear-gradient(90deg, #ff6fa7, #00f2fe);
      border: none;
      color: white;
      font-size: 1.1rem;
      font-weight: bold;
      border-radius: 10px;
      cursor: pointer;
      transition: background 0.4s ease;
    }
    button:hover {
      background: linear-gradient(90deg, #00f2fe, #ff6fa7);
    }
    .error {
      color: #e53935;
      font-weight: 600;
      margin-top: 1rem;
    }
    /* New signup link styles */
    .signup-link {
      margin-top: 1.4rem;
      font-weight: 600;
      color: #444;
    }
    .signup-link a {
      color: #ff6fa7;
      text-decoration: none;
      font-weight: 700;
      transition: color 0.3s ease;
    }
    .signup-link a:hover {
      color: #00f2fe;
      text-decoration: underline;
    }
    @media (max-width: 420px) {
      .login-container {
        width: 90%;
        padding: 2rem;
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Login to Tokyo Table</h2>
    <form method="POST" novalidate>
      <input type="text" name="username" placeholder="Username" required autofocus />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit">Login</button>
      <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>
    </form>
    <p class="signup-link">
      Don't have an account? 
      <a href="register.php">Create one here</a>
    </p>
  </div>
</body>
</html>
