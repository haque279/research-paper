<?php
spl_autoload_register(function($class) {
    include "jr_admin/classes/" . $class . ".php";
});
$obj_archive = new Archive();
$result = $obj_archive->view_forthcoming_papers(1);
?>


<?php include "includes/header.php" ?>

    <section class="journal">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
<?php foreach ($result as $res){ ?>
                    <div class="journal_content">
                        <?php echo $res['forthcoming_title']; ?>
                    </div>
    <?php } ?>
                </div>

                <div class="col-sm-4">
                    <?php include "includes/sidebar.php" ?>

                </div>
            </div>
        </div>
    </section>

    <?php include "includes/footer.php" ?>