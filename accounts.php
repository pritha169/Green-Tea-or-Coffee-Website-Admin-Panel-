<?php
include '../components/connection.php';
session_start();

$admin_id = $_SESSION['admin_id'] ?? '';

if (!$admin_id) {
    header('location: login.php');
    exit();
}

// Fetch all admins
$get_admins = $conn->prepare("SELECT * FROM `admin` ORDER BY name ASC");
$get_admins->execute();
$admins = $get_admins->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Accounts</title>
   <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
   <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>Admin Accounts</h1>
    </div>

    <div class="title2">
        <a href="dashboard.php">Home</a><span> / Admin Accounts</span>
    </div>

    <section class="dashboard">
        <h1 class="heading">Registered Admins</h1>
        <div class="box-container">

            <?php if (count($admins) > 0): ?>
                <?php foreach ($admins as $admin): ?>
                    <div class="box">
                        <img src="../uploaded_img/<?= htmlspecialchars($admin['profile']) ?>" alt="Profile Image" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                        <h3><?= htmlspecialchars($admin['name']) ?></h3>
                        <p><?= htmlspecialchars($admin['email']) ?></p>
                        <a href="mailto:<?= htmlspecialchars($admin['email']) ?>" class="btn">Contact</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty">No admins found!</p>
            <?php endif; ?>

        </div>
    </section>
</div>

<script src="./script.js"></script>
<?php include '../components/alert.php'; ?>

</body>
</html>
