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
    margin: 0; padding: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #72edf2 10%, #5151e5 90%);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .login-container {
    background: white;
    padding: 2.5rem 3.5rem;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    width: 350px;
    text-align: center;
    animation: fadeIn 0.8s ease forwards;
  }
  @keyframes fadeIn {
    from {opacity: 0; transform: translateY(20px);}
    to {opacity: 1; transform: translateY(0);}
  }
  h2 {
    margin-bottom: 2rem;
    color: #333;
    font-weight: 600;
    font-size: 1.9rem;
  }
  input[type=text], input[type=password] {
    width: 100%;
    padding: 0.75rem 1rem;
    margin-bottom: 1.3rem;
    border: 2px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
  }
  input[type=text]:focus,
  input[type=password]:focus {
    border-color: #5151e5;
    outline: none;
    box-shadow: 0 0 8px rgba(81, 81, 229, 0.5);
  }
  button {
    width: 100%;
    padding: 0.85rem 0;
    border: none;
    background: linear-gradient(90deg, #5151e5, #72edf2);
    color: white;
    font-size: 1.15rem;
    font-weight: 600;
    border-radius: 10px;
    cursor: pointer;
    transition: background 0.3s ease;
  }
  button:hover {
    background: linear-gradient(90deg, #72edf2, #5151e5);
  }
  .error {
    color: #e74c3c;
    margin-top: 1rem;
    font-weight: 600;
  }
  @media (max-width: 400px) {
    .login-container {
      width: 90%;
      padding: 2rem 1.5rem;
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
  </div>
</body>
</html>
