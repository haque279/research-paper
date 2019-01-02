<?php

ob_start();
session_start();

spl_autoload_register(function($class){
    include "classes/".$class.".php";
});

$obj_admin = new Admin();

$reviewer_id = $_GET['reviewer_id'];
if (isset($reviewer_id)){
    $reviewers = $obj_admin->reviewer_single($reviewer_id);
    foreach ($reviewers as $rev){

    }
}

?>
<?php
if(isset($_SESSION['admin'])){

}else{
    header("location:index.php");
}

if(isset($_POST['submit'])){

    $message = $obj_admin->update_single_reviewer($_POST);

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
                                <input type="hidden" value="<?php echo $reviewer_id;  ?>" name="reviewer_id">
                                <label for="">Name</label>
                                <input type="text" required name="reviewer_name" class="form-control" placeholder="Name" value="<?php if (isset($rev['reviewer_name'])){echo $rev['reviewer_name']; } ?>">
                                <label for="">Details</label>
                                <textarea name="reviewer_details" class="form-control" placeholder="Details"> <?php if (isset($rev['reviewer_details'])){echo $rev['reviewer_details']; } ?></textarea><br/>

                                <label for="">Department</label>
                                <input type="text"  name="reviewer_department" class="form-control" placeholder="Department" style="margin-top: -6px" value="<?php if (isset($rev['reviewer_department'])){echo $rev['reviewer_department']; } ?>">

                                <label for="">Contact No.</label>
                                <input type="text"  name="reviewer_contact_no" class="form-control" placeholder="Contact no" value="<?php if (isset($rev['reviewer_contact_no'])){echo $rev['reviewer_contact_no']; } ?>">
                                <label for="">Email</label>
                                <input type="email" required name="reviewer_email" class="form-control" placeholder="Email" value="<?php if (isset($rev['reviewer_email'])){echo $rev['reviewer_email']; } ?>">

                                <div class="fix">
                                    <input type="submit" name="submit" class="btn btn-theme pull-right" value="Update Reviewer Information">
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
    </section>


<?php include "includes/footer.php" ?>