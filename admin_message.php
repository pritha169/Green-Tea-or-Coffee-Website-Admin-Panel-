
<?php
    include '../components/connection.php';

    session_start();
    $admin_id = $_SESSION['admin_id'];

    if (!isset($admin_id)){
        header('location: login.php');  
    }

    if( isset($_POST['delete'])){


        $delete_id = $_POST['delete_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

        $verify_delete= $conn->prepare("SELECT * FROM `message` WHERE message_id = ?");
        $verify_delete->execute([$delete_id]);
        if($verify_delete->rowcount() > 0){

            $delete_message = $conn->prepare("DELETE FROM `message` WHERE message_id = ?");
            $delete_message->execute([$delete_id]);
            $success_msg[] = 'message deleted';

        }else{

            $warning_msg[]= 'message already deleted';

        }
    }

   
        
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title>green coffe admin panel - unread message'spage</title>
</head>
<body>
    <?php include '../components/admin_header.php';  ?>



<div class = "main">
    <div class="banner">
        <h1>unread message's</h1>
     </div>
<div class="title2">
    <a href="dashboard.php">dashboard</a><span>  /unread message's</span>
</div>

    <section class ="accounts">
        <h1 class="heading">unread message's</h1>
        <div class="box-container">

        <?php
        $select_message= $conn->prepare("SELECT * FROM `message` ");
        $select_message->execute();


        if($select_message->rowcount() > 0){
            while($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)){
               




                ?>
                <div class="box">
                    <h3 class="name"><?= $fetch_message['name']; ?></h3>
                    <h4><?= $fetch_message['email'];?></h4>
                    <h4><?= $fetch_message['number'];?></h4>
                    <p><?=$fetch_message['message'];?></p>

                    <form action="" method="post" class="flex-btn">
                        <input type ="hidden" name="delete_id" value="<?=$fetch_message['message_id'];?>">
                        <button type="submit" name="delete" class="btn" onclick="return confirm('delete this message');">delete message</button>
                    </form>
                    
           
            </div>
                <?php
            }
        }else{


        echo '
        <div class="empty">
             <p>no message send yet yet</p>
   
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