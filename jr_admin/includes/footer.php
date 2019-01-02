<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.slicknav.min.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="js/data_table.js"></script>
<script src="js/data_table_bootstrap.js"></script>
<script src="js/main.js"></script>
<script src="js/modernizr-2.8.3.min.js"></script>
<script src="dist/js/select2.min.js"></script>
<script src="jquery-ui/jquery-ui.min.js"></script>
<script>
    CKEDITOR.replace('editor1');
</script>

<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>

<!--    for print-->
<script>
    printDivCSS = new String('<link href="myprintstyle.css" rel="stylesheet" type="text/css">')
    function printDiv(divId) {
        window.frames["print_frame"].document.body.innerHTML = printDivCSS + document.getElementById(divId).innerHTML;
        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();
    }
</script>
<script>
    $(function () {
        var pgurl = window.location.href.substr(window.location.href
            .lastIndexOf("/") + 1);
        $(".sidebar ul li a").each(function () {
            if ($(this).attr("href") == pgurl || $(this).attr("href") == '')
                $(this).addClass("active");
        })
    });
</script>
<script type="text/javascript">
  $('.review_1').select2();
  $('.review_2').select2();
  
</script>


<script>
    $( ".datepicker" ).datepicker({
        dateFormat: "dd-mm-yy"
    });
</script>
<iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>

</body>

</html>