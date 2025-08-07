
<?php
    include '../components/connection.php';

    session_start();
    $admin_id = $_SESSION['admin_id'];

    if (!isset($admin_id)){
        header('location: login.php');  
    }
    if( isset($_POST['delete_order'])){


        $order_id = $_POST['order_id'];
        $order_id = filter_var($order_id, FILTER_SANITIZE_STRING);

        $verify_delete= $conn->prepare("SELECT * FROM `orders` WHERE order_id = ?");
        $verify_delete->execute([$order_id]);
        if($verify_delete->rowcount() > 0){

            $delete_order= $conn->prepare("DELETE FROM `orders` WHERE order_id = ?");
            $delete_order->execute([$order_id]);
            $success_msg[] = 'order deleted';

        }else{

            $warning_msg[] = 'order already deleted';

        }
    }

    if(isset($_POST['update_order'])){

        $order_id = $_POST['order_id'];
        $order_id = filter_var($order_id, FILTER_SANITIZE_STRING);

        $update_payment = $_POST['update_payment'];
        $update_payment = filter_var($update_payment , FILTER_SANITIZE_STRING);

        $update_pay =$conn->prepare("UPDATE `orders` SET payment_status = ? WHERE order_id =? ");
        $update_pay->execute([$update_payment, $order_id]);

        $success_msg[]='order updated';


    }
    if(isset($_POST['update_order'])){

        $order_id = $_POST['order_id'];
        $order_id = filter_var($order_id, FILTER_SANITIZE_STRING);

        $update_payment = $_POST['update_payment'];
        $update_payment = filter_var($update_payment , FILTER_SANITIZE_STRING);

        $update_pay =$conn->prepare("UPDATE `orders` SET status = ? WHERE order_id =? ");
        $update_pay->execute([$update_payment, $order_id]);

        $success_msg[]='order updated';


    }
    

   
        
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title>green coffe admin panel - recieved orders page</title>
</head>
<body>
    <?php include '../components/admin_header.php';  ?>



<div class = "main">
    <div class="banner">
        <h1> recieved orders</h1>
     </div>
<div class="title2">
    <a href="dashboard.php">dashboard</a><span> / recieved orders</span>
</div>

    <section class ="order-container">
        <h1 class="heading">total recieved orders</h1>
        <div class="box-container">
            <?php
            $select_orders = $conn->prepare("SELECT * FROM `orders` ");
            $select_orders->execute();

            if($select_orders->rowcount() > 0){
                while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
             
            ?>

            <div class="box">
                <div class="status" style="color: <?php if($fetch_orders['status']=='in progress'){echo"green";}else{echo"red";}?>"><?=$fetch_orders['status']; ?></div>
                <div class="detail">

                    <p>user name :<span><?=$fetch_orders['name']; ?></span></p>
                    <p>user id :<span><?=$fetch_orders['order_id']; ?></span></p>
                    <p>placed on :<span><?=$fetch_orders['date']; ?></span></p>
                    <p>user number :<span><?=$fetch_orders['number']; ?></span></p>
                    <p>user email :<span><?=$fetch_orders['email']; ?></span></p>
                    <p>total price :<span><?=$fetch_orders['price']; ?></span></p>
                    <p>method :<span><?=$fetch_orders['method']; ?></span></p>
                    <p>address :<span><?=$fetch_orders['address']; ?></span></p>

                </div>
                <form action="" method="post">
                    <input type="hidden" name="order_id" value="<?=$fetch_orders['order_id'];?>">
                    <select name="update_payment">
                        <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
                        <option value="pending">pending</option>
                        <option value="complete">complete</option>
                </select>
                <div class="flex-btn">
                    <button type="submit" name="update_order" class="btn">update Payment</button>
                    <button type="submit" name="delete_order" class="btn">delete order</button>
                    
                </div>

                </form>

                </div>
            <?php
            }
        }else{


        echo '
        <div class="empty">
             <p>no order takes placed yet</p>
   
        </div>
        ';
        }


        ?>


</div>
        
 </section>
</div>

<script src ="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js">

    </script>
<script type ="text/javascript" src="./script.js"></script>

<?php include '../components/alert.php';?>












    
</body>
</html>