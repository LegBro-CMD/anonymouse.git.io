<?php
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

// Fetch all feedback from the database
$sql = "SELECT * FROM feedbacks ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🐭 Anonymouse - View Feedback</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>

<body class="bg-gray-100">

    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-6">📝 Public Feedback</h2>
        <div class="mb-6">
        <a href="index.html" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
        ← Back to Submission
        </a>
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
                            <div class="mt-4 p-4 bg-gray-100 rounded-lg">
                                <strong>No reply yet from admin.</strong>
                            </div>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No feedback available.</p>
        <?php endif; ?>

    </div>

    <script type="module">
  import Chatbox from 'https://cdn.jsdelivr.net/npm/@chaindesk/embeds@latest/dist/chatbox/index.js';

  const widget = await Chatbox.initBubble({
    agentId: 'cmaib90f501bx9q8tn6vipyx0',
    
    // optional 
    // If provided will create a contact for the user and link it to the conversation
    contact: {
      firstName: 'John',
      lastName: 'Doe',
      email: 'customer@email.com',
      phoneNumber: '+33612345644',
      userId: '42424242',
    },
    // optional
    // Override initial messages
    initialMessages: [
      'Hello Georges how are you doing today?',
      'How can I help you ?',
    ],
    // optional
    // Provided context will be appended to the Agent system prompt
    context: "The user you are talking to is John. Start by Greeting him by his name.",
  });

  // open the chat bubble
  widget.open();

  // close the chat bubble
  widget.close()

  // or 
  widget.toggle()
</script>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
