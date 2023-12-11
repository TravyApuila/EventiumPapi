<!-- simpanpayment.php -->

<?php
// Connect to your MySQL database
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'tesmoderasi';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $service = $_POST["service"];
    $package = $_POST["package"];
    $date = date("Y-m-d", strtotime($_POST["date"]));
    $note = $_POST["note"];
	$status = "Pending";

    // Insert data into the database
    $sql = "INSERT INTO orders (name, email, phone, service, package, date, note, status) VALUES ('$fullname', '$email', '$phone', '$service', '$package', '$date', '$note','$status')";


    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>