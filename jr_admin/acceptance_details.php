
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
        $acc_info = $obj_admin->accepted_journal_info_by_id($_GET['journal_id']);
        //echo "<pre>";
        //print_r($result);exit();
    }

    $reviewer = $obj_admin->view_reviewer();
} else {
    header("location:index.php");
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
                    <h4 style="font-weight: bolder; color: #006699">Acceptance Details</h4>
                    <hr style="background-color: #8c8c8c;height: 1.5px;border-top: 3px double #8c8c8c;">
                    <div class="col-md-6" style="padding: 0px">
                        
                        <p  style="font-size: 14px;font-weight: bolder">Article title -</p>
                        <p style="font-size: 14px;"><a href="<?php echo $result['journal_file']; ?>" download><?php echo $result['journal_title']; ?></a></p>

                        


                        <p  style="font-size: 14px;font-weight: bolder">Accepted Date - <?php echo date('d/m/Y',$acc_info['accepted_date']);?></p>
                        <p  style="font-size: 14px;font-weight: bolder">Acceptance Stage - 
                           <span style='font-size: 14px;font-weight: bolder;color: #006699;'>
                            <?php
                                    if ($acc_info['acceptance_stage'] == 1) {
                                        echo 'After Preliminary Review ';
                                    } else if ($acc_info['acceptance_stage'] == 2) {
                                        echo 'After Final Review';
                                    } else if ($acc_info['acceptance_stage'] == 3) {
                                        echo 'After Verification';
                                    }
                                    ?> 
                               </span>
                        </p>
                        

                        <p  style="font-size: 14px;font-weight: bolder">Acceptance Letter - <a href="review_files/<?php echo $acc_info['acceptance_letter']; ?>" download><?php echo $acc_info['acceptance_letter']; ?></a></p>
                        

                         <br/>
                        

                       


                    </div>
                    <!--                    <div class="col-md-5" style="padding: 0px">
                                           
                                            <p style="font-size: 14px;margin-left: 2px">
                                              
                                                <a href='author_details.php?user_id=<?php echo $result['user_id'] ?>'>View</a>
                                                
                                               
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






