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
    if (isset($_GET['journal_status'])) {
        $journal_status = $_GET['journal_status'];
    }
    if (isset($_GET['journal_id'])) {
        $journal_id = $_GET['journal_id'];
        $data = array();
        $data['journal_id'] = $journal_id;
        $data['journal_status'] = $journal_status;
        //$assign_message = $obj_admin->save_status($_POST);
        if ($journal_status == 6 || $journal_status == 7 || $journal_status == 8 || $journal_status == 5) {
            $check = $obj_admin->check_article_existance($data);
        }
        $result = $obj_admin->under_modification_journal_info_by_id($journal_id);
    }


    $reviewer = $obj_admin->view_reviewer();
} else {
    header("location:index.php");
}
if (isset($_POST['save_status_details'])) {
    $obj_admin = new Admin();
    $obj_admin->save_status_details($_POST);
    $_SESSION['message'] = 'Information Successfully Saved';
    session_regenerate_id(true);
    header('location: fact_sheet.php');
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
                        <p  style="font-size: 14px;font-weight: bolder">Journal title: <a href="<?php echo $result['journal_file']; ?>" download><?php echo $result['journal_title']; ?></a></p>
                        <p  style="font-size: 14px;font-weight: bolder">Author Name: <?php 
                           $users = $obj_admin->view_additional_user($result['journal_id']);
                            foreach ($users as $user){
                                echo $user['additional_author_name'].", ";
                            }
                        ?></p>
                        <p  style="font-size: 14px;font-weight: bolder">Reviewer-1:
                            <?php
                            if ($result['reviewer_1_name'] == '') {
                                echo "Not Assigned";
                            } else {
                                echo $result['reviewer_1_name'];
                            }
                            ?>
                        </p>
                        <p  style="font-size: 14px;font-weight: bolder">Reviewer-2:
                            <?php
                            if ($result['reviewer_2_name'] == '') {
                                echo "Not Assigned";
                            } else {
                                echo $result['reviewer_2_name'];
                            }
                            ?>
                        </p>
                        <p  style="font-size: 14px;font-weight: bolder">Reviewer-3: <?php
                            if ($result['reviewer_3_name'] == '') {
                                echo "Not Assigned";
                            } else {
                                echo $result['reviewer_3_name'];
                            }
                            ?></p>
                    </div>

                    <a href="fact_sheet.php" style="margin-right: 20px" class="btn btn-danger pull-right"><i class="fa fa-arrow-circle-o-left"></i> Go Back</a>
                </div>
                <div>
                    <h4 style="font-weight: bolder;margin-left: 30px;color: #006699">Status Details</h4>

                    <hr style="background-color: #8c8c8c;height: 1.5px;border-top: 3px double #8c8c8c;">
                    <form action="" method="POST" enctype="multipart/form-data" class="form-horizontal">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email">Status:</label>
                                <div class="col-sm-9" style='margin-top: 5px'>
                                    <p style='font-weight: bolder;color: #cc0000'>
                                        <?php
                                        if ($journal_status == 1) {
                                            echo 'Preliminary Review';
                                        } else if ($journal_status == 2) {
                                            echo 'Final Review';
                                        } else if ($journal_status == 3) {
                                            echo 'Modification';
                                        } else if ($journal_status == 4) {
                                            echo 'Verification';
                                        } else if ($journal_status == 5) {
                                            echo 'In Press';
                                        } else if ($journal_status == 6) {
                                            echo 'Accepted';
                                        } else if ($journal_status == 7) {
                                            echo 'Rejected';
                                        } else if ($journal_status == 8) {
                                            echo 'Published';
                                        } else if ($journal_status == 9) {
                                            echo 'Publishable';
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <?php if ($journal_status == 6) { ?>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Accepted Date:</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Accepted date" name="accepted_date" class='form-control dateplugin' value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Acceptance Stage:</label>
                                    <div class="col-sm-9">
                                        <select name="acceptance_stage" class='form-control'>
                                            <option selected disabled>Select</option>
                                            <option value="1">After Preliminary Review </option>
                                            <option value="2">After Final Review</option>
                                            <option value="3">After Verification</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Acceptance letter:</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="acceptance_letter">

                                    </div>
                                </div>

                            <?php } else if ($journal_status == 7) { ?>

                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Rejected Date:</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Rejected date" name="rejected_date" class='form-control dateplugin' required value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Rejected Stage:</label>
                                    <div class="col-sm-9">
                                       <select name="rejected_stage" class='form-control'>
                                            <option selected disabled>Select</option>
                                            <option value="1">After Preliminary Review </option>
                                            <option value="2">After Final Review</option>
                                            <option value="3">After Verification</option>
                                            
                                        </select>
                                    </div>
                                </div>

                            <?php } else if ($journal_status == 8) { ?>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Published Year:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="published_year" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Issue Name:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="issue_name" class="form-control" value="">
                                    </div>
                                </div>
                            <?php } else if ($journal_status == 5) { ?>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Issue Name:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="issue_name" class="form-control" value="">
                                    </div>
                                </div>
                            <?php } ?>

                            <input type="hidden" name="journal_id" value="<?php echo $journal_id; ?>">
                            <input type="hidden" name="journal_status" value="<?php echo $journal_status; ?>">
                            <?php if($journal_status == 5 || $journal_status == 6 || $journal_status == 7 ||$journal_status == 8){ ?>
                            <input type="submit" class="btn btn-primary btn-sm pull-right" name="save_status_details" value="save">
                            <?php } ?>
                        </div>
                    </form> 
                </div>

            </div>

        </div>

    </div>
</section>


<?php include "includes/footer.php" ?>


