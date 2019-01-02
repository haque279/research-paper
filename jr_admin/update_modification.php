
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
    if (isset($_GET['review_report_id'])) {
        $result = $obj_admin->get_review_report_info_by_id($_GET['review_report_id']);
    }

    $reviewer = $obj_admin->view_reviewer();
} else {
    header("location:index.php");
}
if (isset($_POST['update_modification'])) {
    $obj_admin = new Admin();
    $assign_message = $obj_admin->update_review_report_info($_POST);
    $_SESSION['message'] = 'Information Successfully Updated';
    session_regenerate_id(true);
    header('location: modification_details.php?journal_id=' . $_POST['journal_id']);
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
                     <h4 style="font-weight: bolder;margin-left: 30px;color: #006699;margin-top: 20px">Update Modification</h4>
                     
                     <hr style="background-color: #8c8c8c;height: 1.5px;border-top: 3px double #8c8c8c;">
                    <form action="" method="POST" enctype="multipart/form-data" class="form-horizontal">
                        <div class="col-md-5">
                        <h4 style="text-align: center;font-weight: bolder;">Reviewer Section</h4>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="email">Reviewer Type:</label>
                            <div class="col-sm-9">
                                <select name="reviewer_type" class='form-control' style="width: 100%" required="">
                                    <option selected disabled>Select</option>
                                    <option  <?php if($result['reviewer_type'] == 1){echo "selected"; } ?>  value="1">Reviewer 1</option>
                                    <option  <?php if($result['reviewer_type'] == 2){echo "selected"; } ?>   value="2">Reviewer 2</option>
                                    <option  <?php if($result['reviewer_type'] == 3){echo "selected"; } ?>   value="3">Reviewer 3</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="email">Review Report:</label>
                            <div class="col-sm-9">
                                <input type="file" name="reviewer_review_report">
                                <a href="review_files/<?php echo $result['reviewer_review_report']; ?>" download><?php echo $result['reviewer_review_report']; ?></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="email">Review Paper:</label>
                           
                            <div class="col-sm-9">
                                <input type="file" name="reviewer_review_paper">
                                 <a href="review_files/<?php echo $result['reviewer_review_paper']; ?>" download><?php echo $result['reviewer_review_paper']; ?></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="email">Sent Date:</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="Sent date" name="reviewer_sent_date" class='form-control dateplugin' value="<?php if($result['reviewer_sent_date'] != ""){ echo date('d-m-Y',$result['reviewer_sent_date']);} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="email">Submission Due Date:</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="Submission Due date" name="reviewer_submission_due_date" class='form-control dateplugin' value="<?php if($result['reviewer_submission_due_date'] != ""){ echo date('d-m-Y',$result['reviewer_submission_due_date']);} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="email">Submission Date:</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="Submission date" name="reviewer_submission_date" class='form-control dateplugin' value="<?php if($result['reviewer_submission_date']){ echo date('d-m-Y',$result['reviewer_submission_date']); } ?>">
                            </div>
                        </div>
                        </div>
<!--                        Author Section-->
                        <div class="col-md-5">
                        <h4 style="text-align: center;font-weight: bolder;">Author Section</h4>
                        
                        <div class="form-group" style="margin-top: 30px">
                            <label class="control-label col-sm-3" for="email">Review Report:</label>
                            <div class="col-sm-9">
                                <input type="file" name="author_review_report">
                                 <a href="review_files/<?php echo $result['author_review_report']; ?>" download><?php echo $result['author_review_report']; ?></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="email">Review Paper:</label>
                            <div class="col-sm-9">
                                <input type="file" name="author_review_paper">
                                 <a href="review_files/<?php echo $result['author_review_paper']; ?>" download><?php echo $result['author_review_paper']; ?></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="email">Sent Date:</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="Sent date" name="author_sent_date" class='form-control dateplugin' value="<?php if($result['author_sent_date'] != ""){ echo date('d-m-Y',$result['author_sent_date']);} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="email">Submission Due Date:</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="Submission Due date" name="author_submission_due_date" class='form-control dateplugin' value="<?php if($result['author_submission_due_date'] != ""){ echo date('d-m-Y',$result['author_submission_due_date']);} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="email">Submission Date:</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="Submission date" name="author_submission_date" class='form-control dateplugin'  value="<?php if($result['author_submission_date'] != ""){ echo date('d-m-Y',$result['author_submission_date']); } ?>">
                            </div>
                        </div>

                        
                        <input type="hidden" name="journal_status" value="3">

                        <input type="hidden" name="journal_id" value="<?php echo $result['journal_id']; ?>">
                        <input type="hidden" name="review_report_id" value="<?php echo $result['review_report_id']; ?>">
                        <input type="submit" class="btn btn-primary btn-sm pull-right" name="update_modification" value="Update">
                    </div>
                        </form>
                </div>
                
            </div>

        </div>

    </div>
</section>


<?php include "includes/footer.php" ?>




