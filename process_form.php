<?php
$sql = "SELECT * FROM `form_data`;";
// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
var_dump($_POST);

// Perform form validation
if (empty($name) || empty($email) || empty($message)) {
    // Handle validation errors, e.g., redirect back to the form with an error message
    header('Location: form.html?error=1');
    exit;
}

// Send email
$to = 'your-email@example.com';
$subject = 'New form submission';
$body = "Name: $name\nEmail: $email\nMessage: $message";

// Insert data into the database
$dbHost = 'localhost';
$dbUser = 'kevinmoreno';
$dbName = 'form_data';

// Create a database connection
$mysqli = new mysqli('localhost', 'kevinmoreno', 'form_data' );

// Check for connection errors
if ($mysqli->connect_error) {
    die('Connect Error: ' . $mysqli->connect_error);
}

// Prepare the SQL statement
$stmt = $mysqli->prepare("INSERT INTO form_data (name, email, message) VALUES (?, ?, ?)");

// Bind the parameters and execute the statement
if (!$stmt->bind_param("sss", $name, $email, $message) || !$stmt->execute()) {
    die('SQL Error: ' . $stmt->error);
}

// Check if the insertion was successful
if ($stmt->affected_rows > 0) {
    // Email sent successfully, redirect to a thank you page
    header('Location: thank_you.html');
} else {
    // Failed to insert data, handle the error accordingly
    header('Location: form.html');
}

// Close the statement and database connection
$stmt->close();
$mysqli->close();

// Exit after closing the statement and database connection
exit;

// Display the HTML code


// Rest of your code...


// Display the submitted data
echo "Submitted Data:<br>";
echo "Name: " . $name . "<br>";
echo "Email: " . $email . "<br>";
echo "Message: " . $message . "<br>";
?>
