<?php
ob_start();
session_start();

spl_autoload_register(function($class) {
    include "classes/" . $class . ".php";
});
if(isset($_GET['journal_id'])){
    $obj_admin = new Admin();
    $res = $obj_admin->journal_info_by_id($_GET['journal_id']);
    
}
?>

<?php
if (isset($_SESSION['admin'])) {
    $obj_admin = new Admin();
    $result = $obj_admin->final_review();
    //echo "<pre>";
    //print_r($result);exit();
    //$result = $obj_admin->view_approved_user();
    $reviewer_type = $_POST['reviewer_type'];
    $reviewer = $obj_admin->view_reviewer();
} else {
    header("location:index.php");
}
if (isset($_POST['assign_reviewer'])) {
    $obj_admin = new Admin();
    $assign_message = $obj_admin->journal_assign($_POST);
    header('location: final_review.php');
    // session_write_close();
}

?>


<?php include "includes/header.php" ?>
<section class="main-content">
    <div class="container-fluid">
        <div class="row row-eq-height">
            <div class="col-sm-2 sidebar_bg">
                <?php include "includes/sidebar.php" ?>
            </div>
            <div class="col-md-offset-1 col-md-7">
                <div>
                    <h3><?php if($reviewer_type == 1){echo 'Assign Reviewer-1';}else if($reviewer_type == 2){echo 'Assign Reviewer-2';}else if($reviewer_type == 3){echo 'Assign Reviewer-3'; }?></h3>
                    <p class="text-center" style="color: #fff"> <?php if (isset($message)) {
                    echo $message;
                } ?> </p>
                    <div>
                        <form action="" method="post" >
                            <select name="reviewer_id" class='review_1 form-control' style="width: 100%" required="">
                                <option selected disabled>Select</option>

                                    <?php foreach ($reviewer as $key => $rev) { ?>
                                    <option value="<?php echo $reviewer[$key]['reviewer_id'] ?>">

                                    <?php echo $reviewer[$key]['reviewer_name']; ?>
                                    </option>
<?php } ?>
                            </select>
                            <input type="text" placeholder="Submission date" name="submission_due_date" id='datepicker' class='form-control'>
                            <input type="hidden" name="user_id" value="<?php echo $res['user_id']; ?>">
                            <input type="hidden" name="journal_id" value="<?php echo $res['journal_id']; ?>">
                            <input type="hidden" name="id" value="<?php echo $res['journal_id']; ?>">
                            <input type="hidden" name="reviewer_name" value="<?php echo $res['reviewer_name']; ?>">
                            <input type="hidden" name="reviewer_type" value="<?php echo $reviewer_type; ?>">
                            <input type="hidden" name="journal_title" value="<?php echo $res['journal_title']; ?>">
                            <div class="fix" style='margin-top: 20px'>
                                <input type="submit" name="assign_reviewer" class="btn btn-theme pull-right" value="Assign">
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php include "includes/footer.php" ?>

