<?php
ob_start();
session_start();

spl_autoload_register(function($class) {
    include "classes/" . $class . ".php";
});
?>
<?php
if (isset($_SESSION['admin'])) {
    $obj_admin = new Admin();
       
    $reviewer = $obj_admin->view_reviewer();
} else {
    header("location:index.php");
}

if (isset($_POST['submit'])) {
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
            <div class="col-sm-10">
                <a class="btn btn-primary" href="add_reviewer.php" style="margin-top: 20px;margin-left: 15px">Add Reviewer</a>
                <div class="table">
                    <div class="table-responsive" id="print">
                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Serial No</th>
                                    <th>Department</th>
                                    <th>Name</th>
                                    <th>Details</th>
                                    <th>Contact No</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                   
                                </tr>
                            </thead>
                            <?php
                            $i = 1;
                            foreach ($reviewer as $res) {
                                ?>
                                <tr>
                                    <th scope="row"> <?php echo $i ?> </th>
                                    <td><?php echo $res['reviewer_department']; ?></td>
                                    <td><?php echo $res['reviewer_name']; ?></td>

                                    <td>
                                       <?php echo $res['reviewer_details']; ?>   

                                    </td>

                                    <td>
                                       <?php echo $res['reviewer_contact_no']; ?> 
                                    </td>
                                    <td><?php echo $res['reviewer_email']; ?></td>
                                    
                                    
                                    <td><a href="reviewer_update.php?reviewer_id=<?php  echo $res['reviewer_id']; ?>">Update</a></td>

                                </tr>

    <?php $i++;
}
?>
                            <tfoot>
                                <tr>
                                    <th>Serial No</th>
                                    <th>Department</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Contact No</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>


                        </table>
                    </div>

                    <a class="btn btn-primary" href="javascript:printDiv('print')">Print</a>
                </div>
<!--                <div class="login">-->
<!--                    <h3>Reviewer Registration</h3>-->
<!--                    <p class="text-center" style="color: #fff"> --><?php //if (isset($message)) {
//    echo $message;
//} ?><!-- </p>-->
<!--                    <div class="login_body">-->
<!--                        <form action="" method="post" >-->
<!--                            <input type="text" required name="reviewer_name" class="form-control" placeholder="Your Name">-->
<!--                            <input type="text" required name="reviewer_position" class="form-control" placeholder="Your position">-->
<!--                            <input type="text" required name="reviewer_institute" class="form-control" placeholder="Your Institute">-->
<!--                            <input type="text" required name="reviewer_contact_no" class="form-control" placeholder="Your contact no">-->
<!--                            <input type="email" required name="reviewer_email" class="form-control" placeholder="Your email">-->
<!--                            <input type="password" required name="reviewer_password" pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}" class="form-control" placeholder="Password">-->
<!--                            <p style="color: #eee">Must contain at least one number, one letter and at least 8 characters</p>-->
<!--                            <div class="fix">-->
<!--                                <input type="submit" name="submit" class="btn btn-theme pull-right" value="Registration">-->
<!--                            </div>-->
<!--                        </form>-->
<!---->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
</section>


<?php include "includes/footer.php" ?>

