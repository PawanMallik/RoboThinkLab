<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("INSERT INTO queries (name, email) VALUES (?, ?)");
    if ($stmt) {
        $stmt->bind_param("ss", $name, $email);
        if ($stmt->execute()) {
            echo "<h2>Thank you! We will get back to you soon.</h2>";
        } else {
            echo "<h2 style='color:red;'>Error: " . $stmt->error . "</h2>";
        }
        $stmt->close();
    } else {
        echo "<h2 style='color:red;'>Statement failed: " . $conn->error . "</h2>";
    }

    $conn->close();
} else {
    echo "<h2>Access Denied</h2>";
}
?>
