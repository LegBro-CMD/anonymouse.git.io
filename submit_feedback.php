<?php
require 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback = trim($_POST["feedback"] ?? '');

    if (!empty($feedback)) {
        $stmt = $conn->prepare("INSERT INTO feedbacks (feedback) VALUES (?)");
        $stmt->bind_param("s", $feedback);
        $stmt->execute();
        $stmt->close();
    } else {
        $feedback = "⚠️ Feedback is empty.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>🐭 Anonymouse – Anonymous Feedback</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            cursor: url('cursor.cur'), auto;
        }
        button:hover,
        a:hover {
            cursor: url('cursor.cur'), auto;
        }

        body {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .logo-floating {
            width: 96px;
            height: 96px;
            margin: 0 auto;
            margin-top: -48px; /* Pull it upward to float over the box */
            border-radius: 9999px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            object-fit: cover;
            position: relative;
            z-index: 10;
        }
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="relative bg-white p-8 pt-16 rounded-2xl shadow-xl w-full max-w-md text-center">
        <img src="thimb.jpg" alt="Anonymouse Logo" class="mx-auto mb-4 w-24 h-24 rounded-full shadow-md">

        <h1 class="text-2xl font-bold text-gray-800 mb-2">🐭 Anonymouse</h1>
        <p class="text-gray-600 mb-6">Your feedback has been submitted ✅</p>

        <!-- Feedback Message -->
        <div class="mt-4">
            <p class="text-xl font-medium text-green-600"><?php echo $feedback; ?></p>
        </div>

        <!-- Back to Submission Button -->
        <div class="mt-6">
            <a href="index.html" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200 inline-block">
                ⬅️ Back to Submission
            </a>
        </div>

    </div>

</body>
</html>
