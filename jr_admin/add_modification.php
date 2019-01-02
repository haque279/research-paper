
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
    if (isset($_GET['journal_id'])) {
        $result = $obj_admin->under_modification_journal_info_by_id($_GET['journal_id']);
    }

    $reviewer = $obj_admin->view_reviewer();
} else {
    header("location:index.php");
}

if (isset($_POST['save_modification'])) {
    $obj_admin = new Admin();
    $assign_message = $obj_admin->add_modification($_POST, $_FILES);
    $_SESSION['message'] = 'Information Successfully Saved';
    $obj_admin->change_modification_status($_GET['journal_id']);
    //session_regenerate_id(true);
    header('location: add_modification.php?journal_id=' . $_POST['journal_id']);
    //session_write_close();
    
}
$reports = $obj_admin->display_modification_report($_GET['journal_id']);
foreach ($reports as $report){
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
                    <div class="col-md-2" style="padding: 0px">
                        <p  style="font-size: 14px;font-weight: bolder">Journal title:</p>
                        <?php if ($result['modification_status']==1){ ?>
                        <p  style="font-size: 14px;font-weight: bolder">Modification Summary:</p>
                        <?php } ?>
                        <p  style="font-size: 14px;font-weight: bolder">Author Name:</p>
                        <p  style="font-size: 14px;font-weight: bolder">Reviewer-1:</p>
                        <p  style="font-size: 14px;font-weight: bolder">Reviewer-2:</p>
                        <p  style="font-size: 14px;font-weight: bolder">Reviewer-3:</p>
                    </div>
                    <div class="col-md-5" style="padding: 0px">
                        <?php if ($result['modification_status']==1){ ?>
                            <p style="font-size: 14px;"><a href="<?php echo $result['modified_journal_file']; ?>" download><?php echo $result['journal_title']; ?></a>
                                <span class="text-danger">modified</span>
                            </p>
                        <?php }else{ ?>
                        <p style="font-size: 14px;"><a href="<?php echo $result['journal_file']; ?>" download><?php echo $result['journal_title']; ?></a>

                        </p>
                        <?php } ?>
                        <?php if ($result['modification_status']==1){ ?>
                        <p style="font-size: 14px;"><a  class="text-danger" href="<?php echo $result['modification_summary']; ?>" download>Modification Summary</a>
                        <?php } ?>


                        </p>
                        <p style="font-size: 14px;margin-left: 2px"><?php echo $result['user_name']; ?></p>
                        <p style="font-size: 14px;"><?php
                            if ($result['reviewer_1_name'] == '') {
                                echo "Not Assigned";
                            } else {
                                echo $result['reviewer_1_name'];
                            }
                            ?></p>
                        <p style="font-size: 14px;"><?php
                            if ($result['reviewer_2_name'] == '') {
                                echo "Not Assigned";
                            } else {
                                echo $result['reviewer_2_name'];
                            }
                            ?></p>
                        <p style="font-size: 14px;"><?php
                            if ($result['reviewer_3_name'] == '') {
                                echo "Not Assigned";
                            } else {
                                echo $result['reviewer_3_name'];
                            }
                            ?></p>
                    </div>
                     <a href="under_modification.php" style="margin-right: 20px" class="btn btn-danger pull-right"><i class="fa fa-arrow-circle-o-left"></i> Go Back</a>
                </div>
                <div class="row">
                     <h4 style="font-weight: bolder;margin-left: 30px;color: #006699">Add Modification</h4>
<!--                     <a href="modification_details.php?journal_id=--><?php //echo $journal_id; ?><!--" style="margin-right: 20px;margin-top: -30px" class="btn btn-danger pull-right">Modification Details</a>-->
                     <hr style="background-color: #8c8c8c;height: 1.5px;border-top: 3px double #8c8c8c;">
                    <form action="" method="POST" enctype="multipart/form-data" class="form-horizontal">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="email">Review Report 1:</label>
                            <div class="col-sm-8">
                                <input type="file" name="reviewer_review_report_1" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="email">Review Paper 1:</label>
                            <div class="col-sm-8">
                                <input type="file" name="reviewer_review_paper_1">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4" for="email">Review Report 2:</label>
                            <div class="col-sm-8">
                                <input type="file" name="reviewer_review_report_2" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="email">Review Paper 2:</label>
                            <div class="col-sm-8">
                                <input type="file" name="reviewer_review_paper_2">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4" for="email">Review Report 3:</label>
                            <div class="col-sm-8">
                                <input type="file" name="reviewer_review_report_3" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="email">Review Paper 3:</label>
                            <div class="col-sm-8">
                                <input type="file" name="reviewer_review_paper_3">
                            </div>
                        </div>


                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Sent Date:</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="Sent date" name="reviewer_sent_date" class='form-control datepicker'>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Due Date of Submission:</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="Submission Due date" name="reviewer_submission_due_date" class='form-control datepicker'>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Submission Date:</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="Submission date" name="reviewer_submission_date" class='form-control datepicker'>
                                </div>
                            </div>

                        <input type="hidden" name="journal_status" value="3">

                        <input type="hidden" name="journal_id" value="<?php echo $result['journal_id']; ?>">
                        <input type="submit" class="btn btn-primary btn-sm pull-right" name="save_modification" value="save">
                    </div>
                        </form>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th colspan="2">Reports</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Review Report 1: <a href="review_files/<?php echo $report['reviewer_review_report_1']; ?>" download><?php if (!empty($report['reviewer_review_report_1'])){ echo "FILE";} ?></a></td>
                                <td>Review Paper 1: <a href="review_files/<?php echo $report['reviewer_review_paper_1']; ?>" download><?php if (!empty($report['reviewer_review_paper_1'])){ echo "FILE";} ?></a></td>
                            </tr>
                            <tr>
                                <td>Review Report 2:  <a href="review_files/<?php echo $report['reviewer_review_report_2']; ?>" download><?php if (!empty($report['reviewer_review_report_2'])){ echo "FILE";} ?></a> </td>
                                <td>Review Paper 2:  <a href="review_files/<?php echo $report['reviewer_review_paper_2']; ?>" download><?php if (!empty($report['reviewer_review_paper_2'])){ echo "FILE";} ?></a> </td>
                            </tr>
                            <tr>
                                <td>Review Report 3:  <a href="review_files/<?php echo $report['reviewer_review_report_3']; ?>" download><?php if (!empty($report['reviewer_review_report_3'])){ echo "FILE";} ?></a> </td>
                                <td>Review Paper 3:  <a href="review_files/<?php echo $report['reviewer_review_paper_3']; ?>" download><?php if (!empty($report['reviewer_review_paper_3'])){ echo "FILE";} ?></a> </td>
                            </tr>
                            <tr>
                                <td>Send date: <?php if (isset($report['reviewer_sent_date'])){echo date('d-m-Y', strtotime($report['reviewer_sent_date'])); } ?></td>
                                <td>Due Date of Submission: <?php if (isset($report['reviewer_submission_due_date'])){echo date('d-m-Y', strtotime($report['reviewer_submission_due_date'])); } ?></td>
                            </tr>
                            <tr>
<!--                                <td>Reviewer Submission Date: --><?php //if (isset($report['reviewer_submission_date'])){ echo date('d-m-Y', strtotime($report['reviewer_submission_date'])); } ?><!--</td>-->
                                <td>Author submission date: <?php if (isset($report['author_submission_date'])){ echo date('d-m-Y', strtotime($report['author_submission_date'])); } ?></td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
                
            </div>

        </div>

    </div>
</section>


<?php include "includes/footer.php" ?>


