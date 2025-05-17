<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if ($username === "admin" && $password === "password123") {
        $_SESSION['admin_logged_in'] = true;
        header("Location: view_feedback.php");
        exit;
    } else {
        $error_message = "❌ Invalid credentials.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="bg-white p-6 rounded-lg shadow-xl max-w-sm w-full">
    <h2 class="text-xl font-bold mb-4 text-center">Admin Login</h2>
    <?php if (isset($error_message)) echo "<div class='bg-red-200 text-red-700 p-2 rounded mb-4'>$error_message</div>"; ?>
    <form action="" method="POST">
      <input type="text" name="username" placeholder="Username" class="w-full p-2 border rounded mb-4" required>
      <input type="password" name="password" placeholder="Password" class="w-full p-2 border rounded mb-4" required>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Login</button>
    </form>
  </div>
</body>
</html>
