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
    $Item_name = $_POST['Item_name'];
    $Quantity = $_POST['Quantity'];

// Retrieve specific columns from the database
$query = "SELECT `RID`,`name` FROM `vendors_ca_db` WHERE id = 1"; // Adjust condition as needed
$result = $con->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $RID = $row['RID'];
    $NAME = $row['name'];


    // Prepare SQL statement to insert data
            $sql = "INSERT INTO `stock_db` (`RID`, `name`, `Item_name`, `Quantity`) VALUES (?,?,?,?)";

            
            // Prepare and bind
            $stmt = $con->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: " . htmlspecialchars($con->error));
            }


            // Bind parameters (note that aadhaar_image is included here)
            $stmt->bind_param("ssss",$RID,$NAME,  $Item_name, $Quantity);

            // Execute statement
            if ($stmt->execute()) {
                $new_id = $stmt->insert_id; // Get the ID of the last inserted record
                echo "data uploaded successfully. New record ID is: " . $new_id;
                header("Location:/SmartSante-main/db.html"); 
            } else {
                $error_message = "Error: " . $stmt->error; // Store error message
            }

            // Close statement
            $stmt->close();


    // Close connection
    $con->close();
}}
?>
<!-- Display Error Message -->
<?php if (!empty($error_message)): ?>
    <div style="color: red;"><?php echo $error_message; ?></div>
<?php endif; ?>

