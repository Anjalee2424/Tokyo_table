<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "tokyotable");
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Basic validation
    if (strlen($username) < 3) {
        $error = "Username must be at least 3 characters.";
    } elseif ($password !== $password_confirm) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        // Check if username exists
        $stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username already taken.";
        } else {
            // Insert new user
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt_insert = $mysqli->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
            $stmt_insert->bind_param("ss", $username, $hash);

            if ($stmt_insert->execute()) {
                $success = "Account created successfully! You can now <a href='login.php'>login</a>.";
            } else {
                $error = "Registration failed. Please try again.";
            }
            $stmt_insert->close();
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - Tokyo Table</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #ff9a9e 0%, #00f2fe 100%);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0;
      padding: 0;
    }
    .register-container {
      background: white;
      padding: 2rem 3rem;
      border-radius: 18px;
      width: 360px;
      box-shadow: 0 15px 40px rgba(0, 242, 254, 0.3), 0 5px 15px rgba(255, 154, 158, 0.3);
      text-align: center;
    }
    h2 {
      color: #ff6fa7;
      margin-bottom: 1.8rem;
      font-weight: 600;
      font-size: 2rem;
    }
    input {
      width: 100%;
      padding: 0.75rem 1rem;
      margin-bottom: 1.2rem;
      border: 2px solid #87e0fd;
      border-radius: 10px;
      font-size: 1rem;
      transition: 0.3s ease;
    }
    input:focus {
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
    .success {
      color: green;
      font-weight: 600;
      margin-top: 1rem;
    }
    @media (max-width: 420px) {
      .register-container {
        width: 90%;
        padding: 2rem;
      }
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h2>Create Account</h2>
    <form method="POST" novalidate>
      <input type="text" name="username" placeholder="Username" required autofocus />
      <input type="password" name="password" placeholder="Password" required />
      <input type="password" name="password_confirm" placeholder="Confirm Password" required />
      <button type="submit">Register</button>
      <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
      <?php elseif ($success): ?>
        <p class="success"><?= $success ?></p>
      <?php endif; ?>
    </form>
    <p style="margin-top:1rem;">Already have an account? <a href="login.php" style="color:#ff6fa7;">Login here</a></p>
  </div>
</body>
</html>
