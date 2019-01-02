<?php

spl_autoload_register(function($class){
    include "jr_admin/classes/".$class.".php";
});
 if(isset($_POST['submit'])){
    $obj_user = new User();
     $feedback = $obj_user->send_feedback($_POST);
 }
?>
    <?php include "includes/header.php" ?>

    <section class="journal">
        <div class="container">
            <div class="row">
                <div class=" col-sm-8">
                    <div class="journal_content">
                        <h4>Feedback</h4>
                        <?php if (isset($feedback)){
                            echo $feedback;
                        } ?>
                        <h6 class="no_border">Any queries send a message</h6>
                        <form action="" method="post">
                            <input class="form-control" type="text" name="name" placeholder="Your Name">
                            <input class="form-control" type="email" name="email" placeholder="Your Email Address">
                            <textarea class="form-control" name="message" id="" cols="30" rows="10"></textarea>
                            <input class="btn btn-theme" name="submit" type="submit" value="Send Feedback">
                        </form>


                    </div>
                </div>
                <div class="col-sm-4">
                    <?php include "includes/sidebar.php" ?>

                </div>
            </div>
        </div>
    </section>

    <?php include "includes/footer.php" ?>