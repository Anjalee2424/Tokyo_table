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
<style>
  body {
    font-family: Arial, sans-serif;
    background: #f7f7f7;
    display: flex;
    height: 100vh;
    justify-content: center;
    align-items: center;
  }
  .login-container {
    background: white;
    padding: 2rem 3rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgb(0 0 0 / 0.1);
    width: 320px;
  }
  h2 {
    margin-bottom: 1.5rem;
    color: #333;
    text-align: center;
  }
  input[type=text], input[type=password] {
    width: 100%;
    padding: 0.6rem 0.8rem;
    margin-bottom: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
  }
  button {
    width: 100%;
    padding: 0.7rem;
    border: none;
    background: #0077cc;
    color: white;
    font-size: 1.1rem;
    border-radius: 5px;
    cursor: pointer;
  }
  button:hover {
    background: #005fa3;
  }
  .error {
    color: red;
    margin-top: 0.5rem;
    text-align: center;
  }
</style>
</head>
<body>
  <div class="login-container">
    <h2>Login to Tokyo Table</h2>
    <form method="POST">
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
