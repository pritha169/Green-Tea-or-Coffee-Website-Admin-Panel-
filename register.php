<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../components/connection.php';

if (isset($_POST['register'])) {
    $id = unique_id();

    $name = trim(strip_tags($_POST['name']));
    $email = trim(strip_tags($_POST['email']));
    $pass = trim(strip_tags($_POST['password'])); // Store plain password
    $cpass_raw = trim(strip_tags($_POST['cpassword'])); // Save confirm password for comparison

    $image = trim(strip_tags($_FILES['image']['name']));
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../image/' . $image;

    $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE email = ?");
    $select_admin->execute([$email]);

    if ($select_admin->rowCount() > 0) {
        $warning_msg[] = 'User email already exists';
    } else {
        if ($cpass_raw !== $pass) {
            $warning_msg[] = 'Confirm password not matched';
        } else {
            $insert_admin = $conn->prepare("INSERT INTO `admin`(admin_id, name, email, password, profile) VALUES (?, ?, ?, ?, ?)");
            $insert_admin->execute([$id, $name, $email, $pass, $image]);
            move_uploaded_file($image_tmp_name, $image_folder);
            $success_msg[] = 'New admin registered successfully';
        }
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
    <title>Green Coffee Admin Panel - Register Page</title>
</head>
<body>

<div class="main">
    <section>
        <div class="form-container" id="admin_login">
            <form action="" method="post" enctype="multipart/form-data">
                <h3>Register Now</h3>

                <div class="input-field">
                    <label>User Name <sup>*</sup></label>
                    <input type="text" name="name" maxlength="20" required placeholder="Enter your user name" oninput="this.value = this.value.replace(/\s/g,'')">
                </div>

                <div class="input-field">
                    <label>User Email <sup>*</sup></label>
                    <input type="email" name="email" maxlength="50" required placeholder="Enter your email" oninput="this.value = this.value.replace(/\s/g,'')">
                </div>

                <div class="input-field">
                    <label>Password <sup>*</sup></label>
                    <input type="password" name="password" maxlength="20" required placeholder="Enter your password" oninput="this.value = this.value.replace(/\s/g,'')">
                </div>

                <div class="input-field">
                    <label>Confirm Password <sup>*</sup></label>
                    <input type="password" name="cpassword" maxlength="20" required placeholder="Confirm your password" oninput="this.value = this.value.replace(/\s/g,'')">
                </div>

                <div class="input-field">
                    <label>Select Profile <sup>*</sup></label>
                    <input type="file" name="image" accept="image/*" required>
                </div>

                <button type="submit" name="register" class="btn">Register Now</button>
                <p>Already have an account? <a href="login.php">Login now</a></p>
            </form>
        </div>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script type="text/javascript" src="script.js"></script>

<?php include '../components/alert.php'; ?>
</body>
</html>
