<?php
spl_autoload_register(function($class) {
    include "jr_admin/classes/" . $class . ".php";
});
$obj_archive = new Archive();
$result = $obj_archive->view_current_issue_edit(1);
?>

<?php include "includes/header.php" ?>

    <section class="journal">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <?php foreach ($result as $res){ ?>
                    <div class="journal_content">
                        <h3><?php echo $res['current_title']; ?></h3>
                        <?php echo $res['current_content']; ?>
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
        