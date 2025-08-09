  <!-- <?php
   
    // Step 2: Handling form submission
    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //     $name = htmlspecialchars($_POST['name']);
    //     $message = htmlspecialchars($_POST['message']);
    //     if ($name == "admin"){
    //         header("Location: admin.html");
    //         exit();  // Important: stop execution after redirect
    //     }
    //     echo "<h3>Form Received:</h3>";
    //     echo "Name: " . $name . "<br>";
    //     echo "Message: " . $message;
    // }
    // else{
    //     echo "submit data!!";
    // }
    ?> -->

<?php
$file = "guestbook.txt";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $name = htmlspecialchars(trim($_POST['name']));
    $message = htmlspecialchars(trim($_POST['message']));

    if ($name && $message) {
        // Prepare line format: Name | Message | datetime
        $entry = $name . " | " . $message . " | " . date("Y-m-d H:i:s") . "\n";

        // Append entry to guestbook.txt
        file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);
    }
}

// Read all messages from file
$messages = [];
if (file_exists($file)) {
    $messages = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Guestbook Messages</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: auto; }
        .message { border-bottom: 1px solid #ccc; padding: 10px 0; }
    </style>
</head>
<body>
    <h2>Guestbook Entries</h2>

    <a href="index.html">Back to form</a>

    <?php if ($messages): ?>
        <?php foreach ($messages as $msg): ?>
            <?php list($n, $m, $dt) = explode(" | ", $msg); ?>
            <div class="message">
                <strong><?= htmlspecialchars($n) ?></strong> at <em><?= htmlspecialchars($dt) ?></em><br>
                <?= nl2br(htmlspecialchars($m)) ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No messages yet.</p>
    <?php endif; ?>
</body>
</html>
