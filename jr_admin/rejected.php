<?php

ob_start();
session_start();

spl_autoload_register(function($class){
    include "classes/".$class.".php";
});
?>
<?php


    if(isset($_SESSION['admin'])){
        $obj_admin = new Admin();
        $result = $obj_admin->rejected();
        $reviewer = $obj_admin->view_reviewer();
    } else {
        header("location:index.php");
    }
if(isset($_POST['assign'])){
    $obj_admin = new Admin();
    $assign_message = $obj_admin->journal_assign_three($_POST);
    header('location: secondary_review_two.php');

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
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Serial No</th>
                                    <th>Author Name</th>
                                    <th>Email</th>
                                    <th>Contact no</th>
                                    <th>Journal</th>
                                </tr>
                                </thead>
                                <?php $i = 1;
                                foreach($result as $res){
                                    ?>
                                    <tr>
                                        <th scope="row"> <?php echo $i ?> </th>
                                        <td><?php echo $res['user_name']; ?></td>
                                        <td><?php echo $res['user_email']; ?></td>
                                        <td><?php echo $res['user_contact_no']; ?></td>
                                        <td><a href="history_table.php?journal_id=<?php echo $res['journal_id']; ?>&user_id=<?php echo $res['user_id']; ?>"> <?php echo $res['journal_title'] ?></a> </td>


                                    </tr>
                                    <?php $i++; } ?>

                                <tfoot>
                                <tr>
                                    <th>Serial No</th>
                                    <th>Author Name</th>
                                    <th>Email</th>
                                    <th>Contact no</th>
                                    <th>Journal</th>
                                </tr>
                                </tfoot>


                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include "includes/footer.php" ?>