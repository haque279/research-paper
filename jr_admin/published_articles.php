<?php
ob_start();
session_start();

spl_autoload_register(function($class) {
    include "classes/" . $class . ".php";
});
?>
<?php
if (isset($_SESSION['admin'])) {
    $obj_admin = new Admin();
    $result = $obj_admin->published_articles();
    $reviewer = $obj_admin->view_reviewer();
} else {
    header("location:index.php");
}

?>


<?php include "includes/header.php" ?>
<section class="main-content">
    <div class="container-fluid">
        <div class="row row-eq-height">
            <div class="col-sm-2 sidebar_bg">
<?php include "includes/sidebar.php" ?>
            </div>
            <div class="col-sm-10 ">
                <div class="table">
                    <div class="table-responsive" id="print">
                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Article No</th>
                                    <th>Article Title</th>
                                    <th>Author Details</th>
                                    <th>Accepted Date</th>
                                    <th>Published Year</th>
                                    <th>Issue Name</th>
                                     <th>Add Details</th>
                                </tr>
                            </thead>
<?php
$i = 1;
foreach ($result as $res) {
    ?>
                                <tr>
                                    <th scope="row"> <?php echo $i ?> </th>
                                    <td><a href="journal_details.php?journal_id=<?php echo $res['journal_id']; ?>&journal_no=<?php echo $i ; ?>"><?php echo $res['journal_title']; ?></a></td>
                                    <td>
    <?php echo $res['user_name'] . "<br/>"; ?>
    <?php echo $res['user_email'] . "<br/>"; ?>
                                        <?php echo $res['user_contact_no']; ?>
                                    </td>
                                    <td>
                                        <?php echo date('d-m-Y', strtotime($res['accepeted_at'])) ; ?>

                                    </td>
                                    <td>
                                      <?php if (isset($res['published_year'])){ echo date('d-m-Y', strtotime($res['published_year'])); } ?>
                                        
                                    </td>
                                    <td>
                                        <?php echo $res['issue_name']; ?>
                                    </td>

                                    <td>
                                       <a href="published_article_details.php?journal_id=<?php echo $res['journal_id']; ?>" class="btn btn-primary btn-xs">Add Details</a> 
                                    </td>

                                </tr>
    <?php $i++;
} ?>
                            <tfoot>
                                <tr>
                                   <th>Article No</th>
                                    <th>Article Title</th>
                                    <th>Author Details</th>
                                    <th>Accepted Date</th>
                                    <th>Published Year</th>
                                    <th>Issue Name</th>
                                     <th>Add Details</th>

                                </tr>
                            </tfoot>


                        </table>
                    </div>

                    <a class="btn btn-primary" href="javascript:printDiv('print')">Print</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include "includes/footer.php" ?>

