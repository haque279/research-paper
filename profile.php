<?php

spl_autoload_register(function($class){
    include "jr_admin/classes/".$class.".php";
});
?>
<?php
session_start();
if(isset($_SESSION['user_name'])){
   echo $journal_user_id = $_SESSION['user_id'];
   echo $journal_user_email = $_SESSION['user_email'];



}
else {
    header("location: index.php");
}


   if(isset($_POST['file_submit'])){
       $obj_journal = new Journal();
       $message = $obj_journal->journal_upload($_POST, $_FILES);
       unset($_POST);
   }

    if(isset($_POST['addition_submit'])){
        $obj_journal = new Journal();
        $author = $obj_journal->add_additional_author($_POST);
        unset($_POST);
    }

    $obj_journal = new Journal();
    $result = $obj_journal->view_additional_author($journal_user_id);
    $email = $obj_journal->view_additional_author_email($journal_user_id);
    $resultt = $obj_journal->journal_view($journal_user_id);
    $modified = $obj_journal->journal_modified_view($journal_user_id);
    $journal_author = $obj_journal->journal_view_with_author($journal_user_id);
    $user_data = $obj_journal->view_user_by_id($journal_user_id);
    foreach($user_data as $user){

    }
print_r($email);
echo $journal_user_email;
echo "<hr>";
if(in_array($journal_user_email, $email)){
    echo "this is none";
} else {echo "yes yes";}




?>
<?php include "includes/header.php" ?>

    <section class="journal">
        <div class="container">
            <div class="row">
                <?php  ?>
                <?php if(isset($author)){ ?> <h2 class="text-center"> <?php echo $author ?> </h2> <?php } ?>
                <div class="col-sm-6">
                    <div class="sidebar">
                        <div class="search">
                            <div class="search_inner2">
                            <?php $i=1; foreach ($result as $res){ ?>
                                <h5>Author- <?php echo $i ?></h5>
                            <ul>
                                <li><a href="">author: <?php echo $res['additional_author_name']?></a></li>
                                <li><a href="">mobile: <?php echo $res['additional_author_contact_no']?></a></li>
                                <li><a href="">position: <?php echo $res['additional_author_position']?></a></li>
                            </ul>
    <?php $i++; } ?>
                            </div>
                        </div>

                    <div class="search">
                            <h5>Welcome <?php echo $_SESSION['user_name']; ?> <br>
                            please Update your informatin
                            </h5>
                            <div class="search_inner">
                                <form action="" method="post">
                                    <input type="hidden" name="additional_author_name_user_id" placeholder="User Name" class="form-control" value="<?php echo $journal_user_id; ?>" >
                                    <input type="read" readonly  name="additional_author_name" value="<?php echo $_SESSION['user_name']; ?>"  class="form-control" >
                                    <input type="text" required name="additional_author_position"  placeholder="Position"  class="form-control">
                                    <input type="text"  name="additional_author_institute" placeholder="Institute"  class="form-control">
                                    <input type="text" required name="additional_author_contact_no" placeholder="Contact no"  value="<?php echo $user['user_contact_no']; ?>"  class="form-control">
                                    <input type="email" readonly name="additional_author_email" placeholder="Email"  value="<?php echo $user['user_email']; ?>"   class="form-control">
                                    <input type="text"  name="additional_author_tel" placeholder="Telephone"  class="form-control">
                                    <input type="text"  name="additional_author_fax" placeholder="Fax"  class="form-control">
                                    <input type="text"  name="additional_author_web" placeholder="Web page"  class="form-control">
                                    <input type="text"  name="additional_author_skype" placeholder="Skype"  class="form-control">
                                    <input type="text"  name="additional_author_address" placeholder="Address"  class="form-control">
                                    <input type="text"  name="additional_author_country" placeholder="Country"  class="form-control">

                                    <select name="additional_author_journal_id" required  class="form-control" >
                                        <option value="">Pleace Select Journal</option>
                                        <?php
                                        if(isset($resultt)){
                                            foreach($resultt as $res) { ?>

                                            <option  value="<?php echo $res['journal_id'] ?>"> <?php echo $res['journal_title'] ?></option>
                                        <?php  } } ?>
                                    </select>
                                    <input type="submit" name="addition_submit" value="Add Author" class="btn btn-theme" >
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-sm-6">
                   
                    <div class="search">
                            <h5>Add Author</h5>
                            <div class="search_inner">
                                <form action="" method="post">
                                    <input type="hidden" name="additional_author_name_user_id" placeholder="User Name" class="form-control" value="<?php echo $journal_user_id; ?>" >
                                    <input type="text" required name="additional_author_name" placeholder="Name" class="form-control" >
                                    <input type="text" required name="additional_author_position" placeholder="Position"  class="form-control">
                                    <input type="text"  name="additional_author_institute" placeholder="Institute"  class="form-control">
                                    <input type="text" required name="additional_author_contact_no" placeholder="Contact no"  class="form-control">
                                    <input type="email" required name="additional_author_email" placeholder="Email"  class="form-control">
                                    <input type="text"  name="additional_author_tel" placeholder="Telephone"  class="form-control">
                                    <input type="text"  name="additional_author_fax" placeholder="Fax"  class="form-control">
                                    <input type="text"  name="additional_author_web" placeholder="Web page"  class="form-control">
                                    <input type="text"  name="additional_author_skype" placeholder="Skype"  class="form-control">
                                    <input type="text"  name="additional_author_address" placeholder="Address"  class="form-control">
                                    <input type="text"  name="additional_author_country" placeholder="Country"  class="form-control">

                                    <select name="additional_author_journal_id" required  class="form-control" >
                                        <option value="">Pleace Select Journal</option>
                                        <?php
                                        if(isset($resultt)){
                                            foreach($resultt as $res) { ?>

                                            <option  value="<?php echo $res['journal_id'] ?>"> <?php echo $res['journal_title'] ?></option>
                                        <?php  } } ?>
                                    </select>
                                    <input type="submit" name="addition_submit" value="Add Author" class="btn btn-theme" >
                                </form>

                            </div>
                        </div>
                </div>
            </div>
        </div>
    </section>

    <?php include "includes/footer.php" ?>