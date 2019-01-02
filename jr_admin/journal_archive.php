<?php
ob_start();
session_start();

spl_autoload_register(function($class) {
    include "classes/" . $class . ".php";
});

if(isset($_SESSION['admin'])){

}else{
    header("location:index.php");
}

$obj_archive = new Archive();

if(isset($_POST['submit'])){
    $obj_archive->add_j_arcive($_POST);

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
                <br>
                <div class="archive">
                    <h3>Add to Journal Archive</h3>
                    <hr>
                    <?php
                    if(isset($_GET['message'])){ ?>
                        <br>
                        <br>
                        <div class="alert alert-success" role="alert">
                            <?php  echo $_GET['message']; ?>
                        </div>

                    <?php } ?>
                    <form class="form-horizontal" action="" method="post">
                        <div class="form-group"> <label for="inputEmail3" class="col-sm-2 control-label">Issue Name</label>
                            <div class="col-sm-10"> <input type="text" name="j_archive_title" class="form-control" id="inputEmail3" placeholder="Issue Title" required> </div>
                        </div>
                        <div class="form-group"> <label for="inputEmail3" class="col-sm-2 control-label">Issue Link</label>
                            <div class="col-sm-10"> <input type="url" name="j_archive_link" class="form-control" id="inputEmail3" placeholder="Issue link"> </div>
                        </div>
<!--                        <div class="form-group"> <label for="inputEmail3" class="col-sm-2 control-label">Position</label>-->
<!--                            <div class="col-sm-10"> <input type="number" name="j_archive_position" class="form-control" id="inputEmail3" placeholder="Journal Position"> </div>-->
<!--                        </div>-->

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10"> <button type="submit" name="submit" class="btn btn-default">Add to list</button> </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<?php include "includes/footer.php" ?>