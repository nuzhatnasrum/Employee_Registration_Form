<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dob = $_POST['dob'];
    $maritalStatus = $_POST['maritalStatus'];
    $email = $_POST['email'];
    $mobileNumber = $_POST['mobileNumber'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $zip = $_POST['zip'];

    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, dob, marital_status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstName, $lastName, $dob, $maritalStatus);
    $stmt->execute();
    $user_id = $stmt->insert_id;
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO contacts (user_id, email, mobile_number) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $email, $mobileNumber);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO addresses (user_id, street, city, state, country, zip_code) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $street, $city, $state, $country, $zip);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Registration Successful!'); window.location.href='index.php';</script>";
}
?>
