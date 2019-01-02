<?php
spl_autoload_register(function($class) {
    include "jr_admin/classes/" . $class . ".php";
});
    $id = 1;
    $obj_frontview = new Fronview();
    $result = $obj_frontview->view($id);
    foreach ($result as $res){}
?>
<?php include "includes/header.php"; ?>

    <section class="content">
        <div class="container">
            <div class="row">

                <div class="col-sm-4">
                    <div class="banner">
                        <img src="jr_admin/<?php echo $res['journal_file'] ?>" alt="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="about">
                        <?php echo $res['text'] ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="sub_menu">

                        <nav>
                            <ul>
                                <li><a href="about_journal.php"> About This Journal</a></li>
                                <li><a href="editorial_advisory_board.php">Editorial Advisory Board</a></li>
                                <li><a href="editorial_board.php">Editorial Board</a></li>
                                <li><a href="peer_review.php">Peer Review</a></li>
                                <li><a href="publication_athics_for_authors.php">Publication Ethics for Authors</a></li>
                                <li><a href="some_rules_of_the_journal.php">Some Rules of the Journal</a></li>
                                <li><a href="abstracting_formatting_and_referencing.php">Abstracting, Formatting and Referencing</a></li>
                                <li><a href="notes_for_contributors.php">Notes for Contributors and General Readers</a></li>
                                <li><a href="price_of_the_journal.php">Price of the Journal</a></li>
                                <li><a href="submission_procedure.php">Submission Procedure</a></li>
                                <!--
                                <li><a href="">Submission Procedure</a></li>
                                <li><a href="">Archive</a></li>
-->
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <?php include "includes/footer.php"; ?>