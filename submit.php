<?php
include 'db.php'; // database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function clean($data) {
        return htmlspecialchars(trim($data));
    }

    $first_name = clean($_POST["first_name"]);
    $last_name = clean($_POST["last_name"]);
    $gmail = clean($_POST["gmail"]);
    $school_name = clean($_POST["school_name"]);
    $country_code = clean($_POST["country_code"]);
    $phone_number = clean($_POST["phone_number"]);
    $role = clean($_POST["role"]);
    $address1 = clean($_POST["address1"]);
    $address2 = clean($_POST["address2"]);
    $city = clean($_POST["city"]);
    $state = clean($_POST["state"]);
    $zip = clean($_POST["zip"]);
    $message = clean($_POST["message"]);

    // SQL INSERT statement
    $sql = "INSERT INTO submissions (
        first_name, last_name, gmail, school_name, country_code, phone_number, role,
        address1, address2, city, state, zip, message
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssssssssssss", $first_name, $last_name, $gmail, $school_name,
            $country_code, $phone_number, $role, $address1, $address2, $city, $state, $zip, $message);

        if ($stmt->execute()) {
            echo "<h2>Thank you! Your data has been submitted successfully.</h2>";
        } else {
            echo "<h2 style='color:red;'>Error saving data: " . $stmt->error . "</h2>";
        }
        $stmt->close();
    } else {
        echo "<h2 style='color:red;'>Failed to prepare SQL statement: " . $conn->error . "</h2>";
    }

    $conn->close();
} else {
    echo "<h2>Access Denied</h2>";
}
?>
