
<?php
ob_start();
session_start();

spl_autoload_register(function($class) {
    include "classes/" . $class . ".php";
});
?>

<?php
extract($_POST);
extract($_GET);
if (isset($_SESSION['admin'])) {
    $obj_admin = new Admin();
    if (isset($_GET['verification_id'])) {
        $result = $obj_admin->get_verification_info_by_verification_id($_GET['verification_id']);
    }

    $reviewer = $obj_admin->view_reviewer();
} else {
    header("location:index.php");
}
if (isset($_POST['update_verification'])) {
    $obj_admin = new Admin();
    $assign_message = $obj_admin->update_verification_info($_POST);
    $_SESSION['message'] = 'Information Successfully Updated';
    session_regenerate_id(true);
    header('location: verification_details.php?journal_id=' . $_POST['journal_id']);
    session_write_close();
    //header('location: secondary_review_two.php');
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

                
                <div>
                     <h4 style="font-weight: bolder;margin-left: 30px;color: #006699;margin-top: 20px">Update Verification</h4>
                     
                     <hr style="background-color: #8c8c8c;height: 1.5px;border-top: 3px double #8c8c8c;">
                    <form action="" method="POST" enctype="multipart/form-data" class="form-horizontal">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="verified_by">Verified By:</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="" name="verified_by" class='form-control' value="<?php echo $result['verified_by'] ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="verified_by">Verifier Details:</label>
                                <div class="col-sm-9">
                                    <textarea name="verifier_details" class="form-control" rows="7"><?php echo $result['verifier_details'] ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Sent Date:</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="Sent date" name="sent_date" class='form-control dateplugin' value="<?php if($result['sent_date'] != ""){ echo date('d-m-Y',$result['sent_date']);} ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Submission Due Date:</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="Submission Due date" name="submission_due_date" class='form-control dateplugin' value="<?php if($result['submission_due_date'] != ""){ echo date('d-m-Y',$result['submission_due_date']);} ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Submission Date:</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="Submission date" name="submission_date" class='form-control dateplugin' value="<?php if($result['submission_date'] != ""){ echo date('d-m-Y',$result['submission_date']);} ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Action:</label>
                                <div class="col-sm-9">
                                    <select name="status" class='form-control' style="width: 100%" required="">
                                        <option selected disabled>Select</option>
                                        <option <?php if($result['status'] == 1 || $result['status'] == '')
                                                {echo "selected"; } ?>  value="1">Pending</option>
                                        <option <?php if($result['status'] == 2)
                                                {echo "selected"; } ?>   value="2">Done</option>
                                    </select>
                                </div>
                            </div>


                            <input type="hidden" name="verification_id" value="<?php echo $result['verification_id']; ?>">
                            <input type="hidden" name="journal_id" value="<?php echo $result['journal_id']; ?>">
                            <input type="submit" class="btn btn-primary btn-sm pull-right" name="update_verification" value="Update">
                        </div>
                    </form>
                </div>
                
            </div>

        </div>

    </div>
</section>


<?php include "includes/footer.php" ?>





