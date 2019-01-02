
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
         $data['journal_id'] = $_GET['journal_id'];
        $data['journal_status'] = '5';
        $result = $obj_admin->check_article_existance($data);


        //$result = $obj_admin->get_accepted_article_info($_GET['journal_id']);
    }

    $reviewer = $obj_admin->view_reviewer();
} else {
    header("location:index.php");
}
if (isset($_POST['save_acceptance_details'])) {
    $obj_admin = new Admin();
    $obj_admin->save_acceptance_details($_POST);
    $_SESSION['message'] = 'Information Successfully Saved';
    //session_regenerate_id(true);
    header('location: inpress_article_details.php?journal_id=' . $_POST['journal_id']);
    session_write_close();
    //header('location: secondary_review_two.php');
}
if (isset($_POST['update_inpress_details'])) {
    $obj_admin = new Admin();
    $obj_admin->update_inpress_details($_POST);
    $_SESSION['message'] = 'Information Successfully Updated';
    //session_regenerate_id(true);
    header('location: inpress_article_details.php?journal_id=' . $_POST['journal_id']);
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
                <div class="col-sm-6" style="margin-top: 20px">
                    <h4 style="color: green">
<?php
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
                    </h4>
                    <h4 style="font-weight: bolder; color: #006699;text-align: center"><?php if (!$result) {
                            echo "Add Info";
                        } else {
                            echo "Update Info";
                        } ?></h4>
                    <hr style="background-color: #8c8c8c;height: 1.5px;border-top: 3px double #8c8c8c;">

                    <form action="" method="POST" enctype="multipart/form-data" class="form-horizontal">
                        <div class="col-md-9">
                            <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Issue Name:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="issue_name" class="form-control" value="<?php echo $result['issue_name'];?>">
                                    </div>
                                </div>


                            <input type="hidden" name="journal_id" value="<?php echo $result['journal_id']; ?>">
                            <?php
                            if (!$result) {
                                ?>
                                <input type="submit" class="btn btn-primary btn-sm pull-right" name="save_inpress_details" value="save">
<?php } else { ?>
                                <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
                                <input type="submit" class="btn btn-primary btn-sm pull-right" name="update_inpress_details" value="Update">
                <?php } ?>
                        </div>
                    </form> 

                </div>
<?php
if ($result) {
    ?>
                    <div class="col-md-5" style="margin-top: 20px">
                        <div style="margin-left: 30px">
                            <h4 style="font-weight: bolder; color: #006699;text-align: center">View</h4>
                            <hr style="background-color: #8c8c8c;height: 1.5px;border-top: 3px double #8c8c8c;">

                            
                            
                            <p  style="font-size: 14px;font-weight: bolder;margin-left: 15px">Issue Name: &nbsp<span style="color: #006699">
                                  <?php echo $result['issue_name'];?>
                               
                            </p>

                        </div>
                        <div>

                        </div>

                    </div>
            <?php } ?>

            </div>
            </section>


<?php include "includes/footer.php" ?>






