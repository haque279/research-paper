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
    $result = $obj_admin->fact_sheet();
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
    header('location: fact_sheet.php');
}


if(isset($_POST['save_status'])){
    $obj_admin = new Admin();
    $assign_message = $obj_admin->save_status($_POST);
    header('location: fact_sheet.php');
    session_write_close();
}
if(isset($_POST['update_status_details'])){
    $obj_admin = new Admin();
    $assign_message = $obj_admin->save_status($_POST);
    $journal_status = $_POST['journal_status'];
    $journal_id = $_POST['journal_id'];
    header('location: status_info.php?journal_id='.$journal_id.'&journal_status='.$journal_status);
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
            <div class="col-sm-10 ">
                <div class="table">
                    <div class="table-responsive" id="print">
                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Article No</th>
                                    <th>ID</th>
                                    <th>Article Title</th>
                                    <th>Author Details</th>
                                    <th>Email</th>
                                    <th>Contact no</th>
                                    <th>Submission Date</th>
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
                                    <th scope="row"> <?php echo $res['journal_id']; ?> </th>
                                   <td><a href="journal_details.php?journal_id=<?php echo $res['journal_id']; ?>&journal_no=<?php echo $i ; ?>"><?php echo $res['journal_title']; ?></a></td>
                                    <td>
                                    <?php 
                                       $users = $obj_admin->view_additional_user($res['journal_id']);
                                        foreach ($users as $user){
                                            echo $user['additional_author_name'].", ";
                                        }
                                    ?>
                                    
                                    </td>
                                    <td><?php echo $res['user_email']; ?></td>
                                    <td><?php echo $res['user_contact_no']; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($res['journal_date'])); ?></td>
                                    <td>
                                        <form action="" method="post">
                                            <select name="journal_status">
                                                <option selected disabled>Select</option>
                                                <option <?php if($res['journal_status'] == 1)
                                                {echo "selected"; } ?> value="1">Preliminary Review</option>
                                                <option <?php if($res['journal_status'] == 2)
                                                {echo "selected"; } ?> value="2">Final Review</option>
                                                <option <?php if($res['journal_status'] == 3)
                                                {echo "selected"; } ?> value="3">Modification</option>
                                                <option <?php if($res['journal_status'] == 4)
                                                {echo "selected"; } ?> value="4">Verification</option>
                                                <option <?php if($res['journal_status'] == 5)
                                                {echo "selected"; } ?> value="5">In Press</option>
                                                <option <?php if($res['journal_status'] == 10)
                                                {echo "selected"; } ?> value="10">EC Meeting</option>
                                                <option <?php if($res['journal_status'] == 6)
                                                {echo "selected"; } ?> value="6">Accepted</option>
                                                <option <?php if($res['journal_status'] == 7)
                                                {echo "selected"; } ?> value="7">Rejected</option>
                                                <option <?php if($res['journal_status'] == 8)
                                                {echo "selected"; } ?> value="8">Published</option>
                                                <option <?php if($res['journal_status'] == 9)
                                                {echo "selected"; } ?> value="9">Publishable</option>
                                            </select>
                                            <input type="hidden" name="user_id" value="<?php echo $res['user_id']; ?>">
                                            <input type="hidden" name="journal_id" value="<?php echo $res['journal_id']; ?>">
                                            <input type="submit" class="btn btn-theme" name="save_status" value="Save">
                                            <input type="submit" class="btn btn-theme" name="update_status_details" value="Update Details" style='margin-top: 3px'>
                                            
                                        </form>
                                    </td>
<!--                                    <td>
                                       
                                        <?php
                                        if($res['journal_status'] !=0 && $res['journal_status'] != NULL){ ?>
                                           <a href="status_info.php?journal_id=<?php echo $res['journal_id']; ?>&journal_status=<?php echo $res['journal_status'];?>" class="btn btn-primary btn-xs">Update Status Details</a> 
                                      <?php  }
                                        ?>   
                                            
                                       
                                       </td>-->
                                    <td>
                                        
                                           <p style='font-weight: bolder'>
                                        <?php if($res['journal_status'] == 1){
                                            echo 'Preliminary Review'."<br>";

                                            if($res['journal_preliminary_review_status'] == 2){
                                                echo "<span style='color: green'>Done</span>";
                                            }else if($res['journal_preliminary_review_status'] == 3){
                                                echo "<span style='color: green'>Accepted for Final Review</span>";
                                            }else if($res['journal_preliminary_review_status'] == 4){
                                                echo "<span style='color: green'>Modification</span>";
                                            }else if($res['journal_preliminary_review_status'] == 5){
                                                echo "<span style='color: green'>Rejected</span>";
                                            }



                                        }else if($res['journal_status'] == 2){
                                            echo 'Final Review'."<br>";

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

                                            


                                        }else if($res['journal_status'] == 3){
                                            echo 'Modification';
                                        }else if($res['journal_status'] == 4){
                                            echo 'Verification';
                                            echo "</br>";
                                            echo "<span style='color: red; font-weight: bolder'>";
                                            if ($res['modification_status'] == 2){ echo "Done";}
                                            if ($res['modification_status'] == 3){ echo "Pending";}
                                            echo "<span>";

                                        }else if($res['journal_status'] == 5){
                                            echo 'In Press';
                                        }else if($res['journal_status'] == 6){
                                            echo 'Accepted';
                                        }else if($res['journal_status'] == 7){
                                            echo 'Rejected';
                                        }else if($res['journal_status'] == 8){
                                            echo 'Published';
                                        }else if($res['journal_status'] == 9){
                                            echo 'Publishable';
                                        }else if($res['journal_status'] == 10){
                                            echo 'EC Meeting';
                                        }
                                        
                                        ?>
                                               </p>
                                    </td>


                                </tr>
                                
    <?php $i++;
} ?>
                            <tfoot>
                                <tr>
                                    <th>Article No</th>
                                    <th>Article Title</th>
                                    <th>Author Details</th>
                                    <th>Email</th>
                                    <th>Contact no</th>
                                    <th>Submission Date</th>
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