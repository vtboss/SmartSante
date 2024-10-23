<?php
// Start session
session_start();

// Database credentials
$servername = "localhost";
$username = "root";  // change if necessary
$password = "";      // change if necessary
$dbname = "smartsante"; // your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // SQL query to fetch the user based on username
    $sql = "SELECT * FROM vendors_ca_db WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user's data
        $user = $result->fetch_assoc();
        $hashed_password = $user['password'];

        // Verify the hashed password
        if (password_verify($input_password, $hashed_password)) {
            // Password is correct, set session variables
            $_SESSION['username'] = $input_username;
            echo "Login successful! Welcome, " . $input_username;
            // Redirect to a welcome page or dashboard
            header("Location:/SmartSante-main/db.html");
        } else {
            // Incorrect password
            echo "Invalid username or password";
        }
    } else {
        // User not found
        echo "Invalid username or password";
    }

    $stmt->close();
}

$conn->close();
?>

<form  method="post" enctype="multipart/form-data">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>