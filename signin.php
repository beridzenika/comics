<?php
session_start();

include('helpers/db_connection.php');
include('helpers/functions.php');

isGuest();

if(isset($_POST['action']) && $_POST['action'] == 'registration') {
    $username = isset($_POST['username']) && $_POST['username'] != '' ? $_POST['username'] : null;
    $email = isset($_POST['email']) && $_POST['email'] != '' ? $_POST['email'] : null;  
    $password = isset($_POST['password']) && $_POST['password'] != '' ? $_POST['password'] : null; 
    $repeat_password = isset($_POST['repeat_password']) && $_POST['repeat_password'] != '' ? $_POST['repeat_password'] : null; 

    if($username && $email && $password && $repeat_password) {
        if($password == $repeat_password) {
            $password = password_hash($password, PASSWORD_DEFAULT);

            $query = $connection->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $query->bind_param('sss', $username, $email, $password);
            if($query->execute()) {
                header('location: index.php');
            }
        } else {
            $error = 'პაროლები არ ემთხვევა';
        }
    } else {
        $error = 'გთხოვთ ბოლომდე შეავსეთ';
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>რეგისტრაცია</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="login-contianer">
        <div class="content">
            <form class="form-login" action="" method="POST">
                    <div class="form-group">
                        <label for="">სახელი</label>
                        <input type="text" name="username">
                    </div>
                    <div class="form-group">
                        <label for="">მეილი</label>
                        <input type="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="">პაროლი</label>
                        <input type="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="">გაიმეორეთ პაროლი</label>
                        <input type="password" name="repeat_password">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="action" value="registration">
                        <button class="btn">რეგისტრაცია</button>
                        <a class="signin-btn" href="login.php">შემოსვლა</a>
                    </div>
                    <div>
                        <?php 
                            if(isset($error)) {
                                echo $error;
                            }
                        ?>
                    </div>
                </form>
        </div>
    </div>
    
</body>
</html>