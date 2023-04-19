<?php
session_start();

include 'helpers/db_connection.php';
include 'helpers/functions.php';
    
// isGuest();

$error = '';
if(isset($_POST['action']) && $_POST['action'] == 'login') {
    $email = isset($_POST['email']) && $_POST['email'] != '' ? $_POST['email'] : null; 
    $password = isset($_POST['password']) && $_POST['password'] != '' ? $_POST['password'] : null; 

    if($username && $email && $password) {
        $query = $connection->query("SELECT * FROM users WHERE email = '". $email ."'");
        $user = $query->fetch_assoc();
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['logedin'] = true;

                if ($user['is_admin']) {
                    $_SESSION['is_admin'] = true;
                    header('location: admin.php');
                } else {
                    header('location: index.php');
                }
            } else {
                $error = 'პაროლი არასწორია';
            }
        } else {
            $error = 'ექაუნთი არ არსებობს';
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
    <title>შესვლა</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="login-contianer">
        <div class="content">
            <form class="form-login" action="" method="POST">
                <h2>შემოსვლა</h2>
                <div class="form-group">
                    <label for="">მეილი</label>
                    <input type="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
                </div>
                <div class="form-group">
                    <label for="">პაროლი</label>
                    <input type="password" name="password">
                </div>
                <div class="form-group-btn">
                    <input type="hidden" name="action" value="login">
                    <button class="btn">შემოსვლა</button>
                    <a class="signin-btn" href="signin.php">რეგისტრაცია</a>
                </div>
                <div class="error">
                    <?php 
                        if($error) {
                            echo $error;
                        }
                    ?>
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>