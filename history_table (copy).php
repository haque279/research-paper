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
            <b>Received Date: </b><?php echo date("d-m-Y", strtotime($journal_date[0]['journal_date'])) ; ?>
    </div>
    <div class="block">
        <p><b>Preliminary Review Status: </b></p>

        <?php foreach($result as $res){ if($res['journal_history_status']==11){  ?>
        <p>
            <b>Reviewer: </b><?php echo $res['reviewer_name'].", ".$res['reviewer_position'].", ".$res['reviewer_institute']; ?>
        </p>
            <table width="100%">
                <tr>
                    <td width="30%"><p><b>Send Date:  </b><?php echo date("d-m-Y", strtotime($res['i_date'])) ; ?></p></td>
                    <?php foreach($result as $res){ if($res['journal_history_status']==1){  ?>
                    <td width="30%">
                            <p><b>Receive Date:  </b><?php echo date("d-m-Y", strtotime($res['i_date'])) ; ?></p>
                    </td>
                    <td width="30%">
                            <p><b>Due Date:  </b><?php echo date("d-m-Y", strtotime($res['due_date'])) ; ?></p>
                    </td>
                    <?php } } ?>
                </tr>
            </table>


            <p><b>Comments: </b><?php echo $res['comments']; ?></p>
        <p><b>Decision: </b>Accepted</p>

        <?php } }?>

        <?php foreach($result as $res){ if($res['journal_history_status']==12){  ?>
        <p><b>Resons behind Rejection:</b> <?php echo $res['comments']; ?> </p>
        <p><b>Sent o the author, if modification is needed: </b> </p>
        <p><b>Sent date:</b> <?php echo date("d-m-Y", strtotime($res['i_date'])) ; ?> </p>
        <p><b>Verification by: </b><?php echo $res['reviewer_name'].", ".$res['reviewer_position'].", ".$res['reviewer_institute']; ?></p>
        <p><b>Received Date: </b></p>
        <p><b>Decision: </b></p>
        <?php } }?>
    </div>


    <div class="block">
        <b>5. Review Status</b>
    </div>
    <div class="block">
        <ul>

                <?php foreach($result as $res){ if($res['journal_history_status']==22){ ?>
             <li>
                <p>
                    <b>Reviewer: (1) </b><?php echo $res['reviewer_name'].", ".$res['reviewer_position'].", ".$res['reviewer_institute']; ?>

                </p>
                 <table width="100%">
                     <tr>
                         <td width="30%"><p><b>Send Date:  </b><?php echo date("d-m-Y", strtotime($res['i_date'])) ; ?></p></td>
                         <?php foreach($result as $res){ if($res['journal_history_status']==2){  ?>
                             <td width="30%">
                                 <p><b>Receive Date:  </b><?php echo date("d-m-Y", strtotime($res['i_date'])) ; ?></p>
                             </td>
                             <td width="30%">
                                 <p><b>Due Date:  </b><?php echo date("d-m-Y", strtotime($res['due_date'])) ; ?></p>
                             </td>
                         <?php } } ?>
                     </tr>
                 </table>
                <p><b>Cotact No: </b><?php echo $res['reviewer_contact_no'] ; ?></p>
                 <p><b>Comments: </b><?php echo $res['comments']; ?></p>
                <p><b>Decision: </b>Accepted</p>
            </li>
            <?php } }?>

                <?php foreach($result as $res){ if($res['journal_history_status']==99){ ?>
             <li>
                <p>
                    <b>Reviewer: </b><?php echo $res['reviewer_name'].", ".$res['reviewer_position'].", ".$res['reviewer_institute']; ?>

                </p>
                <p><b>Cotact No: </b><?php echo $res['reviewer_contact_no'] ; ?></p>
                <p><b>Received Date: </b><?php echo date("d-m-Y", strtotime($res['i_date'])) ; ?></p>
                 <p><b>Comments: </b><?php echo $res['comments']; ?></p>
                <p><b>Decision: </b>Rejected</p>
            </li>
            <?php } }?>
        </ul>
        <ul>

                <?php foreach($result as $res){ if($res['journal_history_status']==33){ ?>
             <li>
                <p>
                    <b>Reviewer: (2) </b><?php echo $res['reviewer_name'].", ".$res['reviewer_position'].", ".$res['reviewer_institute']; ?>

                </p>
                 <table width="100%">
                     <tr>
                         <td width="30%"><p><b>Send Date:  </b><?php echo date("d-m-Y", strtotime($res['i_date'])) ; ?></p></td>
                         <?php foreach($result as $res){ if($res['journal_history_status']==3){  ?>
                             <td width="30%">
                                 <p><b>Receive Date:  </b><?php echo date("d-m-Y", strtotime($res['i_date'])) ; ?></p>
                             </td>
                             <td width="30%">
                                 <p><b>Due Date:  </b><?php echo date("d-m-Y", strtotime($res['due_date'])) ; ?></p>
                             </td>
                         <?php } } ?>
                     </tr>
                 </table>
                <p><b>Cotact No: </b><?php echo $res['reviewer_contact_no'] ; ?></p>
                 <p><b>Comments: </b><?php echo $res['comments']; ?></p>
                <p><b>Decision: </b>Accepted</p>
            </li>
            <?php } }?>

                <?php foreach($result as $res){ if($res['journal_history_status']==99){ ?> <?php echo $res['comments']; ?>
             <li>
                <p>
                    <b>Reviewer: </b><?php echo $res['reviewer_name'].", ".$res['reviewer_position'].", ".$res['reviewer_institute']; ?>

                </p>
                <p><b>Cotact No: </b><?php echo $res['reviewer_contact_no'] ; ?></p>
                <p><b>Received Date: </b><?php echo date("d-m-Y", strtotime($res['i_date'])) ; ?></p>
                 <p><b>Comments: </b><?php echo $res['comments']; ?></p>
                <p><b>Decision: </b>Rejected</p>
            </li>
            <?php } }?>
        </ul>

    </div>
    <div class="block">
        <?php foreach($result as $res){ if($res['journal_history_status']==44){  ?>
        <b>7. Final Decision: </b>Accepted
        <?php } }?>
    </div>

</div>
            <div class="" style="margin-top: 15px;"><a href="author.php" class="btn btn-primary">Back to main page</a></div>
        </div>
    </div>
</div>

</body>

</html>