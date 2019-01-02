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

$id = $_GET['id'];
$title = $_GET['title'];
//$obj_journal = new Journal();
//$obj_journal->journal_mod_update($id);

if(isset($_POST['file_submit'])){
    $obj_journal = new Journal();
    $message = $obj_journal->journal_upload_update_two($_POST, $_FILES);
//    $obj_journal->journal_mod_update($id);
    unset($_POST);
    unset($_FILES);
}


$obj_journal = new Journal();
$resultt = $obj_journal->journal_view($journal_user_id);


?>
<?php include "includes/header.php" ?>

    <section class="journal">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-3 col-sm-6">
                    <div class="search">
                        <h4>Welcome <?php echo $_SESSION['user_name']; ?></h4>
                        <div class="search_inner">
                            <h5>Please upload a modified journal</h5>
                            <p style="color: #000; font-size: 16px; font-weight: 700"><?php if(isset($message)){ echo $message; } ?></p>

                            <form action="" method="post" enctype="multipart/form-data" >
                                <input type="text" readonly name="journal_title" placeholder="Title" value="<?php
                                echo $title;
                                ?>" class="form-control" >
                                <input type="file" required name="journal_file" class="btn btn-default btn-file">
                                <p>upload only: pdf, doc, docx file</p>
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