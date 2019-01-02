<?php
spl_autoload_register(function($class) {
    include "jr_admin/classes/" . $class . ".php";
});
$id = 10;
$obj_frontview = new Fronview();
$result = $obj_frontview->view($id);
$journal_image = $obj_frontview->view(1);
foreach ($result as $res){}
foreach ($journal_image as $image){}
?>
<?php include "includes/header.php" ?>

    <section class="journal">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <div class="journal_content">

                        <div class="col-sm-6">
                            <img src="jr_admin/<?php echo $image['journal_file'] ?>" alt="">
                        </div>
                        <div class="col-md-6">
                            <div class="price">
                                <table>
                                   <tr>
                                       <th colspan="2">Price</th>
                                   </tr>
                                    <tr>
                                        <td>BDT</td>
                                        <td><?php echo $res['value1'] ?> Tk</td>
                                    </tr>
                                    <tr>
                                        <td>USD</td>
                                        <td><?php echo $res['value2'] ?> $</td>
                                    </tr>
                                </table>
                            </div>
                        </div>





                    </div>
                </div>
                <div class="col-sm-4">
                    <?php include "includes/sidebar.php" ?>

                </div>
            </div>
        </div>
    </section>

    <?php include "includes/footer.php" ?>