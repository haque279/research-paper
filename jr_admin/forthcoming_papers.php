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

$id = 1;
$obj_archive = new Archive();
$result = $obj_archive->view_forthcoming_papers($id);
foreach ($result as $res){}


if(isset($_POST['submit'])){
    $obj_archive->edit_forthcoming_papers($_POST);

}
?>


<?php include "includes/header.php" ?>
    <section class="main-content">
        <div class="container-fluid">
            <div class="row row-eq-height">
                <div class="col-sm-2 sidebar_bg">
                    <?php include "includes/sidebar.php" ?>
                </div>
                <div class="col-sm-10">
                    <h3>Update Current Issue</h3>
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
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Forthcoming Title</label>
                            <div class="col-sm-10">
                                <textarea name="forthcoming_title" id="editor1" rows="20" cols="80">
                                    <?php echo $res['forthcoming_title']; ?>
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="fix">
                                    <input type="submit" name="submit" value="Update Forthcoming Title" class=" btn btn-theme">
                                </div>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </section>

<?php include "includes/footer.php" ?>