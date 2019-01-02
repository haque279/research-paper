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
    if(isset($_GET['journal_id'])){
       $result = $obj_admin->final_review($_GET['journal_id']); 
    }else{
       $result = $obj_admin->final_review(); 
    }
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
                                    <th>Reviewer 3</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <?php
                            $i = 1;
                            foreach ($result as $res) {
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $i ?></th>
                                    <td><a href="journal_details.php?journal_id=<?php echo $res['journal_id']; ?>&journal_no=<?php echo $i ; ?>"><?php echo $res['journal_title']; ?></a></td>
                                    <td>
                                        <?php echo $res['user_name']."<br/>"; ?>
                                        <?php echo $res['user_email']."<br/>"; ?>
                                        <?php echo $res['user_contact_no']; ?>
                                    </td>

                                    <td>
                                        <?php if($res['journal_reviewer1_assign_status'] != 2){ ?>
                                        <form action="assign_reviewer.php?journal_id=<?php echo $res['journal_id'];?>" method="post">
                                        <?php }else{ ?>
                                            <form action="reviewer_details.php?journal_id=<?php echo $res['journal_id'];?>" method="post">
                                        <?php  } ?>
                                        <input type="hidden" name="reviewer_type" value="1">
                                        <?php if($res['journal_reviewer1_assign_status'] != 2){?>
                                        <input type="submit" class="btn btn-primary btn-xs" name="assign_reviewer_one" value="Assign Reviewer">
                                        <?php }else{ ?>
                                         <input type="submit" class="btn btn-primary btn-xs" name="assign_reviewer_one" value="Reviewer Details">  
                                      <?php  } ?>
                                        </form>
                                    </td>

                                    <td>
                                        <?php if($res['journal_reviewer2_assign_status'] != 2){ ?>
                                        <form action="assign_reviewer.php?journal_id=<?php echo $res['journal_id'];?>" method="post">
                                        <?php }else{ ?>
                                            <form action="reviewer_details.php?journal_id=<?php echo $res['journal_id'];?>" method="post">
                                        <?php  } ?>
                                        <input type="hidden" name="reviewer_type" value="2">
                                        <?php if($res['journal_reviewer2_assign_status'] != 2){?>
                                        <input type="submit" class="btn btn-primary btn-xs" name="assign_reviewer_two" value="Assign Reviewer">
                                        <?php }else{ ?>
                                         <input type="submit" class="btn btn-primary btn-xs" name="assign_reviewer_two" value="Reviewer Details">  
                                      <?php  } ?>
                                        </form>
                                    </td>
                                    <td>
                                        <?php if($res['journal_reviewer3_assign_status'] != 2){ ?>
                                        <form action="assign_reviewer.php?journal_id=<?php echo $res['journal_id'];?>" method="post">
                                        <?php }else{ ?>
                                            <form action="reviewer_details.php?journal_id=<?php echo $res['journal_id'];?>" method="post">
                                        <?php  } ?>
                                        <input type="hidden" name="reviewer_type" value="3">
                                        <?php if($res['journal_reviewer3_assign_status'] != 2){?>
                                        <input type="submit" class="btn btn-primary btn-xs" name="assign_reviewer_two" value="Assign Reviewer">
                                        <?php }else{ ?>
                                         <input type="submit" class="btn btn-primary btn-xs" name="assign_reviewer_two" value="Reviewer Details">  
                                      <?php  } ?>
                                        </form>
                                    </td>
                                    
                                    <td>
                                        <form action="" method="post">
                                            <select name="journal_final_review_status">
                                                <option selected disabled>Select</option>
                                                <option value="1">Reviewer-1 Pending</option>
                                                <option value="2">Reviewer-2 Pending</option>
                                                <option value="3">Both Reviewers Pending</option>
                                                <option value="4">Both Reviewers Done</option>
                                                <option value="5">Reviewer-3 Pending</option>
                                                <option value="6">Reviewer-3 Done</option>
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
                                        }else if($res['journal_final_review_status'] == 5){
                                            echo "<span style='color: red; font-weight: bolder'>Reviewer_3 Pending</span>"; 
                                        }else if($res['journal_final_review_status'] == 6){
                                             echo "<span style='color: green; font-weight: bolder'>Reviewer_3 Done</span>"; 
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
                                    <th>Reviewer 3</th>
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