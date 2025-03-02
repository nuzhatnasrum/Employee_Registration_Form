<?php 

include 'db.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $first_name = $_POST["first_name"];
    $middle_name = $_POST["middle_name"];
    $last_name = $_POST["last_name"];
    $marital_status = $_POST["marital_status"];
    $date_of_birth = $_POST["date_of_birth"];

    $email = $_POST["email"];
    $mobile = $_POST["mobile"];

    $street_address = $_POST["street_address"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $country = $_POST["country"];
    $zip_code = $_POST["zip_code"];

    
    $user_sql = "INSERT INTO users (first_name, middle_name, last_name, marital_status, date_of_birth) 
                 VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($user_sql);
    $stmt->bind_param("sssss", $first_name, $middle_name, $last_name, $marital_status, $date_of_birth);

    
    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;

        
        $contact_sql = "INSERT INTO contacts (user_id, email, mobile) VALUES (?, ?, ?)";
        $contact_stmt = $conn->prepare($contact_sql);
        $contact_stmt->bind_param("iss", $user_id, $email, $mobile);

        $address_sql = "INSERT INTO addresses (user_id, street_address, city, state, country, zip_code) 
                        VALUES (?, ?, ?, ?, ?, ?)";
        $address_stmt = $conn->prepare($address_sql);
        $address_stmt->bind_param("isssss", $user_id, $street_address, $city, $state, $country, $zip_code);

        
        if ($contact_stmt->execute() && $address_stmt->execute()) {
            $message = "Registration successful! Your details have been saved.";
            $message_type = "success";
        } else {
            $message = "Error: " . $conn->error;
            $message_type = "danger";
        }
    } else {
        $message = "Error: " . $conn->error;
        $message_type = "danger";
    }

    
    $stmt->close();
    $contact_stmt->close();
    $address_stmt->close();

    
    $conn->close();
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
    <div class="container mt-4">
        
        <div class="text-center mb-4">
            <img src="iit logo.jpg" alt="iit logo.jpg" width="100">  
            <h2 class="mt-2">Employee Registration Form</h2>
            <p>Please fill out the form for the HR department to complete your registration.</p>
        </div>
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="card p-4">
                <h4 class="mb-3">Personal Information</h4>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">First Name *</label>
                        <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Middle Name</label>
                        <input type="text" class="form-control" name="middle_name" placeholder="Middle Name">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Marital Status</label>
                        <select class="form-select" name="marital_status">
                            <option selected>Choose...</option>
                            <option>Single</option>
                            <option>Married</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" name="date_of_birth" required>
                    </div>
                </div>
            </div>
            
            <div class="card p-4 mt-3">
                <h4 class="mb-3">Contact Information</h4>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">E-mail</label>
                        <input type="email" class="form-control" name="email" placeholder="E-mail" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mobile Number *</label>
                        <input type="tel" class="form-control" name="mobile" placeholder="Mobile Number" required pattern="\d{10}">
                    </div>
                </div>
            </div>
            
            <div class="card p-4 mt-3">
                <h4 class="mb-3">Address</h4>
                <div class="mb-3">
                    <label class="form-label">Street Address</label>
                    <input type="text" class="form-control" name="street_address" placeholder="Street Address">
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" name="city" placeholder="City">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">State / Province</label>
                        <input type="text" class="form-control" name="state" placeholder="State / Province">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Country</label>
                        <input type="text" class="form-control" name="country" placeholder="Country">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">ZIP Code</label>
                        <input type="text" class="form-control" name="zip_code" placeholder="ZIP Code" required pattern="\d{5}">
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4 d-grid">
                <button type="submit" class="btn btn-primary">REGISTER ME</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$servername = "localhost";  
$username = "root";         
$password = "";             
$dbname = "registration_system"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>  
