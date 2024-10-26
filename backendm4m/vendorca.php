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
    $Category= $_POST['Category'];
    $Aadhaar_no=$_POST['Aadhaar_no'];

    if($Category=="Food"){
    $random_number = 'FO' . str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);}
    if($Category=="Retail"){
    $random_number = 'RE' . str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);}
    if($Category=="Service"){
    $random_number = 'SE' . str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);}
    


        if (isset($_FILES['aadhaar']) && $_FILES['aadhaar']['error'] === UPLOAD_ERR_OK) {
            // Get the binary data of the uploaded file
            $aadhaar_image = file_get_contents($_FILES['aadhaar']['tmp_name']);

            // Prepare SQL statement to insert data
            $sql = "INSERT INTO `vendors_ca_db` (`RID`,`Category`,`name`, `email`, `password`, `phone_number`, `aadhaar`,`Aadhaar_no`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            // Prepare and bind
            $stmt = $con->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: " . htmlspecialchars($con->error));
            }

            // Hash the password
            $hashed_password = password_hash($Password, PASSWORD_DEFAULT);

            // Bind parameters (note that aadhaar_image is included here)
            $stmt->bind_param("sssssbsi",$random_number,$Category, $firstname, $email, $hashed_password, $Phone_Number, $aadhaar_image,$Aadhaar_no);

            // Execute statement
            if ($stmt->execute()) {
                $new_id = $stmt->insert_id; // Get the ID of the last inserted record
                #echo "data uploaded successfully. New record ID is: " . $new_id;
                header("Location:/SmartSante-main/login/login - vendor.html"); 
            } else {
                $error_message = "Error: " . $stmt->error; // Store error message
            }

            // Close statement
            $stmt->close();
        } else {
            $error_message = "Error uploading image. Plea
            se try again.";
        }

    

    

    // Close connection
    $con->close();
}

?>
<!-- Display Error Message -->
<?php if (!empty($error_message)): ?>
    <div style="color: red;"><?php echo $error_message; ?></div>
<?php endif; ?>


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