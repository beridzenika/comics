<?php
include 'helpers/db_connection.php';
include 'helpers/functions.php';

session_start();

//login
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
                $_SESSION['userid'] = $user['id'];
                $_SESSION['logedin'] = true;
                
                $to = $email;
                $subject = 'Welcome to Our Website!';
                $message = 'Thank you for registering on our website. We hope you enjoy your stay!';
                $headers = 'From: no-reply@yourwebsite.com' . "\r\n" .
                           'Reply-To: no-reply@yourwebsite.com' . "\r\n" .
                           'X-Mailer: PHP/' . phpversion();

                if (mail($to, $subject, $message, $headers)) {
                    echo 'Email sent successfully.';
                } else {
                    echo 'Failed to send email.';
                }

                if ($user['is_admin']) {
                    $_SESSION['is_admin'] = 1;
                    // header('location: index.php?user=admin');

                } else {
                    header('location: index.php?');
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
//head
$pageTitle = "შესვლა";
$styleLink = 'assets/css/style.css';
?>

<?php include('components/head.php')?>

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
                    <a class="signin-btn" href="signin.php">რეგისტრაცია</a>
                    <button class="btn">შემოსვლა</button>
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
<?php include('components/foot.php')?>