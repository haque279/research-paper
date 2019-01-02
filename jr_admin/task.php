<?php include "includes/header.php" ?>
    <section class="main-content">
        <div class="container-fluid">
            <div class="row row-eq-height">
                <div class="col-sm-2 sidebar_bg">
                    <?php include "includes/sidebar.php" ?>
                </div>
                <div class="col-sm-10">
                   <h3>Input Notice board here</h3>
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Headline</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputEmail3" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Details</label>
                            <div class="col-sm-10">
                                <textarea name="editor1" id="editor1" rows="10" cols="80">
                                    
                                </textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="fix">
                                    <input type="submit" value="Submit" class=" btn btn-theme">
                                </div>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </section>

    <?php include "includes/footer.php" ?>