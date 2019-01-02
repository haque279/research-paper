<?php

spl_autoload_register(function($class){
    include "jr_admin/classes/".$class.".php";
});
?>
<?php
session_start();
$journal_id = $_GET['journal_id'];
$obj_journal = new Journal();

if(isset($_SESSION['user_name'])){
    $journal_user_id = $_SESSION['user_id'];
    $journal_user_email = $_SESSION['user_email'];

}
else {
    header("location: index.php");
}

$author_journal = $obj_journal->view_journal_by_author($journal_user_id);

if(isset($_POST['addition_submit'])){
    $obj_journal = new Journal();
    $author = $obj_journal->update_author($_POST);
    unset($_POST);
}


$author_id = $_GET['author_id'];
$authors = $obj_journal->view_additional_author_by_id($author_id);
foreach ($authors as $auth ){}


?>
<?php include "includes/header.php" ?>

    <section class="journal">
        <div class="container">
            <div class="row">

                <div class="col-md-offset-3 col-md-6">
                        <div class="search">
                            <h5>Update Author</h5>
                            <div class="search_inner">
                                <form action="" method="post">
                                    <input type="text" name="additional_author_id" placeholder="User Name" class="form-control" value="<?php echo $auth['additional_author_id']; ?>" >
                                    <input type="text" required name="additional_author_name" value="<?php echo $auth['additional_author_name']; ?>" placeholder="Name" class="form-control" >
                                    <input type="text" required name="additional_author_position" value="<?php echo $auth['additional_author_position']; ?>"  placeholder="Position"  class="form-control">
                                    <input type="text"  name="additional_author_institute" value="<?php echo $auth['additional_author_institute']; ?>"  placeholder="Institute"  class="form-control">
                                    <input type="text" required name="additional_author_contact_no" value="<?php echo $auth['additional_author_contact_no']; ?>"  placeholder="Contact no"  class="form-control">
                                    <input type="email" required name="additional_author_email" value="<?php echo $auth['additional_author_email']; ?>"  placeholder="Email"  class="form-control">
                                    <input type="text"  name="additional_author_tel" value="<?php echo $auth['additional_author_tel']; ?>"  placeholder="Telephone"  class="form-control">
                                    <input type="text"  name="additional_author_fax" value="<?php echo $auth['additional_author_fax']; ?>"  placeholder="Fax"  class="form-control">
                                    <input type="text"  name="additional_author_web" value="<?php echo $auth['additional_author_web']; ?>"  placeholder="Web page"  class="form-control">
                                    <input type="text"  name="additional_author_skype" value="<?php echo $auth['additional_author_skype']; ?>"  placeholder="Skype"  class="form-control">
                                    <input type="text"  name="additional_author_address" value="<?php echo $auth['additional_author_address']; ?>"  placeholder="Address"  class="form-control">
                                    <input type="text"  name="additional_author_country" value="<?php echo $auth['additional_author_country']; ?>"  placeholder="Country"  class="form-control">

                                    <select name="additional_author_journal_id" required  class="form-control" >
                                        <option value="">Pleace Select article</option>
                                        <?php
                                        if(isset($author_journal)){
                                            foreach($author_journal as $res) { ?>

                                                <option  value="<?php echo $res['journal_id']; ?>" <?php if ($auth['additional_author_journal_id']==$res['journal_id']){ echo 'selected'; } ?> > <?php echo $res['journal_title'] ?></option>
                                            <?php  } } ?>
                                    </select>
                                    <input type="submit" name="addition_submit" value="Update Author" class="btn btn-theme" >
                                </form>
                            </div>
                        </div>

                    <div class=""><a href="author.php" class="btn btn-primary">Back to main page</a></div>




                </div>
            </div>

        </div>
        </div>
    </section>

<?php include "includes/footer.php" ?>