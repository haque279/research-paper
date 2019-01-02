<?php
ob_start();
session_start();

spl_autoload_register(function($class){
    include "classes/".$class.".php";
});
?>
<?php


//    if(isset($_SESSION['admin'])){
//        $obj_admin = new Admin();
//        $result = $obj_admin->view_approved_user();
//        $reviewer = $obj_admin->view_reviewer();
//    } else {
//        header("location:index.php");
//    }

  if(isset($_SESSION['admin'])){
      $obj_admin = new Admin();
      $result = $obj_admin->ec_meeting();

  } else { header("location:../index.php"); }
if(isset($_POST['submit_review'])){
    if($_POST['review']==45){
        $obj_admin->send_email_mod($_POST);
    }
    if($_POST['review']==46){
        $obj_admin->send_email_mod($_POST);
    }
    if($_POST['review']==44){
        $obj_admin->send_email_confirm($_POST);
    }
    if($_POST['review']==99){
        $obj_admin->send_email_rejected($_POST);
    }

    $obj_admin = new Admin();
    $message = $obj_admin->update_review_status($_POST);
    header('location:ec_meeting.php');
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

                            <?php if($result){ ?>
                                <h2>Executive Committee Meeting Review </h2>
                                <table class="table table-bordered table-striped">
                                    <h2><?php if(isset($message)){echo $message; } ?></h2>
                                    <tr>
                                        <th>Serial No</th>
                                        <th>Author Name</th>
                                        <th>Journal</th>
                                        <th>Action</th>
                                        <th>Comments</th>
                                        <th></th>
                                    </tr>
                                    <?php $i = 1;
                                    foreach($result as $key => $res){
                                        ?>
                                        <tr>
                                            <th scope="row"> <?php echo $i; echo $res['journal_id']; ?> </th>
                                            <td><?php echo $res['user_name']; ?></td>
                                            <td><a href="../<?php echo $res['journal_file'] ?>"> <?php echo $res['journal_title'] ?></a> </td>
                                            <form action="" method="post">
                                            <td>

                                                    <input type="radio" required name="review"  value="44">  Accepted  &nbsp;
                                                    <input type="radio" required name="review" value="99"> Rejected &nbsp;
                                                    <input type="radio" required name="review" value="45"> Modification &nbsp;
                                                    <input type="radio" required name="review" value="46"> Major Modification &nbsp;
                                                    <input type="hidden" name="id" value="<?php echo $res['journal_id']; ?>">
                                                    <input type="hidden" name="user_id" value="<?php echo $res['user_id']; ?>">
                                                    <input type="hidden" name="journal_status" value="<?php echo $res['journal_status']; ?>">
                                                    <input type="hidden" name="reviewer_id" value="<?php echo $res['reviewer_id']; ?>">
                                                <input type="hidden" name="user_email" value="<?php echo $res['user_email']; ?>">


                                            </td>
                                                <td>
                                                    <textarea name="comments" class="form-control" id="" cols="20" rows="5"></textarea>
                                                </td>
                                                <td> <input type="submit" class="btn btn-theme" value="Submit Review" name="submit_review"></td>
                                            </form>


                                        </tr>
                                        <?php $i++; } ?>


                                </table>


                            <?php  } else {echo "no review available"; } ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include "includes/footer.php" ?>