<?php
session_start();
spl_autoload_register(function($class){
    include "jr_admin/classes/".$class.".php";
});
?>
    <?php
ob_start();
    if(isset($_POST['reg_submit'])){
    //echo 'hello';exit();
        $obj_user = new User();
        $obj_user->add_user($_POST);
        //header('Location: reg_confirm.php');
    }

    if(isset($_POST['login_submit'])){
        $obj_user = new User();
        $obj_user->user_login($_POST);
        $obj_user->user_login_pending($_POST);
    }
    if(isset($_POST['logout_submit'])){
        $obj_user = new User();
        $message = $obj_user->user_login($_POST);
        echo $message;
    }
?>
        <!doctype html>
        <html class="no-js" lang="">

        <head>
            <meta charset="utf-8">
            <meta http-equiv="x-ua-compatible" content="ie=edge">
            <title>research-paper</title>
            <meta name="description" content="">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" type="image/png" href="images/favicon.png">
            <link href='https://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
            <link href='https://fonts.googleapis.com/css?family=Muli:400,300,400italic' rel='stylesheet' type='text/css'>
            <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,400i,700" rel="stylesheet">

            <link rel="stylesheet" href="jr_admin/jquery-ui/jquery-ui.min.css">
            <link rel="stylesheet" href="jr_admin/jquery-ui/jquery-ui.theme.min.css">
            <link rel="stylesheet" href="fancybox/jquery.fancybox.css">
            <link rel="stylesheet" href="css/normalize.css">
            <link rel="stylesheet" href="css/slicknav.css" />
            <link rel="stylesheet" href="css/bootstrap.css" />
            <link rel="stylesheet" href="css/style.css">
            <script src="js/modernizr-2.8.3.min.js"></script>
        </head>

        <body>



            <div id="fb-root"></div>
            <script>
                (function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s);
                    js.id = id;
                    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            </script>
            <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

            <!-- Add your site or application content here -->
            <section class="header_top">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <a href="https://research-paper.org.bd">
                                <h4>research-paper</h4>
                            </a>
                        </div>
                        <div class="col-sm-6">



                            <div id="login">
                                <h3>Please Login</h3>
                                <form action="" method="post">
                                    <input type="email" name="user_email" class="form-control" placeholder="Enter your email">
                                    <input type="password" name="user_password" class="form-control" placeholder="Enter your password">
                                    <input type="submit" class="btn btn-theme  pull-right" name="login_submit" value="Login">
                                </form>
                            </div>
                            <div id="reg">
                                <h3>Registration</h3>
                                <form action="" method="post">
                                    <input type="text" required name="user_name" class="form-control" placeholder="Your Name">
                                    <input type="email" required name="user_email" class="form-control" placeholder="Your email">

                                    <input type="text" required name="user_address" class="form-control" placeholder="Address">
                                    <input type="text" required name="user_contact_no" class="form-control" placeholder="Contact no">
                                    <input type="password" required name="user_password" pattern="(?=.*\d)(?=.*[a-zA-Z]).{8,}" class="form-control" placeholder="Password">
                                    <p>Must contain at least one number, one letter and at least 8 characters</p>
                                    <div class="fix">
                                        <input type="submit" name="reg_submit" class="btn btn-theme pull-right" value="Registration">
                                    </div>
                                </form>
                            </div>


                            <nav class="top_right">
                                <ul>

                                    <?php if(isset($_SESSION['user_name'])){ ?>
                                        <li><a class="single_2" rel="group" href="logout.php">Logout</a></li>
                                        <li><a href="author.php">Author</a></li>
                                        <?php } else  { ?>
                                            <li><a class="single_2" rel="group" href="#login">Login</a>
<!--                                                <ul>-->
<!--                                                    <li><a class="single_2" rel="group" href="#login">Author Login</a></li>-->
<!---->
<!--                                                    <li><a href="reviewer.php">Reviewer Login</a></li>-->
<!--                                                    <li><a href="http://journal.research-paper.org.bd/jr_admin/">Admin Login</a></li>-->
<!--                                                </ul>-->
                                            </li>

                                            <?php }
                            ?>


                                                <li><a class="single_2" rel="group" href="#reg">Registration</a></li>
                                                <!--                            <li><a href="">Help</a></li>-->
                                                <li><a href="contact_us.php">Contact</a></li>
                                                <!--                            <li><a href="">Webmail</a></li>-->
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </section>

            <section class="header">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="main_logo">
                                <a href="index.php">
                                    <img src="images/logo.png" alt="">
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <section class="menu">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="menu" class="menu">
                                <ul>
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="current_issue.php">Current Issue</a></li>
                                    <li><a href="journal_archive.php">Journal Archive</a></li>

                                    <li><a href="forthcoming_papers.php">Forthcoming Papers</a></li>
<!--                                    <li><a href="#">Purchase</a></li>-->
<!--                                    <li><a href="subscription.php">Subscription </a></li>-->
                                    <li><a href="feedback.php">Feedback </a></li>
                                    <div class="input-group search_journal">
                                        <div class="input-group">
                                            <input type="text" placeholder="Search for...">
                                            <span class="input-group-btn">
        <button class="btn btn-theme" type="button">Go!</button>
      </span>
                                        </div>


                                    </div>


                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </section>