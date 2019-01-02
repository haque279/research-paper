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

$id = $_GET['id'];
$obj_archive = new Archive();
$result = $obj_archive->view_j_archive_edit($id);
foreach ($result as $res){}

if(isset($_POST['submit'])){
    $obj_archive->edit_j_archive($_POST);
    echo "uploaded";

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
                <div class="archive">
                    <h3>Update Journal Archive</h3>
                    <hr>

                    <form class="form-horizontal" action="" method="post">
                        <input type="hidden" name="j_archive_id" value="<?php echo $id; ?>">
                        <div class="form-group"> <label for="inputEmail3" class="col-sm-2 control-label">Issue Name</label>
                            <div class="col-sm-10"> <input type="text" name="j_archive_title" class="form-control" id="inputEmail3" placeholder="Issue Name" value="<?php echo $res['j_archive_title'] ?>"> </div>
                        </div>
                        <div class="form-group"> <label for="inputEmail3" class="col-sm-2 control-label">Issue Link</label>
                            <div class="col-sm-10"> <input type="url" name="j_archive_link" class="form-control" id="inputEmail3" placeholder="Issue Link" value="<?php echo $res['j_archive_link'] ?>"> </div>
                        </div>
                        <div class="form-group"> <label for="inputEmail3" class="col-sm-2 control-label">Position</label>
                            <div class="col-sm-10"> <input type="number" name="j_archive_position" class="form-control" id="inputEmail3" placeholder="Position" value="<?php echo $res['j_archive_position'] ?>"> </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10"> <button type="submit" name="submit" class="btn btn-success">Update</button>
                                <a href="journal_archive_view.php" class="btn btn-info">Back to Journal Archive</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>


<?php include "includes/footer.php" ?>