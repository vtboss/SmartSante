<?php
// Database connection
session_start();

$server = "localhost";
$username = "root";
$password = "";
$database = "smartsante";
$con = new mysqli($server, $username, $password, $database);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Function to join a community
function joinCommunity($category) {
    global $con; // Access the database connection

    // Retrieve the vendor's RID from the session
    if (isset($_SESSION['RID'])) {
        $RID = $_SESSION['RID']; // Get the current vendor's RID

        // Check if the vendor has already joined
        $checkQuery = "SELECT * FROM `community_db` WHERE `RID` = ? AND `Category` = ?";
        $stmt = $con->prepare($checkQuery);
        $stmt->bind_param("is", $RID, $category);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // Insert into community_db if not already joined
            $insertQuery = "INSERT INTO `community_db` (`RID`, `Category`, `Status`) VALUES (?, ?, 1)";
            $stmt = $con->prepare($insertQuery);
            $stmt->bind_param("is", $RID, $category);
            if ($stmt->execute()) {
                echo "Successfully joined the $category community!";
            } else {
                echo "Error joining community.";
            }
        } else {
            echo "Already joined the $category community.";
        }
        $stmt->close();
    } else {
        echo "Vendor not logged in.";
    }
}

// Check which button was pressed
if (isset($_POST['fdjoin'])) {
    joinCommunity('Food');
} elseif (isset($_POST['crjoin'])) {
    joinCommunity('Crafts');
} elseif (isset($_POST['sejoin'])) {
    joinCommunity('Services');
} // Add more categories as needed

$con->close();
