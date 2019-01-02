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
$obj_journal = new Journal();
$obj_admin = new Admin();

$id = $_GET['id'];
$title = $_GET['title'];
//$obj_journal = new Journal();
//$obj_journal->journal_mod_update($id);

if(isset($_POST['file_submit'])){
    $message = $obj_journal->journal_upload_update($_POST, $_FILES);
//    $obj_journal->journal_mod_update($id);
    unset($_POST);
    unset($_FILES);
}


$resultt = $obj_journal->journal_view($journal_user_id);


$reports = $obj_admin->display_modification_report($id);
foreach ($reports as $report){
}

?>
<?php include "includes/header.php" ?>

    <section class="journal">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th colspan="2">Reports</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Review Report 1: <a href="review_files/<?php echo $report['reviewer_review_report_1']; ?>" download><?php if (!empty($report['reviewer_review_report_1'])){ echo "FILE";} ?></a></td>
                            <td>Review Paper 1: <a href="review_files/<?php echo $report['reviewer_review_paper_1']; ?>" download><?php if (!empty($report['reviewer_review_paper_1'])){ echo "FILE";} ?></a></td>
                        </tr>
                        <tr>
                            <td>Review Report 2:  <a href="review_files/<?php echo $report['reviewer_review_report_2']; ?>" download><?php if (!empty($report['reviewer_review_report_2'])){ echo "FILE";} ?></a> </td>
                            <td>Review Paper 2:  <a href="review_files/<?php echo $report['reviewer_review_paper_2']; ?>" download><?php if (!empty($report['reviewer_review_paper_2'])){ echo "FILE";} ?></a> </td>
                        </tr>
                        <tr>
                            <td>Review Report 3:  <a href="review_files/<?php echo $report['reviewer_review_report_3']; ?>" download><?php if (!empty($report['reviewer_review_report_3'])){ echo "FILE";} ?></a> </td>
                            <td>Review Paper 3:  <a href="review_files/<?php echo $report['reviewer_review_paper_3']; ?>" download><?php if (!empty($report['reviewer_review_paper_3'])){ echo "FILE";} ?></a> </td>
                        </tr>
                        <tr>
                            <td>Send date: <?php echo date('d-m-Y', strtotime($report['reviewer_sent_date'])) ?></td>
                            <td>Due Date of Submission: <?php echo date('d-m-Y', strtotime($report['reviewer_submission_due_date'])) ?></td>
                        </tr>
                        <tr>
<!--                            <td>Reviewer Submission Date: --><?php //echo date('d-m-Y', strtotime($report['reviewer_submission_date'])) ?><!--</td>-->
                            <td>Author submission date: <?php if (isset($report['author_submission_date'])){ echo date('d-m-Y', strtotime($report['author_submission_date'])); } ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-offset-3 col-sm-6">
                    <div class="search">
                        <h4>Hi <?php echo $_SESSION['user_name']; ?></h4>
                        <div class="search_inner">
                            <h5>Please upload a modified journal</h5>
                            <p style="color: #000; font-size: 16px; font-weight: 700"><?php if(isset($message)){ echo $message; } ?></p>

                            <form action="" method="post" enctype="multipart/form-data" >
                                <input type="text" readonly name="journal_title" placeholder="Title" value="<?php
                                echo $title;
                                ?>" class="form-control" >
                                <p><strong>Final Paper</strong></p>
                                <input type="file" required name="journal_file" class="btn btn-default btn-file">
                                <p>upload only: doc, docx file</p>
                                <p><strong>Modification Summary</strong></p>
                                <input type="file" required name="modification_summary" class="btn btn-default btn-file">
                                <p>upload only: doc, docx file</p>
                                <input type="hidden" name="journal_date" value="<?php echo  date("d-m-Y") ?>" >
                                <input type="hidden" name="journal_user_id" value="<?php echo  $journal_user_id ?>" >
                                <input type="hidden" name="journal_id" value="<?php echo  $id ?>" >

                                <input type="submit" name="file_submit" class="btn btn-theme " value="Upload your journal">

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


<?php include "includes/footer.php" ?>