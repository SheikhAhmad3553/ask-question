<?php
session_start();
include('..\client\common\db.php');
if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    $user = $conn->prepare("Insert into `users`
    (`id`,`username`, `email`, `password`, `address`)
    VALUES (NULL,'$username', '$email', '$password', '$address');
     ");
    $result = $user->execute();
    if ($result) {
        $_SESSION["user"] = ["username" => $username, "email" => $email];
        header("Location: /DISCUSS");
    } else {
        echo "Error creating user";
    }
} else if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "select * from users where email='$email' and password='$password'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        foreach ($result as $row) {
            $username = $row['username'];
        }
        $_SESSION["user"] = ["username" => "username", "email" => "email"];
        header("Location: /DISCUSS");
    } else {
        echo "Invalid email or password";
    }
} else if (isset($_GET['logout'])) {
    session_unset();
    header("Location: /DISCUSS");
}
