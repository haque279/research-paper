<?php
spl_autoload_register(function($class){
    include "classes/".$class.".php";
})
?>
<?php
session_start();
if(isset($_SESSION['admin'])){
    header("location: view_user.php");
}


if(isset($_POST['login_submit'])){
    $obj_admin= new Admin();
    $message = $obj_admin->admin_login($_POST);
}

?>

<?php include "includes/header.php" ?>
    <section class="main-content login_page">
        <div class="container-fluid">
            <div class="row row-eq-height">
<!--                <div class="col-sm-2 sidebar_bg">-->
<!--                    --><?php //include "includes/sidebar.php" ?>
<!--                </div>-->
                <div class="col-sm-12">
                    <div class="login ">
                        <h3>Welcome, Please login</h3>
                        <p style="text-align: center; color: #E81123">
                            <?php
                               if(isset($message)){
                                   echo $message;
                               }
                            ?>
                        </p>

                        <form action="" method="post">
                            <div class="login_body" style="overflow: hidden">
                            <input type="email" name="admin_email" class="form-control" placeholder="Enter your email">
                            <input type="password" name="admin_password" class="form-control" placeholder="Enter your password">
                            <input type="submit" class="btn btn-theme  pull-right" name="login_submit" value="Login">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include "includes/footer.php" ?>