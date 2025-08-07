<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../components/connection.php';

session_start();

if (isset($_POST['login'])) {
 $identifier = htmlspecialchars(strip_tags(trim($_POST['identifier'])));
$pass = htmlspecialchars(strip_tags(trim($_POST['password'])));

   // Try to match by admin_id or email
   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE (admin_id = ? OR email = ?) AND password = ?");
   $select_admin->execute([$identifier, $identifier, $pass]);

   if ($select_admin->rowCount() > 0) {
       $fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC);
       $_SESSION['admin_id'] = $fetch_admin['admin_id'];
       header('Location: dashboard.php');
       exit();
   } else {
       $warning_msg[] = 'Incorrect Admin ID/Email or password';
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title>Green Coffee Admin Panel - Login Page</title>
</head>
<body>

<div class="main">
    <section>
        <div class="form-container" id="admin_login">
            <form action="" method="post" enctype="multipart/form-data">
                <h3>Login Now</h3>

                <div class="input-field">
                    <label>Admin ID or Email <sup>*</sup></label>
                    <input type="text" name="identifier" maxlength="50" required placeholder="Enter your Admin ID or Email" oninput="this.value = this.value.replace(/\s/g,'')">
                </div>

                <div class="input-field">
                    <label>Password <sup>*</sup></label>
                    <input type="password" name="password" maxlength="20" required placeholder="Enter your password" oninput="this.value = this.value.replace(/\s/g,'')">
                </div>

                <button type="submit" name="login" class="btn">Login Now</button>
                <p>Don't have an account? <a href="register.php">Register now</a></p>
            </form>
        </div>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script type="text/javascript" src="script.js"></script>

<?php include '../components/alert.php'; ?>
</body>
</html>
