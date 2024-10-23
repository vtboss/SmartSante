<?php
$error_message = ""; 
if (isset($_POST["submit"])) {
    $server = "localhost";
    $username = "root"; // Default username for XAMPP
    $password = ""; // Default password for XAMPP
    $database = "smartsante"; // Your database name

    // Create connection
    $con = mysqli_connect($server, $username, $password, $database);

    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get form inputs
    $firstname = $_POST['Firstname'];
    $email = $_POST['Email'];
    $Password = $_POST['Password'];
    $CPassword = $_POST['CPassword'];
    $Phone_Number = $_POST['Phone'];

    

            // Prepare SQL statement to insert data
            $sql = "INSERT INTO `user_ca_db` (`name`, `email`, `password`, `phone_number`) VALUES (?, ?, ?, ?)";

            // Prepare and bind
            $stmt = $con->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: " . htmlspecialchars($con->error));
            }

            // Hash the password
            $hashed_password = password_hash($Password, PASSWORD_DEFAULT);

            // Bind parameters (note that aadhaar_image is included here)
            $stmt->bind_param("ssss", $firstname, $email, $hashed_password, $Phone_Number);

            // Execute statement
            if ($stmt->execute()) {
                $new_id = $stmt->insert_id; // Get the ID of the last inserted record
                #echo "Image and data uploaded successfully. New record ID is: " . $new_id;
            } else {
                $error_message = "Error: " . $stmt->error; // Store error message
            }

            // Close statement
            $stmt->close();


    // Close connection
    $con->close();
}
?>
<!-- Display Error Message -->
<?php if (!empty($error_message)): ?>
    <div style="color: red;"><?php echo $error_message; ?></div>
<?php endif; ?>

<!-- HTML Form -->
<form id="myForm" method="post" enctype="multipart/form-data">
    <input type="text" name="Firstname" placeholder="First Name" required>
    <input type="email" name="Email" placeholder="Email" required>
    <input type="password" id="Password" name="Password" placeholder="Password" required>
    <input type="password" id="CPassword" name="CPassword" placeholder="Confirm Password" required>
    <input type="text" name="Phone" placeholder="Phone Number" required>
    <input type="submit" name="submit" value="Submit">
    <span id="error-msg" style="color:red; display:none;">Passwords do not match</span>
</form>

<script>
    document.getElementById("myForm").addEventListener("submit", function(event) {
    // Get the password and confirm password values
    var password = document.getElementById("Password").value;
    var confirmPassword = document.getElementById("CPassword").value;
    
    // Check if passwords match
    if (password !== confirmPassword) {
        // Prevent form submission
        event.preventDefault();
        
        // Display error message
        document.getElementById("error-msg").style.display = "inline";
    } else {
        // Hide error message if passwords match
        document.getElementById("error-msg").style.display = "none";
    }
});
</script>