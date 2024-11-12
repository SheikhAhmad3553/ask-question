<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    
<?php
session_start();
include('..\client\common\db.php');

// Redirect function with SweetAlert for successful submission
function redirectWithAlert($location, $message) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        Swal.fire({
            title: 'Success!',
            text: '$message',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '$location';
            }
        });
    </script>";
    exit();
}

// Signup logic
if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    $user = $conn->prepare("INSERT INTO `users` (`id`, `username`, `email`, `password`, `address`) VALUES (NULL, ?, ?, ?, ?)");
    $user->bind_param("ssss", $username, $email, $password, $address);
    $result = $user->execute();

    if ($result) {
        $_SESSION["user"] = ["username" => $username, "email" => $email, "user_id" => $user->insert_id];
        redirectWithAlert("/ask-question", "User created successfully!");
    } else {
        echo "Error creating user";
    }
}

// Login logic
else if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["user"] = ["username" => $row['username'], "email" => $row['email'], "user_id" => $row['id']];
        redirectWithAlert("/ask-question", "Login successful!");
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>Swal.fire('Error!', 'Invalid email or password', 'error');</script>";
    }
}

// Logout logic
else if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ./login.php");
    exit();
}

// Ask question logic
else if (isset($_POST['ask'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category_id = $_POST['category'];
    $user_id = $_SESSION['user']['user_id'];

    $question = $conn->prepare("INSERT INTO `question` (`id`, `title`, `description`, `category_id`, `user_id`) VALUES (NULL, ?, ?, ?, ?)");
    $question->bind_param("ssii", $title, $description, $category_id, $user_id);
    $result = $question->execute();

    if ($result) {
        redirectWithAlert("/ask-question", "Question added successfully!");
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>Swal.fire('Error!', 'Error adding question', 'error');</script>";
    }
}else if (isset($_POST['answer'])) {
    $answer = $_POST['answer'];
    $question_id = $_POST['question_id'];
    $user_id = $_SESSION['user']['user_id'];

    $query = $conn->prepare("INSERT INTO `answer` (`answer`, `question_id`, `user_id`) VALUES (?, ?, ?)");
    $query->bind_param("sii", $answer, $question_id, $user_id);
    $result = $query->execute();

    if ($result) {
        redirectWithAlert("/ask-question?q-id=$question_id", "Answer added successfully!");
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>Swal.fire('Error!', 'Error adding answer', 'error');</script>";
    }
}

?>
</body>
</html>