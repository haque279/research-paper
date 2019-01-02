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
        //echo "<pre>";
        //print_r($result);exit();
    }

    $reviewer = $obj_admin->view_reviewer();
} else {
    header("location:index.php");
}
if (isset($_POST['save_modification'])) {
    $obj_admin = new Admin();
    $assign_message = $obj_admin->add_modification($_POST);
    $_SESSION['message'] = 'Information Successfully Saved';
    //session_regenerate_id(true);
    header('location: add_modification.php?journal_id=' . $_POST['journal_id']);
    //session_write_close();
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
                    <h4 style="font-weight: bolder; color: #006699">Article Details</h4>
                     <hr style="background-color: #8c8c8c;height: 1.5px;border-top: 3px double #8c8c8c;">
                    <div class="col-md-6" style="padding: 0px">
                        <p  style="font-size: 14px;font-weight: bolder">Article No - <?php if(isset($_GET['journal_no'])){echo $_GET['journal_no'];}?></p>
                        <p  style="font-size: 14px;font-weight: bolder">Article title -</p>
<!--                        <p style="font-size: 14px;"><a href="--><?php //echo $result['journal_file']; ?><!--" download>--><?php //echo $result['journal_title']; ?><!--</a></p>-->

                        <?php if ($result['modification_status']==1){ ?>
                            <p style="font-size: 14px;"><a href="<?php echo $result['modified_journal_file']; ?>" ><?php echo $result['journal_title']; ?></a>
                                <span class="text-danger">modified</span>
                            </p>
                        <?php }else{ ?>
                            <p style="font-size: 14px;"><a href="<?php echo $result['journal_file']; ?>"><?php echo $result['journal_title']; ?></a>

                            </p>
                        <?php } ?>


                         
                        <p  style="font-size: 14px;font-weight: bolder">Author Details -</p>
                        <p style="font-size: 14px;margin-left: 2px">
                            <span style="font-size: 14px;color: #006699;font-weight: bolder">Name: </span><?php echo $result['user_name'];?><br/>
                            <span style="font-size: 14px;color: #006699;font-weight: bolder">Address: </span><?php echo $result['user_address'];?><br/>
                            <span style="font-size: 14px;color: #006699;font-weight: bolder">Email: </span><?php echo $result['user_email'];?><br/>
                            <span style="font-size: 14px;color: #006699;font-weight: bolder">Contact: </span><?php echo $result['user_contact_no'];?><br/>
                         
                        </p>
                        
                          
                        <p  style="font-size: 14px;font-weight: bolder">Preliminary Review Info -</p>
                        <p  style="font-size: 14px;font-weight: bolder">
                           <span style="font-size: 14px;color: #006699;font-weight: bolder">Status: </span>
                              <?php if($result['journal_preliminary_review_status'] == 1)
                                                {
                                                    echo "<span style='color: red'>Pending</span>"; 
                                          
                                               }else{
                                                   if($result['journal_preliminary_review_status'] == 2){
                                                       echo "<span style='color: green'>Done</span>";
                                                   }else if($result['journal_preliminary_review_status'] == 3){
                                                        echo "<span style='color: green'>Accepted for Final Review</span>";
                                                   }else if($result['journal_preliminary_review_status'] == 4){
                                                        echo "<span style='color: green'>Modification</span>";
                                                   }else if($result['journal_preliminary_review_status'] == 5){
                                                        echo "<span style='color: green'>Rejected</span>";
                                                   }
                                               } 
                                                ?>  
                           <br/>  
                        </p>
                       
                         <p  style="font-size: 14px;font-weight: bolder">Final Review Info - <a href="final_review.php?journal_id=<?php echo $result['journal_id']; ?>">View</a></p>
                         
                       
                            <span style='font-size: 14px;font-weight: bolder;color: #006699;'> Reviewer-1:<?php echo $result['journal_id'] ?></span>
                              <?php
                            if ($result['reviewer_1_name'] == '') {
                                echo "Not Assigned";
                            } else {
                                echo $result['reviewer_1_name'];
                            }
                            
                            ?> 
                            <a href="review_details.php?journal_id=<?php echo $result['journal_id']; ?>&reviewer_id=<?php echo $result['reviewer_1_id']; ?>">Review Details</a> 
                            <br/>
                            <span style='font-size: 14px;font-weight: bolder;color: #006699;'> Reviewer-2:</span>
                              <?php
                            if ($result['reviewer_2_name'] == '') {
                                echo "Not Assigned";
                            } else {
                                echo $result['reviewer_2_name'];
                            }
                            
                            ?> 
                            <a href="review_details.php?journal_id=<?php echo $result['journal_id']; ?>&reviewer_id=<?php echo $result['reviewer_2_id']; ?>">Review Details</a>
                            <br/>
                            <span style='font-size: 14px;font-weight: bolder;color: #006699;'> Reviewer-3:</span>
                              <?php
                            if ($result['reviewer_3_name'] == '') {
                                echo "Not Assigned";
                            } else {
                                echo $result['reviewer_3_name'];
                            }
                            
                            ?>
                            <a href="review_details.php?journal_id=<?php echo $result['journal_id']; ?>&reviewer_id=<?php echo $result['reviewer_3_id']; ?>">Review Details</a>
                            <br/> <br/>
<!--                         <hr style='border-bottom: .5px dashed #8c8c8c;'/>  -->
                         <p  style="font-size: 14px;font-weight: bolder">Modification Info - <a href="add_modification.php?journal_id=<?php echo $result['journal_id']; ?>">View</a></p>
                         <p  style="font-size: 14px;font-weight: bolder">Verification Info - <a href="add_verification.php?journal_id=<?php echo $result['journal_id']; ?>">View</a></p>
                         <p  style="font-size: 14px;font-weight: bolder;">Article Status - 
                             <span style="color: #006699">
                         <?php if($result['journal_status'] == 1){
                                            echo 'Preliminary Review';
                                        }else if($result['journal_status'] == 2){
                                            echo 'Final Review';
                                        }else if($result['journal_status'] == 3){
                                            echo 'Modification';
                                        }else if($result['journal_status'] == 4){
                                            echo 'Verfication Done';
                                        }else if($result['journal_status'] == 5){
                                            echo 'In Press';
                                        }else if($result['journal_status'] == 6){
                                            echo 'Accepted';
                                        }else if($result['journal_status'] == 7){
                                            echo 'Rejected';
                                        }else if($result['journal_status'] == 8){
                                            echo 'Published';
                                        }else if($result['journal_status'] == 9){
                                            echo 'Publishable';
                                        }
                                        
                                        ?>
                                 </span>
                         </p>
                        
                      
                    </div>
<!--                    <div class="col-md-5" style="padding: 0px">
                       
                        <p style="font-size: 14px;margin-left: 2px">
                          
                            <a href='author_details.php?user_id=<?php echo $result['user_id']?>'>View</a>
                            
                           
                        </p>
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
                    </div>-->
<!--                     <a href="under_modification.php" style="margin-right: 20px" class="btn btn-danger pull-right"><i class="fa fa-arrow-circle-o-left"></i> Go Back</a>-->
                </div>
                
                
            </div>

        </div>

    </div>
</section>


<?php include "includes/footer.php" ?>




