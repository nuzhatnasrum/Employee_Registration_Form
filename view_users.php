<?php

include 'db.php';

$sql = "SELECT users.user_id, users.first_name, users.middle_name, users.last_name, 
               users.marital_status, users.date_of_birth, 
               contacts.email, contacts.mobile, 
               addresses.street_address, addresses.city, addresses.state, 
               addresses.country, addresses.zip_code
        FROM users
        LEFT JOIN contacts ON users.user_id = contacts.user_id
        LEFT JOIN addresses ON users.user_id = addresses.user_id";

$result = $conn->query($sql);

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Registered Users</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Marital Status</th>
                        <th>Date of Birth</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Country</th>
                        <th>ZIP Code</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['user_id']}</td>
                                    <td>{$row['first_name']} {$row['middle_name']} {$row['last_name']}</td>
                                    <td>{$row['marital_status']}</td>
                                    <td>{$row['date_of_birth']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['mobile']}</td>
                                    <td>{$row['street_address']}</td>
                                    <td>{$row['city']}</td>
                                    <td>{$row['state']}</td>
                                    <td>{$row['country']}</td>
                                    <td>{$row['zip_code']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='11' class='text-center'>No users found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>