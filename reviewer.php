<?php

spl_autoload_register(function($class){
    include "jr_admin/classes/".$class.".php";
});
?>

<?php
session_start();
  if(isset($_POST['submit'])){
      $obj_admin = new Admin();
      $rev = $obj_admin->reviewer_login($_POST);

      var_dump($rev);



  }
?>

<?php include "includes/header.php" ?>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-offset-3">
                    <div class="col-md-6">
                        <div class="login">
                           <h2>Please login</h2>
                            <h3 class="text-center" style="color: red"><?php if(isset($rev)){ echo $rev ; } ?></h3>
                            <form action=""  method="post">
                                <input type="email" class="form-control" name="reviewer_email" placeholder="Your email">
                                <input type="password" class="form-control" name="reviewer_password" placeholder="Passsword">
                                <input type="submit" name="submit" class="btn btn-theme" >
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include "includes/footer.php" ?>