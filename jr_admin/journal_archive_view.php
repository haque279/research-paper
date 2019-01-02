<?php

ob_start();
session_start();

spl_autoload_register(function($class){
    include "classes/".$class.".php";
});

if(isset($_SESSION['admin'])){

}else{
    header("location:index.php");
}

$obj_archive = new Archive();
$result = $obj_archive->view_j_archive();
if(isset($_POST['delete'])){
    $id = $_POST['id'];
    $obj_archive->delete_archive($id);
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
                    <a href="journal_archive_view.php" class="btn btn-primary">View Journal Archive</a>
                    <a href="journal_archive.php" class="btn btn-primary" >Add New to Journal Archive</a>


                        <?php
                        if(isset($_GET['message'])){ ?>
                            <br>
                            <br>
                            <div class="alert alert-success" role="alert">
                                <?php  echo $_GET['message']; ?>
                            </div>

                        <?php } ?>
                    <br>
                    <h3>View Journal Archive</h3>

                    <div class="table">
                        <div class="table-responsive" id="print">
                            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Positon No</th>
                                    <th>Journal Title</th>
                                    <th>Journal Link</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <?php $i =1;
                                foreach($result as $res){
                                    ?>
                                    <tr>
                                        <th scope="row"> <?php echo $i; ?> </th>
                                        <th scope="row"> <?php echo $res['j_archive_position'] ?> </th>
                                        <th scope="row"> <?php echo $res['j_archive_title'] ?> </th>
                                        <th scope="row"> <?php echo $res['j_archive_link'] ?> </th>
                                        <th>
                                            <form action="" method="post">
                                                <input type="hidden" name="id" value="<?php echo $res['j_archive_id'] ?> " >

                                                <a href="journal_archive_edit.php?id=<?php echo $res['j_archive_id'] ?>" class="btn btn-warning" >Edit</a>
                                                <input type="submit" name="delete" value="Delete" class="btn btn-danger">
                                            </form>
                                        </th>
                                        <?php $i++;  } ?>

                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Positon No</th>
                                    <th>Journal Title</th>
                                    <th>Journal Link</th>
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

<?php include "includes/footer.php" ?>