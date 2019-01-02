<?php

spl_autoload_register(function($class){
    include "abc_admin/classes/".$class.".php";
});

$ojb_feedback = new Feedback();



if(isset($_POST['submit'])){
    $message = $ojb_feedback->add_feedback($_POST);

    $to = "robel27@gmail.com";
    $subject = "Annual Banking Conference";
    $txt = "Name: ".$_POST['f_name']." ".$_POST['l_name']."\r\n"."Phone: ".$_POST['phone']."\r\n"."Email: ".$_POST['email']."\r\n".$_POST['message'];
    $headers = "From: ABC@bibm.org.bd";
    $mail = mail($to,$subject,$txt,$headers);

}

?>
    <?php include "includes/header.php" ?>

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
                                    <span>Annual Banking Conference</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Section -->

        <div id="position">
            <div class="container">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Your opinions</a></li>
                </ul>
            </div>
        </div>
        <!-- End Position -->
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
                        <h2>Send your opinions</h2>
                        <h4>
                            <?php if(isset( $message)){  echo "Your opinion has been send"; } ?>
                        </h4>
                    </div>

                    <div id="message-contact"></div>
                    <form method="post" >
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input required type="text" class="form-control"  name="f_name" placeholder="Enter Name">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input required type="text" class="form-control"  name="l_name" placeholder="Enter Last Name">
                                </div>
                            </div>
                        </div>
                        <!-- End row -->
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input required type="email" name="email" class="form-control" placeholder="Enter Email">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" required  name="phone" class="form-control" placeholder="Enter Phone number">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea id="message_contact" required name="message" class="form-control" placeholder="Write your message" style="height:150px;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row add_bottom_30">
                            <div class="col-md-6">
                                <input type="submit" value="Send  opinions" name="submit" class="btn_1" >
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End col-md-8 -->

            </div>
            <!-- End row -->
        </div>

        <?php include "includes/footer.php" ?>