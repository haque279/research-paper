<?php include "includes/header.php" ?>
<?php
spl_autoload_register(function($class){
    include "abc_admin/classes/".$class.".php";
});

$id = $_GET['f_id'];
$obj_feedback = new Feedback();
$feedback = $obj_feedback->published_feedback_by_id($id);




?>

<body>

<!--[if lte IE 8]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>
<![endif]-->

	
    <!-- End Preload -->

	<div class="layer"></div>
    <!-- Mobile menu overlay mask -->
<section class="top_tag">
    <div class="container">
               <div class="row">
                   <div class="col-md-12">
                      <div class="tag_outer">
                           <a href="registration.php">
                       <div class="tag pull-right">
                            <div class="tag_text">
                                Regisgration 
                            </div>
                    </div>
                   </a>
                   <a href="call_for_paper.php">
                       <div class="tag2 pull-right">
                            <div class="tag_text">
                                Call for paper
                            </div>
                    </div>
                   </a>
                      </div>
                   </div>
               </div>
    </div>
</section>

    <section class="sub_header" id="pages">
        <div class="sub_header_content">
           
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="animated fadeInDown">
                        <div class="head">
                           <img class="" src="images/abc_logo.png" alt="">
                           <span >Annual Banking Conference</span>
                       </div>
                
            </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Section -->
    
    <div id="position">
        <div class="container">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">feedback</a></li>
            </ul>
        </div>
    </div><!-- End Position -->
    
    <div class="container margin_60">
       <div class="row">
           <div class="col-md-3">
               <div class="page_menu">
                            <?php include"includes/menu.php"  ?>
                        </div>
           </div>
           <div class="col-md-9">
                <div class="main_title">
                <span></span>
            
            <h2>Feedback from user</h2>
            </div>
<?php   foreach ($feedback as $res ) { ?>

                <p><?php echo $res['message'];  ?></p>
    <p>Posted by : <?php echo $res['first_name'].' '.$res['last_name'] ?> <br>
        Posted on : <?php echo date('d M Y ', strtotime($res['date']));   ?></p>

    <?php } ?>
        
        <hr>
           </div>
       </div>
        
        <div id="weather" class="clearfix"></div><!-- Weather widget -->
    </div><!-- End Container -->
        
<?php include "includes/footer.php" ?>