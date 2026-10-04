<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user'] = $user;
            echo $user['role']; // returns "donor" or "receiver"
        } else {
            echo "invalid password";
        }
    } else {
        echo "user not found";
    }

    $stmt->close();
    $conn->close();
}
?>
