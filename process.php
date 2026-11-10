
<?php

require_once "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Receive form data
    $time = $_POST['time'] ?? '';
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $gender = $_POST['gender'] ?? '';

    // Validate required fields
    if (
        $first_name === '' ||
        $last_name === '' ||
        $address === '' ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        $phone === '' ||
        !in_array($gender, ['Male', 'Female', 'Other'], true)
    ) {
        die("Please provide valid information in all required fields.");
    }

    // Insert information into database
    $sql = "INSERT INTO Employee                 
    (time, first_name, last_name, Address, email, phone, gender)
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sssssss",
        $time,
        $first_name,
        $last_name,
        $address,
        $email,
        $phone,
        $gender
    );

    if ($stmt->execute()) {
        echo "<h2>Employee Registered Successfully!</h2>";
        echo "<p>Welcome, " .
             htmlspecialchars($first_name) . " " .
             htmlspecialchars($last_name) . "</p>";
    } else {
        echo "Error saving employee information.";
    }

    $stmt->close();
    $conn->close();

} else {
    echo "Invalid request.";
}

?>
