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
    $result = $obj_admin->approved_user();

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
                    <br>
                    <a href="approved_user.php" class="btn btn-primary">View approved user</a>
                    <a href="disapproved_user.php" class="btn btn-primary">View disapproved user</a>
                    <a href="pending_user.php" class="btn btn-primary">View Pending user</a>
                    <?php
                    if (isset($_SESSION['message'])){ ?>
                        <br>
                        <div class="alert alert-info">
                            <strong><?php echo $_SESSION['message']; ?></strong>
                        </div>
                    <?php  }
                    ?>
                    <div class="table"
                    <div class="table-responsive" id="print">
                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Serial No</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Contact no</th>
                                <th>Article</th>
                                <th>Status</th>
                                <th>Action</th>
                                <!--                                <th>Action</th>-->
                            </tr>
                            </thead>
                            <?php $i = 1;
                            foreach($result as $res){
                                ?>
                                <tr>
                                    <th scope="row"> <?php echo $i ?> </th>
                                    <td><?php echo $res['user_name']; ?></td>
                                    <td><?php echo $res['user_address']; ?></td>
                                    <td><?php echo $res['user_email']; ?></td>
                                    <td><?php echo $res['user_contact_no']; ?> </td>



                                    <td>
                                        <?php
                                        $articles = $obj_admin->view_user_journal($res['user_id']);
                                        foreach ($articles as $article){?>
                                            <li><a href="<?php echo $article['journal_file']; ?>"> <?php echo $article['journal_title']."<br>" ?></a><?php echo "Date: ".$article['journal_date']; ?></li>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?php
                                        if($res['user_access_level']==0){ ?>
                                            <input type="button" class="btn btn-warning" value="Pending">
                                        <?php }
                                        ?>
                                        <?php
                                        if($res['user_access_level']==1){ ?>
                                            <input type="button" class="btn btn-success" value="Approved">
                                        <?php }
                                        ?>
                                        <?php
                                        if($res['user_access_level']==2){ ?>
                                            <input type="button" class="btn btn-danger" value="Disapproved">
                                        <?php }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="classes/user_approved.php?id=<?php echo $res['user_id']; ?>&email=<?php echo $res['user_email'] ?>" class="btn btn-success bottom_7" style="margin-bottom: 7px">Approved</a>
                                        <a href="classes/user_disapproved.php?id=<?php echo $res['user_id']; ?>&email=<?php echo $res['user_email'] ?>" class="btn btn-warning bottom_7" style="margin-bottom: 7px">Disapproved</a>
                                        <a href="classes/user_delete.php?id=<?php echo $res['user_id']; ?>&email=<?php echo $res['user_email'] ?>" class="btn btn-danger bottom_7" style="margin-bottom: 7px">Delete</a>
                                    </td>
                                </tr>
                                <?php $i++; } ?>

                            <tfoot>
                            <tr>
                                <th>Serial No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Contact no</th>
                                <th>Article</th>
                                <th>Status</th>
                                <th>Action</th>
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
<?php unset($_SESSION['message']); ?>

<?php include "includes/footer.php" ?>