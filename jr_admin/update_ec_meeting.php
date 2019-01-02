
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
        if(isset($_GET['id'])){
        $result = $obj_admin->get_ec_meeting_info_by_id($_GET['id']);
        }
        
        //$result = $obj_admin->get_accepted_article_info($_GET['journal_id']);
    $reviewer = $obj_admin->view_reviewer();
} else {
    header("location:index.php");
}

if(isset($_POST['update_ec_meeting'])){
    $obj_admin = new Admin();
    $obj_admin->update_ec_meeting($_POST);
    $_SESSION['message'] = 'Information Successfully Updated';
    session_regenerate_id(true);
    header('location: ec_meeting.php');
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
                <div class="col-sm-5" style="margin-top: 20px">
                    <h4 style="color: green">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                        ?>
                    </h4>
                    <h4 style="font-weight: bolder; color: #006699;text-align: center"><?php if(!$result){echo "Add New Meeting";}else{echo "Update Meeting Info";}?></h4>
                    
                    <hr style="background-color: #8c8c8c;height: 1.5px;border-top: 3px double #8c8c8c;">
                    
                        <form action="" method="POST" enctype="multipart/form-data" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Year:</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Year" name="year" class='form-control' value="<?php if($result['year'] != ""){ echo $result['year'];} ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">No.:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="no" class="form-control" value="<?php echo $result['no'];?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Date:</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Date" name="date" class='form-control datepicker' value="<?php if($result['date'] != ""){ echo date('d-m-Y', strtotime($result['date'])); } ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Minors:</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="minors">
                                        <a href="review_files/<?php echo $result['minors']; ?>" download><?php echo $result['minors']; ?></a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Details:</label>
                                    <div class="col-sm-9">
                                        <textarea name="details" class="form-control" rows="8"><?php echo $result['details'];?></textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                                <input type="submit" class="btn btn-primary btn-sm pull-right" name="update_ec_meeting" value="Update">
                              
                            </div>
                        </form> 
                   
                </div>
                
                

    </div>
</section>


<?php include "includes/footer.php" ?>







