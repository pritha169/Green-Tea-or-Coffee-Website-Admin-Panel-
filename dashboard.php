<?php
    include '../components/connection.php';
    session_start();

    $admin_id = $_SESSION['admin_id'];

    if (!isset($admin_id)) {
        header('location: login.php');
        exit();
    }

    // ✅ Fetch admin profile
    $fetch_profile_stmt = $conn->prepare("SELECT * FROM `admin` WHERE admin_id = ?");
    $fetch_profile_stmt->execute([$admin_id]);
    $fetch_profile = $fetch_profile_stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Coffee Admin Panel - Dashboard</title>
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css?v=<?php echo time(); ?>">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<div class="main">
    <div class="banner">
        <h1>Dashboard</h1>
    </div>

    <div class="title2">
        <a href="dashboard.php">Home</a><span> / Dashboard</span>
    </div>

    <section class="dashboard">
        <h1 class="heading">Dashboard</h1>
        <div class="box-container">

            <div class="box">
                <h3>Welcome!</h3>
                <p><?= htmlspecialchars($fetch_profile['name']) ?></p>
                <a href="" class="btn">Profile</a>
            </div>

            <?php
            function getCount($conn, $query, $params = []) {
                $stmt = $conn->prepare($query);
                $stmt->execute($params);
                return $stmt->rowCount();
            }
            ?>
<div class="box">
    <?php
$select_product = $conn->prepare("SELECT * FROM `PRODUCTS`");

    $select_product->execute();
    $num_of_products = $select_product->rowCount();
    ?>

<h3> <?= $num_of_products;   ?></h3>
<p> Products Added</p>
 <a href="add_product.php" class="btn">Add new products</a>
        </div>

<div class="box">
    <?php
$select_active_product = $conn->prepare("SELECT * FROM `PRODUCTS` WHERE status=?");

    $select_active_product->execute(['active']);
    $num_of_active_products = $select_active_product->rowCount();
    ?>

<h3> <?= $num_of_active_products;   ?></h3>
<p> Total Active Products</p>
 <a href="view_product.php" class="btn">view active products</a>
        </div>
           
        <div class="box">
    <?php
$select_deactive_product = $conn->prepare("SELECT * FROM `PRODUCTS` WHERE status=?");

    $select_deactive_product->execute(['deactive']);
    $num_of_deactive_products = $select_deactive_product->rowCount();
    ?>

<h3> <?= $num_of_deactive_products;   ?></h3>
<p> Total DeActive Products</p>
 <a href="view_product.php" class="btn">view deactive products</a>
        </div>


        <div class="box">
    <?php
$select_users = $conn->prepare("SELECT * FROM `users`");

    $select_users->execute();
    $num_of_users = $select_users->rowCount();
    ?>

<h3> <?= $num_of_users ;   ?></h3>
<p> Registeres users</p>
 <a href="accounts.php" class="btn">View Users</a>
        </div>
      
               <div class="box">
    <?php
$select_admin= $conn->prepare("SELECT * FROM `admin`");

    $select_admin->execute();
    $num_of_admin = $select_admin->rowCount();
    ?>

<h3> <?= $num_of_admin  ;   ?></h3>
<p> Registeres admin</p>
 <a href="accounts.php" class="btn">View admin</a>
        </div>


<div class="box">
    <?php
$select_message= $conn->prepare("SELECT * FROM `message`");

    $select_message->execute();
    $num_of_message = $select_message->rowCount();
    ?>

<h3> <?= $num_of_message  ;   ?></h3>
<p> Unread Messages </p>
<a href="/Green%20Coffee%20Admin%20Panel/admin/admin_message.php" class="btn">View message</a>

        </div>

<div class="box">
    <?php
$select_orders= $conn->prepare("SELECT * FROM `orders`");

    $select_orders->execute();
    $num_of_orders= $select_orders->rowCount();
    ?>

<h3> <?=  $num_of_orders;   ?></h3>
<p> Total Orders Placed</p>
 <a href="order.php" class="btn">View Oreders</a>
        </div>


        <div class="box">
    <?php
$select_confirm_orders= $conn->prepare("SELECT * FROM `orders` WHERE status =?");

    $select_confirm_orders->execute(['in progress']);
    $num_of_confirm_orders= $select_confirm_orders->rowCount();
    ?>

<h3> <?=  $num_of_confirm_orders;   ?></h3>
<p> Total confirm_Orders </p>
 <a href="order.php" class="btn">View confirm Oreders</a>
        </div>


         <div class="box">
    <?php
$select_canceled_orders= $conn->prepare("SELECT * FROM `orders` WHERE status =?");

   $select_canceled_orders->execute(['canceled']);
    $num_of_canceled_orders= $select_canceled_orders->rowCount();
    ?>

<h3> <?=  $num_of_canceled_orders;   ?></h3>
<p> Total canceled_Orders </p>
 <a href="order.php" class="btn">View canceled Oreders</a>
        </div>


        </div>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="./script.js"></script>

<?php include '../components/alert.php'; ?>

</body>
</html>
