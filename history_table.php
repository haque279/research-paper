<?php
session_start();
spl_autoload_register(function($class){
    include "jr_admin/classes/".$class.".php";
});
$journal_user_id = $_SESSION['user_id'];
$journal_id = $_GET['journal_id'];
?>
<?php

if(isset($_SESSION['user_name'])){
     $user_id = $_SESSION['user_id'];

    $user_name = $_SESSION['user_name'];


} else {}
$obj_history = new History();
$result = $obj_history->view_history($user_id, $journal_id);
$result2 = $obj_history->view_additional_author($journal_user_id, $journal_id);
$journal_date = $obj_history->journal_view_by_id($journal_id);

?>
<?php include "includes/header.php" ?>
<style>
    .wrapper {
        border: 1px solid #666;
    }
    ul, ol {
        margin-left:15px;}

    .block {
        border: 1px solid #666;
        padding: 7px;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">


<div class="wrapper">
    <div class="block">
            1. <b>Title: </b> <?php foreach($result as $res){  } if(isset($res['journal_title'])){echo $res['journal_title'];}
            else echo "Your Journal under review...";
            ?>
    </div>
    <div class="block">
        <p><b>2. Author(s) Details: </b></p>

            <ol>
                <?php  foreach ($result2 as $res){ ?>
                <li>
                    <b><?php echo $res['additional_author_name']?></b>
                    <br>
                    <?php echo $res['additional_author_position']?>
                    <br>
                    <?php echo $res['additional_author_institute']?>,  <?php echo $res['additional_author_address']?>
                    <br>
                    <?php if($res['additional_author_email']){echo "<b>Email: </b>".$res['additional_author_email'];} ?> 	&nbsp;
                    <?php if($res['additional_author_contact_no']){echo "<b>Mobile: </b>".$res['additional_author_contact_no'];} ?> 	&nbsp;
                    <?php if($res['additional_author_tel']){echo "<b>Tel: </b>".$res['additional_author_tel'];} ?> 	&nbsp;
                    <?php if($res['additional_author_fax']){echo "<b>Fax: </b>".$res['additional_author_fax'];} ?> 	&nbsp;
                    <?php if($res['additional_author_skype']){echo "<b>Skype: </b>".$res['additional_author_skype'];} ?> 	&nbsp;
                    <?php if($res['additional_author_web']){echo "<b>Web Page: </b>".$res['additional_author_web'];} ?>


                </li>
                <?php } ?>
            </ol>

    </div>

    <div class="block">
        <b>Article Status: </b>

        <?php foreach($result as $res){ ?>
            <?php if ($res['journal_status']==1){ ?>
                Preliminary Review
                <?php
                    if ($res['journal_preliminary_review_status']==1){
                        echo " Pending";
                    }elseif($res['journal_preliminary_review_status']==2){
                        echo " Done";
                    }elseif($res['journal_preliminary_review_status']==3){
                        echo " Accepted For Final Review";
                    }elseif($res['journal_preliminary_review_status']==4){
                        echo " Modification";
                    }elseif($res['journal_preliminary_review_status']==5){
                        echo " Rejected";
                    }
                ?>
                <?php } if ($res['journal_status']==2){ ?>
                Final Review
                <?php } if ($res['journal_status']==3){ ?>
                Modification
                <?php } if ($res['journal_status']==4){ ?>
                Verification
                <?php } if ($res['journal_status']==5){ ?>
                In Press
                <?php } if ($res['journal_status']==6){ ?>
                Accepted
                <?php } if ($res['journal_status']==7){ ?>
                Rejected
                <?php } if ($res['journal_status']==8){ ?>
                Published
                <?php } if ($res['journal_status']==9){ ?>
                Publishable
        <?php } }?>


    </div>



</div>
            <div class="" style="margin-top: 15px;"><a href="author.php" class="btn btn-primary">Back to main page</a></div>
        </div>
    </div>
</div>

</body>

</html>