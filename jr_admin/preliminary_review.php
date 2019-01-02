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
    $result = $obj_admin->preliminary_review();
    //echo "<pre>";
    //print_r($result);exit();
    //$result = $obj_admin->view_approved_user();
    $reviewer = $obj_admin->view_reviewer();
} else {
    header("location:index.php");
}
if (isset($_POST['assign'])) {
    $obj_admin = new Admin();
    $assign_message = $obj_admin->journal_assign($_POST);
    header('location: preliminary_review.php');
}

if(isset($_POST['save_status'])){
    $obj_admin = new Admin();
    $assign_message = $obj_admin->save_preliminary_review_status($_POST);
    header('location: preliminary_review.php');
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
                                    <th>Email</th>
                                    <th>Contact no</th>
                                    <th>Submission Date</th>
                                    <th>Review</th>
<!--                                    <th>Review Action</th>-->
                                    <th>Review Status</th>
                                </tr>
                            </thead>
<?php
$i = 1;
foreach ($result as $res) {
    ?>
                                <tr>
                                    <th scope="row"> <?php echo $i ?> </th>
                                  <td><a href="journal_details.php?journal_id=<?php echo $res['journal_id']; ?>&journal_no=<?php echo $i ; ?>"><?php echo $res['journal_title']; ?></a></td>
                                    <td><?php echo $res['user_name']; ?></td>
                                    <td><?php echo $res['user_email']; ?></td>
                                    <td><?php echo $res['user_contact_no']; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($res['journal_date'])); ?></td>
<!--                                    <td>
                                        <form action="" method="post" name="review_form" id="review_form">
                                            <select  name="reviewer_id"  id="reviewer_id">
                                                <option selected disabled>Select</option>
                                                <option value="1">Pending</option>
                                                <option value="2">Done</option>
                                            </select>
                                            <input type="hidden" name="user_id" value="<?php echo $res['user_id']; ?>">
                                            <input type="hidden" name="journal_id" value="<?php echo $res['journal_id']; ?>">

                                            <input type="submit" class="btn btn-theme" name="assign" value="Save">
                                                    <?php if (isset($assign_message)) { ?>
                                                <input type="button" class="btn-success" value="<?php echo $assign_message; ?> ">

                                                <?php } ?>
                                        </form>

                                    </td>-->
                                    <td>
                                        <form action="" method="post">
                                            <select name="journal_preliminary_review_status">
                                                <option selected disabled>Select</option>
                                                <option value="1">Pending</option>
                                                <option value="2">Done</option>
                                                <option value="3">Accepted For Final Review</option>
                                                <option value="4">Modification</option>
                                                <option value="5">Rejected</option>
                                               
                                            </select>
                                            <input type="hidden" name="user_id" value="<?php echo $res['user_id']; ?>">
                                            <input type="hidden" name="journal_id" value="<?php echo $res['journal_id']; ?>">
                                            <input type="submit" class="btn btn-theme" name="save_status" value="Save">
                                        </form>
                                    </td>
                                    <td>
                                        
                                      <?php if($res['journal_preliminary_review_status'] == 1)
                                                {
                                                    echo "<span style='color: red'>Pending</span>"; 
                                          
                                               }else{
                                                   if($res['journal_preliminary_review_status'] == 2){
                                                       echo "<span style='color: green'>Done</span>";
                                                   }else if($res['journal_preliminary_review_status'] == 3){
                                                        echo "<span style='color: green'>Accepted for Final Review</span>";
                                                   }else if($res['journal_preliminary_review_status'] == 4){
                                                        echo "<span style='color: green'>Modification</span>";
                                                   }else if($res['journal_preliminary_review_status'] == 5){
                                                        echo "<span style='color: green'>Rejected</span>";
                                                   }
                                               } 
                                                ?>  
                                    </td>

                                </tr>
                                
    <?php $i++;
} ?>
                            <tfoot>
                                <tr>
                                    <th>Serial No</th>
                                    <th>Author Name</th>
                                    <th>Email</th>
                                    <th>Contact no</th>
                                    <th>Journal</th>
                                    <th>Assign to</th>
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