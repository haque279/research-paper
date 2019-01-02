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
        $result = $obj_admin->view_approved_user();
        $reviewer = $obj_admin->view_reviewer();
    } else {
        header("location:index.php");
    }
if(isset($_POST['assign'])){
    $obj_admin = new Admin();
    $assign_message = $obj_admin->journal_assign($_POST);
    header('location: view_approved_user.php');

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
                                    <th>Serial No</th>
                                    <th>Author Name</th>
                                    <th>Email</th>
                                    <th>Contact no</th>
                                    <th>Journal</th>
                                    <th>Assign to</th>
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
                                        <td><a href="../<?php echo $res['journal_file'] ?>"> <?php echo $res['journal_title'] ?></a> </td>
                                        <td>
                                            <form action="" method="post">
                                                <select  name="reviewer_id"  id="">

                                                    <?php foreach($reviewer as $key=> $rev){ ?>
                                                        <option value="<?php echo $reviewer[$key]['reviewer_id']; ?>">

                                                            <?php echo $reviewer[$key]['reviewer_name']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <input type="hidden" name="user_id" value="<?php echo $res['user_id']; ?>">
                                                <input type="hidden" name="journal_id" value="<?php  echo $res['journal_id']; ?>">

                                                <input type="submit" class="btn btn-theme" name="assign" value="Assign">
                                                <?php if(isset($assign_message)){ ?>
                                                    <input type="button" class="btn-success" value="<?php echo $assign_message; ?> ">

                                             <?php   } ?>
                                            </form>

                                        </td>

                                    </tr>
                                    <?php $i++; } ?>
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