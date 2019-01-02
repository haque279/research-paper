<?php
session_start();
spl_autoload_register(function($class){
    include "classes/".$class.".php";
});
$journal_user_id = $_GET['user_id'];
$user_id = $_GET['user_id'];
$journal_id = $_GET['journal_id'];
?>
<?php

if(isset($_SESSION['user_name'])){
     $user_id = $_SESSION['user_id'];

    $user_name = $_SESSION['user_name'];


}
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


<div class="wrapper" id="print">
    <div class="" style="position: relative">
        <p style="text-align: center; font-size: 22px; font-weight: 700; margin-bottom: 0">Bank Parikrama</p>
        <p style="text-align: center; font-size: 18px;font-weight: 700;">Fact Sheet</p>
        <div class="no" style="position: absolute; right: 0; top: 3px; border: 1px solid #666;  padding: 7px; font-size: 16px"># 22222<?php echo $journal_id;  ?></div>
    </div>
    <div class="block" style="border: 1px solid #666;  padding: 7px;">

             <b>1. Title: </b> <?php foreach($result as $res){  } if(isset($res['journal_title'])){echo $res['journal_title'];}
            else echo "Your Journal under review...";
            ?>
    </div>
    <div class="block" style="border: 1px solid #666;  padding: 7px;">
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
    <div class="block" style="border: 1px solid #666;  padding: 7px;">

            <b>Received Date: </b><?php echo date("d-m-Y", strtotime($journal_date[0]['journal_date'])) ; ?>

    </div>
    <div class="block" style="border: 1px solid #666;  padding: 7px;">
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
            <hr>
        <p><b>Resons behind Rejection:</b> <?php echo $res['comments']; ?> </p>
        <p><b>Sent o the author, if modification is needed: </b> </p>
        <p><b>Sent date:</b> <?php echo date("d-m-Y", strtotime($res['i_date'])) ; ?> </p>
        <p><b>Verification by: </b><?php echo $res['reviewer_name'].", ".$res['reviewer_position'].", ".$res['reviewer_institute']; ?></p>
        <p><b>Received Date: </b></p>
        <p><b>Decision: </b><?php echo"Need to modification " ?> </p>
        <?php } }?>
    </div>


    <div class="block" style="border: 1px solid #666;  padding: 7px;">
        <b>5. Review Status</b>
    </div>
    <div class="block" style="border: 1px solid #666;  padding: 7px;">
        <ul>

                <?php foreach($result as $res){ if($res['journal_history_status']==22){ ?>
             <li>
                <p>
                    <b>Reviewer: (1) </b><?php echo $res['reviewer_name'].", ".$res['reviewer_position'].", ".$res['reviewer_institute']; ?>

                </p>
                <p><b>Cotact No: </b><?php echo $res['reviewer_contact_no'] ; ?></p>
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
                 <p><b>Cotact No: </b><?php echo $res['reviewer_contact_no'] ; ?></p>
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

    <div class="block" style="border: 1px solid #666;  padding: 7px;">
        <p><b>6. Executive Committee Meeting</b></p>
        <ul>

                <?php foreach($result as $res){ if($res['journal_history_status']==44){ ?>
             <li>
                 <p><b>Decision: </b>Accepted</p>
                 <p><b>Comments: </b><?php echo $res['comments']; ?></p>
            </li>
                    <li>
                        <p><b>Send to the author, if modification is needed: </b></p>
                        <table width="100%">
                            <tr>
                                <td width="30%"><p><b>Send Date:  </b><?php echo date("d-m-Y", strtotime($res['i_date'])) ; ?></p></td>
                                <?php foreach($result as $res){ if($res['journal_history_status']==4){  ?>
                                    <td width="30%">
                                        <p><b>Receive Date:  </b><?php echo date("d-m-Y", strtotime($res['i_date'])) ; ?></p>
                                    </td>
                                    <td width="30%">
                                        <p><b>Due Date:  </b><?php echo date("d-m-Y", strtotime($res['due_date'])) ; ?></p>
                                    </td>
                                <?php } } ?>
                            </tr>
                        </table>
                        <p>
                            <b>Verification by: </b><?php echo $res['reviewer_name'].", ".$res['reviewer_position'].", ".$res['reviewer_institute']; ?>

                        </p>
                        <p><b>Decision: </b>Accepted</p>
                        <p><b>Any comments:</b></p>
                        <p><b>EC: </b> To be communicated with the author(s) via Email informing within 7 days, whether he/ they will be abel to furtheer modify the article properly as per comments of the review and verification reports or not. Otherwise it will be considered as rejected</p>
                        <p><b>Email to the author :</b></p>
                        <p><b>Feedback from author:</b> </p>
                        <p><b>Due date of submission by the author : </b></p>
                        <p><b>Received from the  author :</b> </p>
                        <p><b>Title (given by author after review) :</b></p>
                        <p><b>Title (suggested by reviewer) :</b></p>
                        <p><b>EC :</b>Selected for publication</p>

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
                <p><b>Final Decision: </b>Rejected</p>
            </li>
            <?php } }?>
        </ul>


    </div>
    <div class="block" style="border: 1px solid #666;  padding: 7px;">
        <?php foreach($result as $res){ if($res['journal_history_status']==44){  ?>
       <b>7. Final Decision: </b>Accepted
        <?php } }?>
    </div>
    <div class="block" style="border: 1px solid #666;  padding: 7px;">
        <?php foreach($result as $res){ if($res['journal_history_status']==44){  ?>
       <b>8. Issue Number (decided to be published) :</b>
        <?php } }?>
    </div>


</div>
            <a class="btn btn-primary" style="margin-top: 15px" href="javascript:printDiv('print')">Print</a>
        </div>
    </div>
</div>
<!--    for print-->
<script>
    printDivCSS = new String ('<link href="myprintstyle.css" rel="stylesheet" type="text/css">')
    function printDiv(divId) {
        window.frames["print_frame"].document.body.innerHTML=printDivCSS + document.getElementById(divId).innerHTML;
        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();
    }
</script>
<iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>

</body>

</html>