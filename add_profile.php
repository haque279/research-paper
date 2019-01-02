<?php

spl_autoload_register(function($class){
    include "jr_admin/classes/".$class.".php";
});
?>
<?php
session_start();
$journal_id = $_GET['journal_id'];
if(isset($_SESSION['user_name'])){
    $journal_user_id = $_SESSION['user_id'];
    $journal_user_email = $_SESSION['user_email'];


}
else {
    header("location: index.php");
}

if(isset($_POST['file_submit'])){
       $obj_journal = new Journal();
       $message = $obj_journal->journal_upload($_POST, $_FILES);
   }

    if(isset($_POST['addition_submit'])){
        $obj_journal = new Journal();
        $author = $obj_journal->add_additional_author($_POST);
        unset($_POST);
    }


    $obj_journal = new Journal();
    $result = $obj_journal->view_additional_author($journal_user_id);
    $email = $obj_journal->view_additional_author_email($journal_user_id, $journal_id);
    $resultt = $obj_journal->journal_view($journal_user_id);
    $modified = $obj_journal->journal_modified_view($journal_user_id);
    $journal_author = $obj_journal->journal_view_with_author($journal_user_id);
    $user_data = $obj_journal->view_user_by_id($journal_user_id);
    $view_author = $obj_journal->view_additional_author_all($journal_id);
    foreach($user_data as $user){

    }



?>
<?php include "includes/header.php" ?>

    <section class="journal">
        <div class="container">
            <div class="row">

                <div class="col-md-6">

          <?php  foreach($email as $e){



          }
          if(count(in_array($journal_user_email, $e))==1){ ?>
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
                              <option value="">Pleace Select article</option>
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
         <?php   } elseif((count(in_array($journal_user_email, $e))==0)) { ?>
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
                              <option value="">Pleace Select article</option>
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
          <?php  } ?>
                    <div class=""><a href="author.php" class="btn btn-primary">Back to main page</a></div>




                    </div>

                <div class="col-md-6">

                    <h2>Author list</h2>
                    <?php if (!empty($view_author)){ foreach ($view_author as $auth){ ?>
    <li><a href="update_profile.php?author_id=<?php echo $auth['additional_author_id']; ?>"><?php echo $auth['additional_author_name']; ?></a></li>
    <?php } }else{ ?>

                    <h2 class="text-danger">Please add Author first</h2>
                    <?php } ?>
                </div>
                </div>

            </div>
        </div>
    </section>

    <?php include "includes/footer.php" ?>