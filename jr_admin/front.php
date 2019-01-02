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

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $obj_frontview = new Fronview();
    $result = $obj_frontview->view($id);
//var_dump($result);
//exit;
    foreach ($result as $res){}


    if(isset($_POST['submit'])){
        $obj_frontview->update($_POST, $_FILES);

    }
}

?>


<?php include "includes/header.php" ?>
    <style>
        .web_menu {margin-bottom: 10px}
        .web_menu a {margin-bottom: 5px}
    </style>
    <section class="main-content">
        <div class="container-fluid">
            <div class="row row-eq-height">
                <div class="col-sm-2 sidebar_bg">
                    <?php include "includes/sidebar.php" ?>
                </div>
                <div class="col-sm-10">
                    <h3>Website Content</h3>
                    <div class="text-right web_menu"  >
                        <a href="front.php?id=1" class="btn btn-primary">Home Page</a>
                        <a href="front.php?id=2" class="btn btn-primary">About Page</a>
                        <a href="front.php?id=3" class="btn btn-primary">Editorial Advisory Board</a>
                        <a href="front.php?id=4" class="btn btn-primary">Editorial Board</a>
                        <a href="front.php?id=5" class="btn btn-primary">Peer Review</a>
                        <a href="front.php?id=6" class="btn btn-primary">Publication Ethics for Authors</a>
                        <a href="front.php?id=7" class="btn btn-primary">Some Rules of the Journal</a>
                        <a href="front.php?id=8" class="btn btn-primary">Abstracting, Formatting and Referencing</a>
                        <a href="front.php?id=9" class="btn btn-primary">Notes for Contributors and General Readers</a>
                        <a href="front.php?id=10" class="btn btn-primary">Price of The Journal</a>
                        <a href="front.php?id=11" class="btn btn-primary">Submission Procedure</a>
                    </div>

                    <?php
                    if(isset($_GET['message'])){ ?>
                        <div class="alert alert-success" role="alert">
                            <?php  echo $_GET['message']; ?>
                        </div>

                    <?php } ?>

                    <?php if (isset($id)){ ?>
                        <form class="form-horizontal" action="" method="post"  enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" name="title" value="<?php echo $res['title']; ?>" class="form-control" id="inputEmail3" placeholder="">
                                </div>
                            </div>
                            <?php if ($id==10){ ?>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">BDT</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="value1" value="<?php echo $res['value1']; ?>" class="form-control" id="inputEmail3" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">USD</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="value2" value="<?php echo $res['value2']; ?>" class="form-control" id="inputEmail3" placeholder="">
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($id == 1){ ?>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">Upload Neww Image</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="journal_file" value="<?php echo $res['title']; ?>" class="form-control" id="inputEmail3" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">Current Image</label>
                                    <div class="col-sm-10">
                                        <img style="width: 200px" src="<?php echo $res['journal_file'] ?>" alt="Journal Image">
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($id != 10){ ?>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">Details</label>
                                    <div class="col-sm-10">
                                <textarea name="text" id="editor1" rows="20" cols="80">
                                    <?php echo $res['text']; ?>
                                </textarea>
                                    </div>
                                </div>
                            <?php } ?>


                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="fix">
                                        <input type="submit" name="submit" value="Update Now" class=" btn btn-theme">
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php } ?>


                </div>
            </div>
        </div>
    </section>

<?php include "includes/footer.php" ?>