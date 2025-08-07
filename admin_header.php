<?php
// Include the connection if $conn is not already set
if (!isset($conn)) {
    include '../components/connection.php';
}

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if admin_id is set in session
if (!isset($_SESSION['admin_id'])) {
    header('location: login.php');
    exit();
}

$admin_id = $_SESSION['admin_id'];

?>

<header class="header">
    <div class="flex">
        <a href="dashboard.php" class="logo"><img src="../img/logo.jpg" alt="Logo"></a>
        <nav class="navbar">
            <a href="dashboard.php">Dashboard</a>
            <a href="add_product.php">Add Product</a>
            <a href="view_product.php">View Product</a>
            <a href="user_account.php">Accounts</a>
        </nav>

        <div class="icons">
            <i class="bx bxs-user" id="user-btn"></i>
            <i class="bx bx-list-plus" id="menu-btn"></i>
        </div>

        <div class="profile-detail">
            <?php
            // Prepare and execute the query to get admin profile
            $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE admin_id = ?");
            $select_profile->execute([$admin_id]);

            if ($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
                <div class="profile">
                    <img src="../img/<?= htmlspecialchars($fetch_profile['profile']); ?>" class="logo-img" alt="Admin Profile">
                    <p><?= htmlspecialchars($fetch_profile['name']); ?></p>
                </div>
                <div class="flex-btn">
                    <a href="profile.php" class="btn">Profile</a>
                    <a href="../components/admin_logout.php" onclick="return confirm('Logout from this website?');" class="btn">Logout</a>
                </div>
            <?php
            } else {
                echo '<p>Admin profile not found.</p>';
            }
            ?>
        </div>
    </div>
</header>
