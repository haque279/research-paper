<?php
ob_start();
session_start();

spl_autoload_register(function($class){
    include "classes/".$class.".php";
});
?>
<?php

if(isset($_SESSION['reviewer_id'])){
    $obj_admin = new Admin();


} else { header("location:../index.php"); }
if(isset($_POST['submit'])){
    $message =  $obj_admin->reviewer_change_password($_POST);
}
?>


<?php include "includes/header.php" ?>
    <section class="main-content">
        <div class="container-fluid">
            <div class="row row-eq-height">
                <div class="col-sm-12 ">
                        <div class="login" style="margin-top: 10%">
                            <h3>Change Password</h3>
                            <p class="text-center" style="color: orangered"> <?php if(isset($message)){ echo $message ; } ?> </p>
                            <div class="login_body">
                                <form action="#" method="post" >
                                    <input type="hidden" required value="<?php echo $_SESSION['reviewer_email']; ?>" name="reviewer_email" class="form-control" placeholder="Name">

                                    <p style="color: #ddd">Current Password</p>
                                    <input type="password"  name="reviewer_password" class="form-control" placeholder="" style="margin-top: -6px">

                                    <p style="color: #ddd">New Password</p>
                                    <input type="password"  name="new_password" class="form-control" placeholder="" style="margin-top: -6px">

                                    <p style="color: #ddd">Confirm Password</p>
                                    <input type="password"  name="confirm_password" class="form-control" placeholder="" style="margin-top: -6px">



                                    <div class="fix">
                                        <input type="submit" name="submit" class="btn btn-theme pull-right" value="Change Password">
                                    </div>
                                </form>

                            </div>
                        </div>
                </div>
            </div>
        </div>
    </section>

<?php include "includes/footer.php" ?>