<?php
spl_autoload_register(function($class) {
    include "jr_admin/classes/" . $class . ".php";
});
$obj_archive = new Archive();
$result = $obj_archive->view_j_archive();
?>
<?php include "includes/header.php" ?>

    <section class="journal">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">

                    <div class="journal_content2">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="journal_list">
                                    <?php foreach ($result as $res){ ?>
                                    <li><i class="glyphicon glyphicon-th-large"></i><a href="<?php echo $res['j_archive_link']; ?>" target="_blank">
                                            <?php echo $res['j_archive_title']; ?>
                                        </a></li>
                                    <?php } ?>

                                </ul>
                            </div>

                        </div>


                    </div>
                </div>

                <div class="col-sm-4">
                    <?php include "includes/sidebar.php" ?>

                </div>
            </div>
        </div>
    </section>

    <?php include "includes/footer.php" ?>