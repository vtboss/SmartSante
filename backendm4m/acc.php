<?php
session_start(); // Start session to use session variables
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

    // Get the vendor's RID from the session
    $RID = $_SESSION['RID']; // Assuming RID is stored in the session

    // Get form inputs
    $income = $_POST['income'];
    $Expense = $_POST['Expense'];
    $Amount = $_POST['Amount'];
    $Date = $_POST['Date'];

    // Retrieve the vendor's name based on the RID
    $query = "SELECT `name` FROM `vendors_ca_db` WHERE `RID` = ?"; // Adjust condition as needed
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $RID); // Use "i" for integer binding
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $NAME = $row['name'];

        // Prepare SQL statement to insert data
        $sql = "INSERT INTO `acc_db` (`RID`, `name`, `Income`, `Expense`, `Amount`, `Date`) VALUES (?, ?, ?, ?, ?, ?)";

        // Prepare and bind
        $stmt = $con->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . htmlspecialchars($con->error));
        }

        // Bind parameters
        $stmt->bind_param("isssss", $RID, $NAME, $income, $Expense, $Amount, $Date);

        // Execute statement
        if ($stmt->execute()) {
            $new_id = $stmt->insert_id; // Get the ID of the last inserted record
            echo "Data uploaded successfully. New record ID is: " . $new_id;
            header("Location:/SmartSante-main/db.html"); 
            exit; // Ensure no further code is executed after redirection
        } else {
            $error_message = "Error: " . $stmt->error; // Store error message
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $con->close();
}
?>
<!-- Display Error Message -->
<?php if (!empty($error_message)): ?>
    <div style="color: red;"><?php echo $error_message; ?></div>
<?php endif; ?>
