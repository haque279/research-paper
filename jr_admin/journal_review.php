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

  if(isset($_SESSION['reviewer_id'])){
      $obj_admin = new Admin();
      $result = $obj_admin->journal_for_review($_SESSION['reviewer_id']);
      $result2 = $obj_admin->journal_for_review_two($_SESSION['reviewer_id']);
      $result3 = $obj_admin->journal_for_review_three($_SESSION['reviewer_id']);
      $result4 = $obj_admin->journal_for_review_four($_SESSION['reviewer_id']);

  } else { header("location:../index.php"); }
if(isset($_POST['submit_review'])){
    echo  $obj_admin->reviewer_review($_POST, $_FILES);

    // $message = $obj_admin->update_review_status($_POST);
    // header('location:journal_review.php');
}

//var_dump($result); echo "<hr>";
//var_dump($result2); echo "<hr>";
//var_dump($result3); echo "<hr>";
//if($result3){
//    echo "yes";
//} else {echo "no";}
//?>


<?php include "includes/header.php" ?>
    <section class="main-content">
        <div class="container-fluid">
            <div class="row row-eq-height">
                <div class="col-sm-12 ">
                    <div class="table">
                        <div class="table-responsive">

                            <?php if($result){ ?>
                                <h2>Review one </h2>
                                <table class="table table-bordered table-striped">
                                    <h2><?php if(isset($message)){echo $message; } ?></h2>
                                    <tr>
                                        <th>Serial No</th>
                                        <th>Author Name</th>
                                        <th>Journal</th>
                                        <th>Action</th>
                                        <!-- <th>Report file</th> -->
                                        <th>Comments</th>
                                        <th></th>
                                    </tr>
                                    <?php $i = 1;
                                    foreach($result as $key => $res){
                                        ?>
                                        <tr>
                                            <th scope="row"> <?php echo $i; echo $res['journal_id']; ?> </th>
                                            <td><?php echo $res['user_name']; ?></td>
                                            <td><a href="<?php echo $res['journal_file'] ?>"> <?php echo $res['journal_title'] ?></a> </td>
                                            <form action="" method="post" enctype="multipart/form-data">
                                            
                                            <td>
                                                <input type="hidden" name="user_name" value="<?php echo $res['user_name']; ?>">
                                                <input type="hidden" name="user_id" value="<?php echo $res['user_id']; ?>">
                                                <input type="hidden" name="user_email" value="<?php echo $res['user_email']; ?>">

                                                <input type="hidden" name="journal_title" value="<?php echo $res['journal_title']; ?>">
                                                <input type="hidden" name="reviewer_id" value="<?php echo $res['reviewer_id']; ?>">
                                                
                                                <input type="hidden" name="journal_id" value="<?php echo $res['journal_id']; ?>">
                                                <input type="hidden" name="review_type" value="1">
                                                

                                                    <input type="radio" required name="review"  value="Accepted">  Accepted  &nbsp;
                                                    <input type="radio" required name="review" value="Rejected"> Rejected &nbsp;
                                                    <input type="radio" required name="review" value="Modification"> Modification &nbsp;
                                                    
                                            </td>
                                            <!--
                                            <td>
                                            <input type="file" name="journal_file" >
                                            </td>
                                            -->
                                                <td>
                                                    <textarea name="comments" class="form-control" id="" cols="20" rows="5"></textarea>
                                                </td>
                                                
                                                <td> <input type="submit" class="btn btn-theme" value="Submit Review" name="submit_review"></td>
                                            </form>


                                        </tr>
                                        <?php $i++; } ?>


                                </table>


                            <?php  } else {echo "First Review Not Available"; } ?>

                            <?php if($result2){ ?>
                                <h2>Review two </h2>
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
                                    foreach($result2 as $key => $res){
                                        ?>
                                        <tr>
                                            <th scope="row"> <?php echo $i; echo $res['journal_id']; ?> </th>
                                            <td><?php echo $res['user_name']; ?></td>
                                            <td><a href="<?php echo $res['journal_file'] ?>"> <?php echo $res['journal_title'] ?></a> </td>
                                            <form action="" method="post">
                                            
                                            <td>
                                                <input type="hidden" name="user_name" value="<?php echo $res['user_name']; ?>">
                                                <input type="hidden" name="user_id" value="<?php echo $res['user_id']; ?>">
                                                <input type="hidden" name="user_email" value="<?php echo $res['user_email']; ?>">

                                                <input type="hidden" name="journal_title" value="<?php echo $res['journal_title']; ?>">
                                                <input type="hidden" name="reviewer_id" value="<?php echo $res['reviewer_id']; ?>">
                                                
                                                <input type="hidden" name="journal_id" value="<?php echo $res['journal_id']; ?>">
                                                <input type="hidden" name="review_type" value="2">
                                                

                                                    <input type="radio" required name="review"  value="Accepted">  Accepted  &nbsp;
                                                    <input type="radio" required name="review" value="Rejected"> Rejected &nbsp;
                                                    <input type="radio" required name="review" value="Modification"> Modification &nbsp;
                                                    
                                            </td>
                                                <td>
                                                    <textarea name="comments" class="form-control" id="" cols="20" rows="5"></textarea>
                                                </td>
                                                <td> <input type="submit" class="btn btn-theme" value="Submit Review" name="submit_review"></td>
                                            </form>


                                        </tr>
                                        <?php $i++; } ?>


                                </table>

                            <?php  } else " Second Review Not Available"; ?>

                            <?php
                            if($result3){ ?>
                                <h2>Review three </h2>
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
                                    foreach($result3 as $key => $res){
                                        ?>
                                        <tr>
                                            <th scope="row"> <?php echo $i; echo $res['journal_id']; ?> </th>
                                            <td><?php echo $res['user_name']; ?></td>
                                            <td><a href="<?php echo $res['journal_file'] ?>"> <?php echo $res['journal_title'] ?></a> </td>
                                            <form action="" method="post">
                                            
                                            <td>
                                                <input type="hidden" name="user_name" value="<?php echo $res['user_name']; ?>">
                                                <input type="hidden" name="user_id" value="<?php echo $res['user_id']; ?>">
                                                <input type="hidden" name="user_email" value="<?php echo $res['user_email']; ?>">

                                                <input type="hidden" name="journal_title" value="<?php echo $res['journal_title']; ?>">
                                                <input type="hidden" name="reviewer_id" value="<?php echo $res['reviewer_id']; ?>">
                                                
                                                <input type="hidden" name="journal_id" value="<?php echo $res['journal_id']; ?>">
                                                <input type="hidden" name="review_type" value="3">
                                                

                                                    <input type="radio" required name="review"  value="Accepted">  Accepted  &nbsp;
                                                    <input type="radio" required name="review" value="Rejected"> Rejected &nbsp;
                                                    <input type="radio" required name="review" value="Modification"> Modification &nbsp;
                                                    
                                            </td>
                                                <td>
                                                    <textarea name="comments" class="form-control" id="" cols="20" rows="5"></textarea>
                                                </td>
                                                <td> <input type="submit" class="btn btn-theme" value="Submit Review" name="submit_review"></td>
                                            </form>


                                        </tr>
                                        <?php $i++; } ?>


                                </table>

                                <?php  } else " Third Review Not Available"; ?>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include "includes/footer.php" ?>