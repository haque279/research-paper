<?php
spl_autoload_register(function($class) {
    include "jr_admin/classes/" . $class . ".php";
});
$id = 2;
$obj_frontview = new Fronview();
$result = $obj_frontview->view($id);
foreach ($result as $res){}
?>
<?php include "includes/header.php" ?>

    <section class="journal">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <div class="journal_content">
                        <h4><?php echo $res['title']; ?></h4>
                        <?php echo $res['text']; ?>



                    </div>
                </div>
                <div class="col-sm-4">
                    <?php include "includes/sidebar.php" ?>

                </div>
            </div>
        </div>
    </section>

    <?php include "includes/footer.php" ?>