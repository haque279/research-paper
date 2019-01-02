<?php
ob_start();
session_start();

spl_autoload_register(function($class) {
    include "classes/" . $class . ".php";
});
?>

<?php
extract($_POST);
if (isset($_SESSION['admin'])) {
    $obj_admin = new Admin();
    //$result = $obj_admin->final_review();
    //echo "<pre>";
    //print_r($result);exit();
    //$result = $obj_admin->view_approved_user();
    if (isset($_GET['reviewer_type'])) {
        $reviewer_type = $_GET['reviewer_type'];
    } else {
        $reviewer_type = $_POST['reviewer_type'];
    }


    $obj_admin = new Admin();
    if (isset($_GET['journal_id'])) {
        $journal_id = $_GET['journal_id'];
    } else if (isset($_POST['journal_id'])) {
        $journal_id = $_POST['journal_id'];
    }

    $res = $obj_admin->journal_user_info_by_id($journal_id);
    $assign_info = $obj_admin->reviewer_assign_info_by_id($journal_id, $reviewer_type);
    //print_r($assign_info);exit();
    $reviewer = $obj_admin->view_reviewer();
} else {
    header("location:index.php");
}
if (isset($_POST['update_reviewer'])) {
    $obj_admin = new Admin();
    $assign_message = $obj_admin->update_reviewer($_POST);

    header('location: reviewer_details.php?journal_id=' . $_POST['journal_id'] . "&reviewer_type=" . $_POST['reviewer_type']);
}
if (isset($_POST['save_comment'])) {
    $obj_admin = new Admin();
    $assign_message = $obj_admin->update_comment($_POST);
    header('location: reviewer_details.php?journal_id=' . $_POST['journal_id'] . "&reviewer_type=" . $_POST['reviewer_type']);
}
if (isset($_POST['upload_report'])) {
    $obj_admin = new Admin();
    $journal_status = 2; // Final Review
    $assign_message = $obj_admin->upload_review_report($_POST, $journal_status);
    //session_regenerate_id(true);
    header('location: reviewer_details.php?journal_id=' . $_POST['journal_id'] . "&reviewer_type=" . $_POST['reviewer_type']);
    session_write_close();
}
if (isset($_POST['upload_paper'])) {
    $obj_admin = new Admin();
    $journal_status = 2; // Final Review
    $assign_message = $obj_admin->upload_review_paper($_POST, $journal_status);
    //session_regenerate_id(true);
    header('location: reviewer_details.php?journal_id=' . $_POST['journal_id'] . "&reviewer_type=" . $_POST['reviewer_type']);
    session_write_close();
}
if (isset($_POST['save_honorarium'])) {
    $obj_admin = new Admin();
    $obj_admin->update_honorarium_info($_POST);
   // session_regenerate_id(true);
    header('location: reviewer_details.php?journal_id=' . $_POST['journal_id'] . "&reviewer_type=" . $_POST['reviewer_type']);
    session_write_close();
}
if (isset($save_submission_date)) {
    $obj_admin = new Admin();
    session_regenerate_id(true);
    $assign_message = $obj_admin->save_submission_date($_POST);
    header('location: reviewer_details.php?journal_id=' . $_POST['journal_id'] . "&reviewer_type=" . $_POST['reviewer_type']);
    session_write_close();
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
                <div style="margin-left: 10px">
                    <h3><?php
                        if ($reviewer_type == 1) {
                            echo 'Update Reviewer-1';
                        } else if($reviewer_type == 2) {
                            echo 'Update Reviewer-2';
                        }else if($reviewer_type == 3){
                             echo 'Update Reviewer-3';
                        }
                        ?></h3>
                    <p class="text-center" style="color: #fff"> <?php
                        if (isset($message)) {
                            echo $message;
                        }
                        ?> </p>
                    <div>
                        <form action="" method="post" >
                            <select name="reviewer_id" class='review_1 form-control' style="width: 100%" required="">
                                <option selected disabled>Select</option>

                                <?php foreach ($reviewer as $key => $rev) { ?>
                                    <option <?php
                                    if ($reviewer[$key]['reviewer_id'] == $assign_info['reviewer_id']) {
                                        echo "selected";
                                    }
                                    ?> value="<?php echo $reviewer[$key]['reviewer_id'] ?>">

                                        <?php echo $reviewer[$key]['reviewer_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="hidden" placeholder="Submission date" name="submission_due_date" id='datepicker' class='form-control' value="<?php echo date('m/d/Y', strtotime($assign_info['submission_due_date'])); ?>">

                            <input type="hidden" name="user_id" value="<?php echo $res['user_id']; ?>">
                            <input type="hidden" name="journal_id" value="<?php echo $assign_info['journal_id']; ?>">
                            <input type="hidden" name="reviewer_assign_id" value="<?php echo $assign_info['reviewer_assign_id']; ?>">
                            <input type="hidden" name="reviewer_name" value="<?php echo $assign_info['reviewer_name']; ?>">
                            <input type="hidden" name="reviewer_type" value="<?php echo $reviewer_type; ?>">
                            <input type="hidden" name="journal_title" value="<?php echo $res['journal_title']; ?>">
                            <div class="fix" style='margin-top: 20px'>
                                <input type="submit" name="update_reviewer" class="btn btn-theme pull-right" value="Update">
                            </div>
                        </form>

                    </div>
                </div>
                <div class="row" style="margin-top: 20px;margin-left: 30px">
                    <h4 style="color: red">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                        ?>
                    </h4>
                    <h4 style="font-weight: bolder; color: #333300">Reviewer Details :-</h4>

                    <div class="col-md-1" style="padding: 0px">
                        <p  style="font-size: 14px;font-weight: bolder">Name:</p>
                        <p  style="font-size: 14px;font-weight: bolder">Institute:</p>
                        <p  style="font-size: 14px;font-weight: bolder">Contact No:</p>
                        <p  style="font-size: 14px;font-weight: bolder">Email:</p>
                    </div>
                    <div class="col-md-5" style="padding: 0px">
                        <p style="font-size: 14px;"><?php echo $assign_info['reviewer_name']; ?></p>
                        <p style="font-size: 14px;"><?php echo $assign_info['reviewer_institute']; ?></p>
                        <p style="font-size: 14px;"><?php echo $assign_info['reviewer_contact_no']; ?></p>
                        <p style="font-size: 14px;"><?php echo $assign_info['reviewer_email']; ?></p>
                    </div>
                    <a href="final_review.php" style="margin-right: 20px" class="btn btn-danger pull-right"><i class="fa fa-arrow-circle-o-left"></i> Go Back</a>
                </div>
                <div style="margin-left: 10px">

                    <div class="table">
                        <div class="table-responsive" id="print">
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Assign Date</th>
<!--                                        <th>Due Date of Submission</th>-->
                                        <th>Submission Date</th>
                                        <th>Comment</th>
                                        <th>Review Report</th>
                                        <th>Review Paper/Edited Article</th>
                                        <th>Honorarium Status</th>
                                    </tr>
                                </thead>
                                <?php
                                $i = 1;
                                ?>
                                <tr>

                                    <td><span style="font-weight: bolder;text-align: center"><?php echo date('d-m-Y', $assign_info['assign_date']) ?></span></td>
<!--                                    <td>-->
<!--                                       <span style="font-weight: bolder;text-align: center"> --><?php //echo date('d-m-Y', $assign_info['submission_due_date']) ?><!--</span>-->
<!--                                    </td>-->
                                    <td>
                                        <p style="font-weight: bolder;text-align: center">
                                            <?php
                                            if ($assign_info['submission_date'] != "") {
                                                echo date('d-m-Y',$assign_info['submission_date']);
                                            }
                                            ?>
                                        </p>
                                        <form action="reviewer_details.php" method="post">
                                            <input type="text" placeholder="Select date" name="submitted_on" class='form-control dateplugin' required>
                                            <input type="hidden" name="reviewer_type" value="<?php echo $assign_info['reviewer_type']; ?>">
                                            <input type="hidden" name="journal_id" value="<?php echo $assign_info['journal_id']; ?>">
                                            <input type="hidden" name="reviewer_assign_id" value="<?php echo $assign_info['reviewer_assign_id']; ?>">
                                            <input type="submit" class="btn btn-theme btn-xs" name="save_submission_date" value="save">
                                        </form>
                                    </td>    
                                    <td>
                                        <form action="reviewer_details.php" method="post">
                                            <textarea placeholder="Your Comment" name="comment" rows="5" cols="20" class="form-control" required><?php echo $assign_info['comment']; ?></textarea>
                                            <input type="hidden" name="reviewer_assign_id" value="<?php echo $assign_info['reviewer_assign_id']; ?>">
                                            <input type="hidden" name="reviewer_type" value="<?php echo $assign_info['reviewer_type']; ?>">
                                            <input type="hidden" name="journal_id" value="<?php echo $assign_info['journal_id']; ?>">
                                            <input type="submit" class="btn btn-theme btn-xs" name="save_comment" value="save">
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Upload Report -->
                                        <form action="reviewer_details.php" method="POST" enctype="multipart/form-data">
                                            <input type="file" name="review_report" required>
                                            <input type="hidden" name="reviewer_assign_id" value="<?php echo $assign_info['reviewer_assign_id']; ?>">
                                            <input type="hidden" name="journal_status" value="2">
                                            <input type="hidden" name="reviewer_type" value="<?php echo $reviewer_type; ?>">
                                            <input type="hidden" name="journal_id" value="<?php echo $assign_info['journal_id']; ?>">
                                            <input type="submit" class="btn btn-theme btn-xs" name="upload_report" value="save">
                                        </form>
                                        <?php
                                        if ($assign_info['review_report'] != NULL) {
                                            ?>
                                            <a class="btn btn-xs btn-success" href="review_files/<?php echo $assign_info['review_report']; ?>">Download</a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <!-- Upload Paper -->
                                        <form action="reviewer_details.php" method="POST" enctype="multipart/form-data">
                                            <input type="file" name="review_paper" required>
                                            <input type="hidden" name="reviewer_assign_id" value="<?php echo $assign_info['reviewer_assign_id']; ?>">
                                            <input type="hidden" name="journal_status" value="2">
                                            <input type="hidden" name="reviewer_type" value="<?php echo $reviewer_type; ?>">
                                            <input type="hidden" name="journal_id" value="<?php echo $assign_info['journal_id']; ?>">
                                            <input type="submit" class="btn btn-theme btn-xs" name="upload_paper" value="save">
                                        </form>
                                        <?php
                                        if ($assign_info['review_paper'] != NULL) {
                                            ?>
                                            <a class="btn btn-xs btn-success" href="review_files/<?php echo $assign_info['review_paper']; ?>">Download</a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <p style="font-weight: bolder;color: red">
                                            <?php
                                            if ($assign_info['honorarium_status'] == "" | $assign_info['honorarium_status'] == 1) {
                                                echo 'Pending';
                                            }
                                            ?>
                                        </p>
                                        <p style="font-weight: bolder;color: green">
                                            <?php
                                            if ($assign_info['honorarium_status'] == 2) {
                                                echo 'Done';
                                            }
                                            ?>
                                        </p>
                                        <p style="margin-top: -5px">
                                            <?php
                                            if ($assign_info['honorarium_sent_date'] != "") {
                                                echo "<span style='color: #CD853F;font-weight: bolder'>Sent Date:</span> " . date('d-m-Y', $assign_info['honorarium_sent_date']);
                                            }
                                            ?>  
                                        </p>
                                        <form action="" method="post" >
                                            <select name="honorarium_status" class='form-control' style="width: 100%" required>
                                                <option selected disabled>Select</option>
                                                <option value="1">Pending</option>
                                                <option value="2">Done</option>
                                            </select>
                                            <input type="text" placeholder="Sent date" name="sent_date" class='form-control dateplugin'>
                                            <input type="hidden" name="user_id" value="<?php echo $res['user_id']; ?>">
                                            <input type="hidden" name="journal_id" value="<?php echo $assign_info['journal_id']; ?>">
                                            <input type="hidden" name="reviewer_assign_id" value="<?php echo $assign_info['reviewer_assign_id']; ?>">
                                            <input type="hidden" name="reviewer_name" value="<?php echo $assign_info['reviewer_name']; ?>">
                                            <input type="hidden" name="reviewer_type" value="<?php echo $reviewer_type; ?>">

                                            <div class="fix" style='margin-top: 20px'>
                                                <input type="submit" name="save_honorarium" class="btn btn-theme pull-right" value="Save">
                                            </div>
                                        </form>
                                    </td>

                                </tr>





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
