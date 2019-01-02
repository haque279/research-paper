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
                    <li><a href="#">How to communicate</a></li>
                </ul>
            </div>
        </div>

        <section>
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
                            <h2>Communicate with us</h2>
                        </div>
                        
                    <div class="col-md-7">
                        

                        <form method="post" action="assets/contact.php" id="contactform">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" id="name_contact" name="name_contact" placeholder="Enter Name">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" id="lastname_contact" name="lastname_contact" placeholder="Enter Last Name">
                                    </div>
                                </div>
                            </div>
                            <!-- End row -->
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" id="email_contact" name="email_contact" class="form-control" placeholder="Enter Email">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" id="phone_contact" name="phone_contact" class="form-control" placeholder="Enter Phone number">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Message</label>
                                        <textarea id="message_contact" name="message_contact" class="form-control" placeholder="Write your message" style="height:150px;"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row add_bottom_30">
                                <div class="col-md-6">
                                    <input type="submit" value="Submit" class="btn_1" id="submit-contact">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-5">
                        <div class="">
                            <div class="box_style_1">
                                <h3>Contacts</h3>
                                <h5>Address</h5>
                                <p>
                                    Plot No. 4, Main Road No. 1 (South),
                                    <br> Section No. 2 Mirpur,
                                    <br> Dhaka-1216.
                                </p>
                                <h5>Telephone</h5>
                                <p>
                                    PABX: 9003031 - 5, 9003051 - 2
                                </p>
                                <p>
                                    Fax: 88-02-9006756
                                </p>
                                <h5>Email</h5>
                                <p>
                                    office@bibm.org.bd
                                </p>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </section>



        <div id="map"> </div>

        <?php include "includes/footer.php" ?>