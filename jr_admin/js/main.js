// slick nav for mobile menu

	$(function(){
		$('#menu').slicknav();
	});



    $(document).ready(function () {
        $("a .a").click(function () {
            $("a .b").slideToggle('slow');
        });
    });

$(document).ready(function() {
    $("#replyuser").hide();

    $("#reply").click(function() {
        $("#replyuser").toggle('slow');
        });
    });
});

//data table
//$(document).ready(function() {
//    $('#example').DataTable();
//} );

