<?php
session_start();
?>
<?php include "includes/header.php" ?>

    <section class="journal">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                   <div class="search">
                      
                       <div class="search_inner">
                           <?php
                           if(isset($_SESSION['user_name_pending'])){
                               $user=  $_SESSION['user_name_pending']; ?>
                               <h2 style="padding: 50px; text-align:center; overflow: hidden" >Your account under review...   </h2>

                           <?php }else { ?>
                               <h2 style="padding: 50px; text-align:center; overflow: hidden" >Please try again...</h2>
                         <?php  }
                           ?>

                       </div>
                   </div>
                </div>
            </div>
        </div>
    </section>

    <?php include "includes/footer.php" ?>