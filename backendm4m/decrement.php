<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smartsante"; // Replace with your database name

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Specify the ID or other condition to identify the row
$id = 1; // Replace with the actual ID of the row you want to update
$itemname=$_POST['itemname'];

// Fetch the current value
$sql1="SELECT `Item_name` FROM `stock_db` WHERE id = ?";
$sql = "SELECT `Quantity` FROM `stock_db` WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (isset($_POST["Quantity-sold"]) && $sql1==$itemname) {
    $sold= $row["Quantity_sold"];
    $currentValue = $row['Quantity'];
    $newValue = $currentValue - $sold;

    // Update the value in the database
    $updateSql = "UPDATE `stock_db` SET Quantity = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ii", $newValue, $id);
    $updateStmt->execute();
    
    $stmt->close();
    $updateStmt->close();
} else {
    echo "Record not found.";
    $newValue = "N/A";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decremented Value</title>
</head>
<body>
    <h1>Updated Value: <?php echo htmlspecialchars($newValue); ?></h1>
</body>
</html>
