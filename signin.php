<?php
session_start();

include('helpers/db_connection.php');
include('helpers/functions.php');

isGuest();

//registration
if(isset($_POST['action']) && $_POST['action'] == 'registration') {
    $username = isset($_POST['username']) && $_POST['username'] != '' ? $_POST['username'] : null;
    $email = isset($_POST['email']) && $_POST['email'] != '' ? $_POST['email'] : null;  
    $password = isset($_POST['password']) && $_POST['password'] != '' ? $_POST['password'] : null; 
    $repeat_password = isset($_POST['repeat_password']) && $_POST['repeat_password'] != '' ? $_POST['repeat_password'] : null; 

    $mailQuery = $connection->query("SELECT * FROM users WHERE email = '". $email ."'");
    $mailExists = $mailQuery->fetch_assoc();

    if($username && $email && $password && $repeat_password) {
        if(!$mailExists) {
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
            $error = 'მეილი უკვე არსებობს';
        }
    } else {
        $error = 'გთხოვთ ბოლომდე შეავსეთ';
    }
}
//head
$pageTitle = "რეგისტრაცია";
$styleLink = 'assets/css/style.css';
?>

<?php include('components/head.php')?>

    <div class="login-contianer">
        <div class="content">
            <form class="form-login" action="" method="POST">
                <h2>რეგისტრაცია</h2>
                <div class="form-group">
                    <label for="">სახელი</label>
                    <input type="text" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>">
                </div>
                <div class="form-group">
                    <label for="">მეილი</label>
                    <input type="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
                </div>
                <div class="form-group">
                    <label for="">პაროლი</label>
                    <input type="password" name="password">
                </div>
                <div class="form-group">
                    <label for="">გაიმეორეთ პაროლი</label>
                    <input type="password" name="repeat_password">
                </div>
                <div class="form-group-btn">
                    <input type="hidden" name="action" value="registration">
                    <button class="btn">რეგისტრაცია</button>
                    <a class="signin-btn" href="login.php">შემოსვლა</a>
                </div>
                <div class="error">
                    <?php 
                        if(isset($error)) {
                            echo $error;
                        }
                    ?>
                </div>
            </form>
        </div>
    </div>
<?php include('components/foot.php')?>