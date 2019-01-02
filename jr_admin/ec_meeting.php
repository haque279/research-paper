
<?php
ob_start();
session_start();

spl_autoload_register(function($class) {
    include "classes/" . $class . ".php";
});
?>

<?php
extract($_POST);
extract($_GET);
if (isset($_SESSION['admin'])) {
    $obj_admin = new Admin();
    
        $result = $obj_admin->get_ec_meeting_info();
        
        //$result = $obj_admin->get_accepted_article_info($_GET['journal_id']);
        
    

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
            <div class="col-sm-10">
                <h4 style="font-weight: bolder;margin-left: 30px;color: #006699">Meeting Details</h4>
                <a href="add_ec_meeting.php" style="margin-right: 20px;margin-top: -30px" class="btn btn-danger pull-right">Add Meeting</a>
                <hr style="background-color: #8c8c8c;height: 1.5px;border-top: 3px double #8c8c8c;">
                <div class="table">
                        <div class="table-responsive" id="print">
                            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Serial No</th>
                                    <th>Article</th>
                                    <th>Year</th>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Minors</th>
                                    <th>Action</th>
                                    
                                </tr>
                                </thead>
                                <?php $i = 1;
                                foreach($result as $res){
                                    ?>
                                    <tr>
                                        <th scope="row"> <?php echo $i ?> </th>
                                        <td><?php $journal=  $obj_admin->journal_by_id($res['journal_id']);
                                            echo $journal['journal_title']
                                            ?></td>
                                        <td><?php echo $res['year'];?></td>
                                        <td><?php echo $res['no'];?></td>
                                        <td>
                                            <?php if (!empty($res['date'])){ echo date('d-m-Y', strtotime($res['date'])); } ?>
                                        </td>
                                        <td><a href="review_files/<?php echo $res['minors']; ?>" download><?php echo $res['minors']; ?></a></td>
                                        <td><a href="update_ec_meeting.php?id=<?php echo $res['id']; ?>" class="btn btn-primary btn-xs">Update</a></td>
                                        
                                    </tr>
                                    <?php $i++; } ?>
                                <tfoot>
                                <tr>
                                   <th>Serial No</th>
                                    <th>Article</th>
                                    <th>Year</th>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Minors</th>
                                    <th>Action</th>
                                  
                                </tr>
                                </tfoot>


                            </table>
                        </div>

                        <a class="btn btn-primary" href="javascript:printDiv('print')">Print</a>
                    </div>
                
                

    </div>
</section>


<?php include "includes/footer.php" ?>





