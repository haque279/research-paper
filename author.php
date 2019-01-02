<?php

spl_autoload_register(function($class){
    include "jr_admin/classes/".$class.".php";
});
?>
<?php
session_start();
if(isset($_SESSION['user_name'])){
    $journal_user_id = $_SESSION['user_id'];

}
else {
    header("location: index.php");
}


   if(isset($_POST['file_submit'])){
       $obj_journal = new Journal();
       $message = $obj_journal->journal_upload($_POST, $_FILES);

   }

    if(isset($_POST['addition_submit'])){
        $obj_journal = new Journal();
        $obj_journal->add_additional_author($_POST);
        unset($_POST);
    }
    $obj_journal = new Journal();
    $result = $obj_journal->view_additional_author($journal_user_id);
    $resultt = $obj_journal->journal_view($journal_user_id);
    $modified = $obj_journal->journal_modified_view($journal_user_id);
    $modified_two = $obj_journal->journal_modified_view_two($journal_user_id);
    $journal_author = $obj_journal->journal_view_with_author($journal_user_id);


?>
<?php include "includes/header.php" ?>

    <section class="journal">
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <div class="sidebar">

<!--                        <div class="journal_head">-->
<!--                            <h2>Published - -->
<!--                                --><?php
//                                    if(isset($resultt)){
//                                        $i = 0;
//                                    foreach($resultt as $res) {
//                                     $res['journal_title'] ;
//                                        $i++;
//                                     }  echo $i; } ?>
<!--                            -->
<!--                            </h2>-->
<!--                        </div>-->
                        <div class="search">
                            <h5>Article</h5>
                            <div class="search_inner2">
                                <ul>
                                    <?php
                                        if(isset($modified)){
                                            foreach($modified as $res){ ?>
                                                <li><a href="journal_edit.php?id=<?php echo $res['journal_id'] ?>&title=<?php echo $res['journal_title'] ?>"> <?php echo $res['journal_title'] ?><span class="pull-right cross"> Click for modified</span></a></li>
                                                <?php
                                            }
                                        }  ?>
                                    <?php
                                        if(isset($modified_two)){
                                            foreach($modified_two as $res){ ?>
                                                <li><a href="journal_edit_two.php?id=<?php echo $res['journal_id'] ?>&title=<?php echo $res['journal_title'] ?>"> <?php echo $res['journal_title'] ?><span class="pull-right cross"> Click for modified</span></a></li>
                                                <?php
                                            }
                                        }  ?>

                                            <?php
                                            if(isset($resultt)){
                                                foreach($resultt as $res) { ?>
                                    <span class="journal_link">
                                                    <li><a href="jr_admin/<?php echo $res['journal_file']; ?>"> <?php echo $res['journal_title'] ?></a></li>
                                                    <li><a href="add_profile.php?journal_id=<?php echo $res['journal_id'] ?>">Update Author</a></li>
<!--                                                    <li><a href="history_table.php?journal_id=--><?php //echo $res['journal_id'] ?><!--">Status</a></li>-->
                                                    <li>
                                                        <a style='font-weight: bolder'>
                                                            Status:
                                        <?php if($res['journal_status'] == 1){
                                            echo 'Preliminary Review'."<br>";

                                            if($res['journal_preliminary_review_status'] == 2){
                                                echo "<span style='color: green'>Done</span>";
                                            }else if($res['journal_preliminary_review_status'] == 3){
                                                echo "<span style='color: green'>Accepted for Final Review</span>";
                                            }else if($res['journal_preliminary_review_status'] == 4){
                                                echo "<span style='color: green'>Modification</span>";
                                            }else if($res['journal_preliminary_review_status'] == 5){
                                                echo "<span style='color: green'>Rejected</span>";
                                            }



                                        }else if($res['journal_status'] == 2){
                                            echo 'Final Review'."<br>";

                                            if ($res['journal_final_review_status'] == 1) {
                                                echo "<span style='color: red; font-weight: bolder'>Reviewer_1 Pending</span>";
                                            }else if($res['journal_final_review_status'] == 2){
                                                echo "<span style='color: red; font-weight: bolder'>Reviewer_2 Pending</span>";
                                            }else if($res['journal_final_review_status'] == 3){
                                                echo "<span style='color: red; font-weight: bolder'>Both Reviewers Pending</span>";
                                            }else if($res['journal_final_review_status'] == 4){
                                                echo "<span style='color: green; font-weight: bolder'>Both Reviewers Done</span>";
                                            }else if($res['journal_final_review_status'] == 5){
                                                echo "<span style='color: red; font-weight: bolder'>Reviewer_3 Pending</span>";
                                            }else if($res['journal_final_review_status'] == 6){
                                                echo "<span style='color: green; font-weight: bolder'>Reviewer_3 Done</span>";
                                            }




                                        }else if($res['journal_status'] == 3){
                                            echo 'Modification';
                                        }else if($res['journal_status'] == 4){
                                            echo 'Verification';
                                            echo "</br>";
                                            echo "<span style='color: red; font-weight: bolder'>";
                                            if ($res['modification_status'] == 2){ echo "Done";}
                                            if ($res['modification_status'] == 3){ echo "Pending";}
                                            echo "<span>";

                                        }else if($res['journal_status'] == 5){
                                            echo 'In Press';
                                        }else if($res['journal_status'] == 6){
                                            echo 'Accepted';
                                        }else if($res['journal_status'] == 7){
                                            echo 'Rejected';
                                        }else if($res['journal_status'] == 8){
                                            echo 'Published';
                                        }else if($res['journal_status'] == 9){
                                            echo 'Publishable';
                                        }else if($res['journal_status'] == 10){
                                            echo 'EC Meeting';
                                        }

                                        ?>
                                               </a>
                                                    </li>
                                        </span>
                                        <?php  } } ?>



                                </ul>
                            </div>

                        </div>



                    </div>
                </div>
                <div class="col-sm-7">
                   <div class="search">
                      <h4>Welcome <?php echo $_SESSION['user_name']; ?>
                          <br>
                          <span style="color: rebeccapurple; font-size: 15px"><?php if($_SESSION['user_access_level']==0){echo " Please upload your Article";} ?></span>
                      </h4>
                       <div class="search_inner">
                           <p class="copyright">Upload Article</p>
                           <p class="text-danger" style=" font-size: 16px; font-weight: 700"><?php if(isset($_SESSION['message'])){ echo $_SESSION['message']; } ?></p>

                            <form action="" method="post" enctype="multipart/form-data" >
                                <input type="text" required name="journal_title" placeholder="Title" class="form-control" >
                                <input type="file" required name="journal_file" class="btn btn-default btn-file">
                                <p>upload only: doc, docx file</p>
                                <input type="hidden" name="journal_user_id" value="<?php echo  $journal_user_id ?>" >
<!--                                <input type="text" name="journal_user_id" value="--><?php //echo  $resultt['journal_id'] ?><!--" >-->
                                <input type="submit" name="file_submit" class="btn btn-theme " value="Upload your Article">

                            </form>
                       </div>
                   </div>

                </div>
            </div>
        </div>
    </section>


    <?php include "includes/footer.php" ?>