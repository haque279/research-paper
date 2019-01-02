
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
    $result = $obj_admin->final_review();
    //echo "<pre>";
    //print_r($result);exit();
    //$result = $obj_admin->view_approved_user();
    $reviewer = $obj_admin->view_reviewer();
} else {
    header("location:index.php");
}
if (isset($_POST['assign1'])) {
    $obj_admin = new Admin();
    $assign_message = $obj_admin->journal_assign_to_reviewer_1($_POST);
    header('location: final_review.php');
}
if (isset($_POST['assign2'])) {
    $obj_admin = new Admin();
    $assign_message = $obj_admin->journal_assign_to_reviewer_2($_POST);
    header('location: final_review.php');
}

if (isset($_POST['save_final_status'])) {
    $obj_admin = new Admin();
    $assign_message = $obj_admin->save_final_status($_POST);
    header('location: final_review.php');
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
                <div class="table">
                    <div class="table-responsive" id="print">
                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Article No</th>
                                    <th>Article Title</th>
                                    <th>Author Details</th>
                                    <th>Reviewer 1</th>
                                    <th>Reviewer 2</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <?php
                            $i = 1;
                            foreach ($result as $res) {
                                ?>
                                <tr>
                                    <th scope="row"> <?php echo $i ?> </th>
                                    <td><a href="<?php echo $res['journal_file']; ?>" download><?php echo $res['journal_title']; ?></a></td>
                                    <td><?php echo $res['user_name']; ?></td>

                                    <td>
                                        <form action="" method="post">
                                            
                                            <select  name="reviewer_id" class='review_1' style="height: 25px">
                                                <option selected disabled>Select</option>

                                                <?php foreach ($reviewer as $key => $rev) { ?>
                                                    <option <?php if($reviewer[$key]['reviewer_id']==$res['journal_reviewer1_id'])
                                                {echo "selected"; } ?>  value="<?php echo $reviewer[$key]['reviewer_id'] ?>">

                                                        <?php echo $reviewer[$key]['reviewer_name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <input type="date" placeholder="Due date" name="due_date">
                                            <input type="hidden" name="user_id" value="<?php echo $res['user_id']; ?>">
                                            <input type="hidden" name="journal_id" value="<?php echo $res['journal_id']; ?>">
                                            <input type="hidden" name="id" value="<?php echo $res['journal_id']; ?>">
                                            <input type="hidden" name="reviewer_name" value="<?php echo $res['reviewer_name']; ?>">
                                            <input type="hidden" name="journal_title" value="<?php echo $res['journal_title']; ?>">

                                            <input type="submit" class="btn btn-theme btn-xs" name="assign1" value="Assign">
                                            <?php if (isset($assign_message)) { ?>
                                                <input type="button" class="btn-success" value="<?php echo $assign_message; ?> ">

                                            <?php } ?>
                                        </form>
                                        <?php if($res['journal_reviewer1_id'] !=0 && $res['journal_reviewer1_id'] != NULL){ ?>
                                        <a class="btn btn-primary btn-xs" href="reviewer_details.php" style="margin-top: 5px">Reviewer Details</a>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <form action="" method="post">
                                            <select  name="reviewer_id"  id="">
                                                <option selected disabled>Select</option>
                                               <?php foreach ($reviewer as $key => $rev) { ?>
                                                    <option <?php if($reviewer[$key]['reviewer_id']==$res['journal_reviewer2_id'])
                                                {echo "selected"; } ?>  value="<?php echo $reviewer[$key]['reviewer_id'] ?>">

                                                        <?php echo $reviewer[$key]['reviewer_name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <input type="date" placeholder="Due date" name="due_date">
                                            <input type="hidden" name="user_id" value="<?php echo $res['user_id']; ?>">
                                            <input type="hidden" name="journal_id" value="<?php echo $res['journal_id']; ?>">
                                            <input type="hidden" name="id" value="<?php echo $res['journal_id']; ?>">
                                            <input type="hidden" name="reviewer_name" value="<?php echo $res['reviewer_name']; ?>">
                                            <input type="hidden" name="journal_title" value="<?php echo $res['journal_title']; ?>">

                                            <input type="submit" class="btn btn-theme btn-xs" name="assign2" value="Assign">
                                            <?php if (isset($assign_message)) { ?>
                                                <input type="button" class="btn-success" value="<?php echo $assign_message; ?> ">

                                            <?php } ?>
                                        </form>
                                         <?php if($res['journal_reviewer2_id'] !=0 && $res['journal_reviewer2_id'] != NULL){ ?>
                                        <a class="btn btn-primary btn-xs" href="reviewer_details.php">Reviewers Details</a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <form action="" method="post">
                                            <select name="journal_final_review_status">
                                                <option selected disabled>Select</option>
                                                <option value="1">Reviewer-1 Pending</option>
                                                <option value="2">Reviewer-2 Pending</option>
                                                <option value="3">Both Reviewers Pending</option>
                                                <option value="4">Both Reviewers Done</option>
                                            </select>
                                            <input type="hidden" name="user_id" value="<?php echo $res['user_id']; ?>">
                                            <input type="hidden" name="journal_id" value="<?php echo $res['journal_id']; ?>">
                                            <input type="submit" class="btn btn-theme" name="save_final_status" value="Save">
                                        </form>
                                    </td>
                                    <td>
                                        <?php
                                        if ($res['journal_final_review_status'] == 1) {
                                            echo "<span style='color: red; font-weight: bolder'>Reviewer_1 Pending</span>";
                                        }else if($res['journal_final_review_status'] == 2){
                                           echo "<span style='color: red; font-weight: bolder'>Reviewer_2 Pending</span>"; 
                                        }else if($res['journal_final_review_status'] == 3){
                                           echo "<span style='color: red; font-weight: bolder'>Both Reviewers Pending</span>"; 
                                        }else if($res['journal_final_review_status'] == 4){
                                           echo "<span style='color: green; font-weight: bolder'>Both Reviewers Done</span>"; 
                                        }
                                        ?>
                                    </td>

                                </tr>

    <?php $i++;
}
?>
                            <tfoot>
                                <tr>
                                    <th>Article No</th>
                                    <th>Article Title</th>
                                    <th>Author Details</th>
                                    <th>Reviewer 1</th>
                                    <th>Reviewer 2</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                </tr>
                            </tfoot>


                        </table>
                    </div>

                    <a class="btn btn-primary" href="javascript:printDiv('print')">Print</a>
                </div>
            </div>
        </div>
    </div>
</section>


<?php include "includes/footer.php" ?>



