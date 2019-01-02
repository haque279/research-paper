
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
    if (isset($_GET['journal_id'])) {
        $result = $obj_admin->get_review_files_by_journal_id($_GET['journal_id']);
    }

    $reviewer = $obj_admin->view_reviewer();
} else {
    header("location:index.php");
}
if (isset($_POST['save_modification_status'])) {
    $obj_admin = new Admin();
    $assign_message = $obj_admin->update_modification_status($_POST);
    header('location: modification_details.php?journal_id='.$_POST['journal_id']);
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


                    <a href="#" style="margin-right: 20px" class="btn btn-danger pull-right"><i class="fa fa-arrow-circle-o-left"></i> Go Back</a>
                </div>
                <h4 style="font-weight: bolder; color: #006699;text-align: center">Modification Details</h4>
                <div style="margin-left: 10px">

                    <div class="table">
                        <div class="table-responsive" id="print">
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><span style="color: #006699">Serial No</span></th>
                                        <th><span style="color: #006699">Reviewer Section</span></th>
                                        <th><span style="color: #006699">Author Section</span></th>
                                        <th><span style="color: #006699">Action</span></th>
                                        <th><span style="color: #006699">Status</span></th>

                                    </tr>
                                </thead>
                                <?php
                                $i = 1;
                                foreach ($result as $res) {
                                    ?>
                                    <tr>
                                        <th scope="row"> <?php echo $i ?> </th>
                                        <td>

                                            <p  style="font-size: 14px;font-weight: bolder">Reviewer Type: <?php if($res['reviewer_type'] == 1){echo "Reviewer 1";}else if($res['reviewer_type'] == 2){echo "Reviewer 2";}else if($res['reviewer_type'] == 3){echo "Reviewer 3";}?></p>
                                            <p  style="font-size: 14px;font-weight: bolder">Review Report: <a href="review_files/<?php echo $res['reviewer_review_report']; ?>" download><?php echo $res['reviewer_review_report']; ?></a></p>
                                            <p  style="font-size: 14px;font-weight: bolder">Review Paper: <a href="review_files/<?php echo $res['reviewer_review_report']; ?>" download><?php echo $res['reviewer_review_paper']; ?></a></p>
                                            <p  style="font-size: 14px;font-weight: bolder">Sent Date: <?php if($res['reviewer_sent_date'] != ""){ echo date('d-m-Y',$res['reviewer_sent_date']); }?></p>
                                            <p  style="font-size: 14px;font-weight: bolder">Submission Due Date: <?php if($res['reviewer_submission_due_date'] != ""){ echo date('d-m-Y',$res['reviewer_submission_due_date']);}?></p>
                                            <p  style="font-size: 14px;font-weight: bolder">Submission Date: <?php if($res['reviewer_submission_date'] != ""){echo date('d-m-Y',$res['reviewer_submission_date']);}?></p>

                                        </td>
                                        <td>
                                            <p  style="font-size: 14px;font-weight: bolder">Review Report: <a href="review_files/<?php echo $res['author_review_report']; ?>" download><?php echo $res['author_review_report']; ?></a></p>
                                            <p  style="font-size: 14px;font-weight: bolder">Review Paper: <a href="review_files/<?php echo $res['author_review_report']; ?>" download><?php echo $res['author_review_paper']; ?></a></p>
                                            <p  style="font-size: 14px;font-weight: bolder">Sent Date: <?php if($res['author_sent_date'] != ""){ echo date('d-m-Y',$res['author_sent_date']); }?></p>
                                            <p  style="font-size: 14px;font-weight: bolder">Submission Due Date: <?php if($res['author_submission_due_date'] != ""){ echo date('d-m-Y',$res['author_submission_due_date']);}?></p>
                                            <p  style="font-size: 14px;font-weight: bolder">Submission Date: <?php if($res['author_submission_date'] != ""){echo date('d-m-Y',$res['author_submission_date']);}?></p>

                                        </td>
                                        <td>
                                            <a class="btn btn-primary" href="update_modification.php?review_report_id=<?php echo $res['review_report_id'];?>">Update</a>
                                            <form action="" method="post" style="margin-top: 20px" >
                                                <select name="status" class='form-control' style="width: 100%" required="">
                                                    <option selected disabled>Select</option>
                                                    <option value="1">Pending</option>
                                                    <option value="2">Done</option>
                                                </select>

                                                
                                                <input type="hidden" name="review_report_id" value="<?php echo $res['review_report_id']; ?>">
                                                <input type="hidden" name="journal_id" value="<?php echo $res['journal_id']; ?>">
                                                

                                                <div class="fix" style='margin-top: 20px'>
                                                    <input type="submit" name="save_modification_status" class="btn btn-theme pull-right" value="Save">
                                                </div>
                                            </form>
                                        </td>    

                                        <td>
                                            <p style="color: red">
                                            <?php
                                            if($res['status'] == 1){
                                                echo "Pending";
                                            }
                                            ?>
                                            </p>
                                            <p style="color: green;font-weight: bolder;">
                                            <?php
                                            if($res['status'] == 2){
                                                echo "Done";
                                            }
                                            ?>
                                            </p>
                                        </td>

                                    </tr>

                                    <?php
                                    $i++;
                                }
                                ?>



                            </table>
                        </div>

                        <a class="btn btn-primary" href="javascript:printDiv('print')">Print</a>
                    </div>

                </div>
            </div>

        </div>

    </div>
</section>


<?php include "includes/footer.php" ?>


