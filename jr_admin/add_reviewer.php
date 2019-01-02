<?php

ob_start();
session_start();

spl_autoload_register(function($class){
    include "classes/".$class.".php";
});
?>
<?php
if(isset($_SESSION['admin'])){

}else{
    header("location:index.php");
}

    if(isset($_POST['submit'])){
        $obj_admin = new Admin();
        $message = $obj_admin->add_reviewer($_POST);
        header("location:reviewers.php");
    }
?>


<?php include "includes/header.php" ?>
    <section class="main-content">
        <div class="container-fluid">
            <div class="row row-eq-height">
                <div class="col-sm-2 sidebar_bg">
                    <?php include "includes/sidebar.php" ?>
                </div>
                <div class="col-sm-10 ">
                    <div class="login">
                        <h3>Reviewer Registration</h3>
                        <p class="text-center" style="color: #fff"> <?php if(isset($message)){ echo $message ; } ?> </p>
                        <div class="login_body">
                            <form action="" method="post" >
                                <input type="text" required name="reviewer_name" class="form-control" placeholder="Name">
                                <textarea name="reviewer_details" class="form-control" placeholder="Details"></textarea><br/>
                                
                                <input type="text"  name="reviewer_department" class="form-control" placeholder="Department" style="margin-top: -6px">
                                
                                <input type="text"  name="reviewer_contact_no" class="form-control" placeholder="Contact no">
                                <input type="email" required name="reviewer_email" class="form-control" placeholder="Email">
                                
                                <div class="fix">
                                    <input type="submit" name="submit" class="btn btn-theme pull-right" value="Registration">
                                </div>
                            </form>
                            
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php include "includes/footer.php" ?>