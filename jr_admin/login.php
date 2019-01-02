<?php include "includes/header.php" ?>
    <section class="main-content">
        <div class="container-fluid">
            <div class="row row-eq-height">
                <div class="col-sm-2 sidebar_bg">
                    <?php include "includes/sidebar.php" ?>
                </div>
                <div class="col-sm-10">
                    <div class="login">
                        <h3>Welcome, Please login</h3>
                        <div class="login_body">
                            <input type="text" class="form-control" placeholder="User Name">
                            <input type="password" class="form-control" placeholder="Password">
                            <input type="submit" class="btn btn-theme pull-right" value="Login">
                            <br>
                            <br>
                            <p class="link">Forget password? <a href="">click here</a> to reset</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include "includes/footer.php" ?>