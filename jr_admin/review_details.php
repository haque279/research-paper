<?php
ob_start();
session_start();

spl_autoload_register(function($class) {
    include "classes/" . $class . ".php";
});
?>
<?php
if (isset($_SESSION['admin'])) {
   $journal_id =  $_GET['journal_id'];
   $reviewer_id =  $_GET['reviewer_id'];
   $obj_admin = new Admin();
    $review_details = $obj_admin->review_details($journal_id,$reviewer_id);
    // var_dump($review_details);
    // exit;
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
            <div class="col-sm-10 ">
            <h4 style="font-weight: bolder; color: #006699">Review Details</h4>
            
                     <hr style="background-color: #8c8c8c;height: 1.5px;border-top: 3px double #8c8c8c;">
               <?php foreach($review_details as $res){ ?>
                 <p>
                   <strong>Reviewer Comments:</strong>
                   <br>
                   <?php echo $res['comment'];?>
                 </p>
                <!-- <a href="<?php echo $res['review_report'];?>">Review Report- <?php echo $res['comment'];?></a> -->
              <?php } ?>
            </div>
        </div>
    </div>
</section>


<?php include "includes/footer.php" ?>