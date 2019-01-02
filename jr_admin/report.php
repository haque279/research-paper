<?php

ob_start();
session_start();

spl_autoload_register(function($class){
    include "classes/".$class.".php";
});
?>
<?php


$obj_count = new Count();






?>


<?php include "includes/header.php" ?>

    <section class="main-content">
        <div class="container-fluid">
            <div class="row row-eq-height">
                <div class="col-sm-2 sidebar_bg noprint">
                    <?php include "includes/sidebar.php" ?>
                </div>
                <div class="col-sm-10 ">
                    <div class="table">
                        <div class="table-responsive" id="print" >
                            <table class="table table-striped table-bordered" width="100%" style="text-align: left">


                                <tr>
                                    <th>Serial No</th>
                                    <th>Component</th>
                                    <th>Total Number</th>
                                </tr>
                                <tr>
                                    <th>1. </th>
                                    <th>Total Articles</th>
                                    <th><?php echo  $obj_count->total_author(); ?></th>
                                </tr>
                                <tr>
                                    <th>2. </th>
                                    <th>Preliminary Review Stage</th>
                                    <th><?php echo  $obj_count->total_journal(); ?></th>
                                </tr>
                                <tr>
                                    <th>3. </th>
                                    <th>Final review Stage</th>
                                    <th>
                                        <?php echo $obj_count->journal_priliminary(); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <th>4. </th>
                                    <th>Modification Stage</th>
                                    <th>
                                        <?php echo $obj_count->journal_modified(); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <th>5. </th>
                                    <th>Verification Stage</th>
                                    <th>
                                        <?php echo $obj_count->journal_secondary_one(); ?>
                                    </th>
                                </tr>
                                
                                <tr>
                                    <th>7. </th>
                                    <th>Accepted Articles</th>
                                    <th>
                                        <?php echo $obj_count->journal_waiting_publication(); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <th>8. </th>
                                    <th>Rejected Articles</th>
                                    <th>
                                        <?php echo $obj_count->journal_rejected(); ?>
                                    </th>
                                </tr>
                                 <tr>
                                    <th>8. </th>
                                    <th>Publishable Articles</th>
                                    <th>
                                        <?php echo $obj_count->journal_rejected(); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <th>6. </th>
                                    <th>In Press</th>
                                    <th>
                                        <?php echo $obj_count->journal_secondary_two(); ?>
                                    </th>
                                </tr>
                                 <tr>
                                    <th>8. </th>
                                    <th>Published Articles</th>
                                    <th>
                                        <?php echo $obj_count->journal_rejected(); ?>
                                    </th>
                                </tr>

				

                            </table>
                            <a class="btn btn-primary" href="javascript:printDiv('print')">Print </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>





<?php include "includes/footer.php" ?>