
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
    $obj_journal = new Journal();
    if (isset($_GET['journal_id'])) {
        $result = $obj_admin->under_modification_journal_info_by_id($_GET['journal_id']);
        $reports = $obj_journal->reviewer_report($_GET['journal_id']);
        foreach ($reports as $report){}
    }

    $reviewer = $obj_admin->view_reviewer();
} else {
    header("location:index.php");
}
if (isset($_POST['add_verification'])) {
    $obj_admin = new Admin();
    $obj_admin->add_verification_info($_POST);
    $_SESSION['message'] = 'Information Successfully Saved';
    //session_regenerate_id(true);
    header('location: add_verification.php?journal_id=' . $_POST['journal_id']);
    session_write_close();
    //header('location: secondary_review_two.php');
}
?>


<?php include "includes/header.php" ?>
<style>
    p span {font-weight: 500}
</style>

<section class="main-content">
    <div class="container-fluid">
        <div class="row row-eq-height">
            <div class="col-sm-2 sidebar_bg">
                <?php include "includes/sidebar.php" ?>
            </div>
            <div class="col-sm-10">

                <div class="row" style="margin-top: 20px;margin-left: 30px">
                    <h4 style="color: green">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                        ?>
                    </h4>
                    <h4 style="font-weight: bolder; color: #006699">Journal Details</h4>
                    <hr style="background-color: #8c8c8c;height: 1.5px;border-top: 3px double #8c8c8c;">
                    <div class="col-md-7" style="padding: 0px">
                        <p  style="font-size: 14px;font-weight: bolder">Original Paper: <span><a href="<?php echo $result['journal_file']; ?>" download><?php echo $result['journal_title']; ?></a></span></p>
                        <p  style="font-size: 14px;font-weight: bolder">Modified Paper: <span><a href="<?php echo $result['modified_journal_file']; ?>" download><?php echo "Modified Paper"; ?></a></span></p>
                        <p  style="font-size: 14px;font-weight: bolder">Modification Summary: <span><a href="<?php echo $result['modification_summary']; ?>" download><?php echo "Modification Summary"; ?></a></span></p>
                        <p  style="font-size: 14px;font-weight: bolder">Author Name: <span><?php echo $result['user_name']; ?></span></p>
                        <p  style="font-size: 14px;font-weight: bolder">Reviewer-1 Report:
                            <span>
                            <?php if ($report['reviewer_review_report_1']){ ?>
                                <a href="review_files/<?php echo $report['reviewer_review_report_1']; ?>" download><?php echo "reviewer_review_report_1"; ?></a>
                            <?php } ?> </span>
                        </p>
                        <p  style="font-size: 14px;font-weight: bolder">Reviewer-1 Paper:
                            <span>
                            <?php if ($report['reviewer_review_paper_1']){ ?>
                                <a href="review_files/<?php echo $report['reviewer_review_paper_1']; ?>" download><?php echo "reviewer_review_paper_1"; ?></a>
                            <?php } ?>
                                </span>
                        </p>
                        <p  style="font-size: 14px;font-weight: bolder">Reviewer-2 Report:
                            <span>
                            <?php if ($report['reviewer_review_report_2']){ ?>
                                <a href="review_files/<?php echo $report['reviewer_review_report_2']; ?>" download><?php echo "reviewer_review_report_2"; ?></a>
                            <?php } ?>
                                </span>
                        </p>
                        <p  style="font-size: 14px;font-weight: bolder">Reviewer-2 Paper:
                            <span>
                            <?php if ($report['reviewer_review_paper_2']){ ?>
                                <a href="review_files/<?php echo $report['reviewer_review_paper_2']; ?>" download><?php echo "reviewer_review_paper_2"; ?></a>
                            <?php } ?>
                                </span>
                        </p>
                        <p  style="font-size: 14px;font-weight: bolder">Reviewer-3 Report:
                            <span>
                            <?php if ($report['reviewer_review_report_3']){ ?>
                                <a href="review_files/<?php echo $report['reviewer_review_report_3']; ?>" download><?php echo "reviewer_review_report_3"; ?></a>
                            <?php } ?>
                                </span>
                        </p>
                        <p  style="font-size: 14px;font-weight: bolder">Reviewer-3 Paper:
                            <span>
                            <?php if ($report['reviewer_review_paper_3']){ ?>
                                <a href="review_files/<?php echo $report['reviewer_review_paper_3']; ?>" download><?php echo "reviewer_review_paper_3"; ?></a>
                            <?php } ?>
                                </span>
                        </p>
                    </div>

                    <a href="under_verification.php" style="margin-right: 20px" class="btn btn-danger pull-right"><i class="fa fa-arrow-circle-o-left"></i> Go Back</a>
                </div>
                <div>
                    <h4 style="font-weight: bolder;margin-left: 30px;color: #006699">Add Verification Info</h4>
                    <a href="verification_details.php?journal_id=<?php echo $journal_id; ?>" style="margin-right: 20px;margin-top: -30px" class="btn btn-danger pull-right">Verification Details</a>
                    <hr style="background-color: #8c8c8c;height: 1.5px;border-top: 3px double #8c8c8c;">
                    <form action="" method="POST" enctype="multipart/form-data" class="form-horizontal">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="verified_by">Verified By:</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="" name="verified_by" class='form-control' required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="verified_by">Verifier Details:</label>
                                <div class="col-sm-9">
                                    <textarea name="verifier_details" class="form-control" rows="7"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Sent Date:</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="Sent date" name="sent_date" class='form-control datepicker'>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Due Date of Submission:</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="Submission Due date" name="submission_due_date" class='form-control datepicker'>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Submission Date:</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="Submission date" name="submission_date" class='form-control datepicker'>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Action:</label>
                                <div class="col-sm-9">
                                    <select name="status" class='form-control' style="width: 100%" required="">
                                        <option selected disabled>Select</option>
                                        <option value="2">Done</option>
                                        <option value="3">Pending</option>
                                    </select>
                                </div>
                            </div>


                            <input type="hidden" name="journal_id" value="<?php echo $result['journal_id']; ?>">
                            <input type="submit" class="btn btn-primary btn-sm pull-right" name="add_verification" value="save">
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>
</section>


<?php include "includes/footer.php" ?>


