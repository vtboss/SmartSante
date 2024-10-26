<?php
// Database connection
$server = "localhost";
$username = "root";
$password = "";
$database = "smartsante";
$con = new mysqli($server, $username, $password, $database);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if (isset($_POST['fdjoin'])) {

// Retrieve specific columns from the database
$query = "SELECT `RID`,`Category` FROM `vendors_ca_db` WHERE id = 1"; // Adjust condition as needed
$result = $con->query($query);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $RID = $row['RID'];
    $Category = $row['Catgeory'];


    // Check if the vendor has already joined
    $checkQuery = "SELECT * FROM `community_db` WHERE `RID` = ? AND `Category` = ?";
    $stmt = $con->prepare($checkQuery);
    $stmt->bind_param("is", $RID, $Category);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insert into community_memberships table if not already joined
        $insertQuery = "INSERT INTO `community_db` (`RID`, `Category`, `Status`) VALUES (?, ?, 1)";
        $stmt = $con->prepare($insertQuery);
        $stmt->bind_param("is", $RID, $Category);
        if ($stmt->execute()) {
            #echo "Successfully joined!";
        } else {
            #echo "Error joining community.";
        }
    } else {
        #echo "Already joined this category.";
    }
    $stmt->close();
}
$con->close();
}

if (isset($_POST['crjoin'])) {

// Retrieve specific columns from the database
$query = "SELECT `RID`,`Category` FROM `vendors_ca_db` WHERE id = 1"; // Adjust condition as needed
$result = $con->query($query);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $RID = $row['RID'];
    $Category = $row['Catgeory'];


    // Check if the vendor has already joined
    $checkQuery = "SELECT * FROM `community_db` WHERE `RID` = ? AND `Category` = ?";
    $stmt = $con->prepare($checkQuery);
    $stmt->bind_param("is", $RID, $Category);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insert into community_memberships table if not already joined
        $insertQuery = "INSERT INTO `community_db` (`RID`, `Category`, `Status`) VALUES (?, ?, 1)";
        $stmt = $con->prepare($insertQuery);
        $stmt->bind_param("is", $RID, $Category);
        if ($stmt->execute()) {
            #echo "Successfully joined!";
        } else {
            #echo "Error joining community.";
        }
    } else {
        #echo "Already joined this category.";
    }
    $stmt->close();
}
$con->close();
}

if (isset($_POST['rejoin'])) {

// Retrieve specific columns from the database
$query = "SELECT `RID`,`Category` FROM `vendors_ca_db` WHERE id = 1"; // Adjust condition as needed
$result = $con->query($query);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $RID = $row['RID'];
    $Category = $row['Catgeory'];


    // Check if the vendor has already joined
    $checkQuery = "SELECT * FROM `community_db` WHERE `RID` = ? AND `Category` = ?";
    $stmt = $con->prepare($checkQuery);
    $stmt->bind_param("is", $RID, $Category);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insert into community_memberships table if not already joined
        $insertQuery = "INSERT INTO `community_db` (`RID`, `Category`, `Status`) VALUES (?, ?, 1)";
        $stmt = $con->prepare($insertQuery);
        $stmt->bind_param("is", $RID, $Category);
        if ($stmt->execute()) {
            #echo "Successfully joined!";
        } else {
            #echo "Error joining community.";
        }
    } else {
        #echo "Already joined this category.";
    }
    $stmt->close();
}
$con->close();
}


































