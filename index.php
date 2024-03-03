<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "withdesign";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add new user
    if (isset($_POST["add"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];

        $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
        if ($conn->query($sql) === TRUE) {
            echo "User added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Delete user
    if (isset($_POST["delete"])) {
        $userId = $_POST["user_id"];

        $sql = "DELETE FROM users WHERE id = $userId";
        if ($conn->query($sql) === TRUE) {
            echo "User deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Fetch users from the database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <title>PHP MySQL Sample</title>
</head>
<body>
    <h2>Add User</h2>
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <button type="submit" name="add">Add User</button>
    </form>

    <h2>Users</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>
                            <form method='post' action=''>
                                <input type='hidden' name='user_id' value='{$row['id']}'>
                                <button type='submit' name='delete'>Delete</button>
                            </form>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No users found</td></tr>";
        }
        ?>
    </table>

    <?php
    // Close the connection
    $conn->close();
    ?>
</body>
</html>
