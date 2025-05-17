<?php
session_start();

// Check if the admin is logged in, otherwise redirect to the login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php"); // Redirect to login page if not logged in
    exit;
}

// Database connection settings
$host = "localhost";
$username = "root";
$password = "";
$dbname = "anonymouse";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle admin reply submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback_id = $_POST['feedback_id'];
    $admin_reply = trim($_POST['admin_reply']);

    if (!empty($admin_reply)) {
        $stmt = $conn->prepare("UPDATE feedbacks SET admin_reply = ? WHERE id = ?");
        $stmt->bind_param("si", $admin_reply, $feedback_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch all feedback from the database
$sql = "SELECT * FROM feedbacks ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - View Feedback</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-6">📝 Feedback List</h2>

        <div class="mb-4">
            <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded-lg">Logout</a>
        </div>

        <?php if ($result->num_rows > 0): ?>
            <ul class="bg-white p-6 rounded-lg shadow-lg">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li class="mb-4 p-2 border-b border-gray-300">
                        <strong>Feedback:</strong> <?php echo htmlspecialchars($row['feedback']); ?>
                        <br>
                        <small class="text-gray-500">Submitted on <?php echo $row['created_at']; ?></small>

                        <!-- Display Admin Reply -->
                        <?php if ($row['admin_reply']): ?>
                            <div class="mt-4 p-4 bg-gray-200 rounded-lg">
                                <strong>Admin Reply:</strong>
                                <p><?php echo htmlspecialchars($row['admin_reply']); ?></p>
                            </div>
                        <?php else: ?>
                            <!-- Admin Reply Form -->
                            <form action="view_feedback.php" method="POST" class="mt-4">
                                <input type="hidden" name="feedback_id" value="<?php echo $row['id']; ?>" />
                                <label for="admin_reply" class="block text-sm font-medium text-gray-700">Admin Reply</label>
                                <textarea id="admin_reply" name="admin_reply" rows="3" class="w-full mt-1 p-2 border border-gray-300 rounded-lg" required></textarea>
                                <button type="submit" class="mt-2 w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200">
                                    Submit Reply
                                </button>
                            </form>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No feedback available.</p>
        <?php endif; ?>

    </div>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
