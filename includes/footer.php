<section class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <ul>
                    <h4>Contact Us</h4>
                    
                    <li>
                        <p>Section No. 2,  Dhaka-1216.</p>
                    </li>
                    <li>
                        <p>PABX: 2559003031-5, 5889003051-2 (Ext. 135)</p>
                    </li>
                    <li>
                        <p>Email: research-paperresearch@research-paper.org.bd</p>
                    </li>
                    
                    <li><a href="#">Fax: 88-02-9225006756</a></li>
                </ul>
            </div>
            <div class="col-sm-4">
                <ul>
                    <h4>Important link</h4>

                    <li><a class="selected" href="https://www.research-paper.org.bd " target="_blank">research-paper</a></li>
                    <li><a href="https://www.research-paper.org.bd/publication.php" target="_blank">research-paper Publication</a></li>

                    <li><a href="https://ssl2.cabells.com" target="_blank">Cabell Directory</a></li>
                    <li><a href="http://www.arc.gov.au/excellence-research-australia" target="_blank">ERA</a></li>
                      <li><a href="http://www.abdc.edu.au/pages/abdc-journal-quality-list-2013.html" target="_blank">ABDC Journal Quality List</a></li>
                    <!--                        <li>  <a href="http://www.freecounterstat.com" target="_Blank" title="free counter"></a><br/></li>-->
                </ul>
            </div>
            <div class="col-sm-4">
                <div class="fb-page" data-href="https://www.facebook.com/research-paperbd/" data-tabs="timeline" data-width="290" data-height="220" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                    <div class="fb-xfbml-parse-ignore">
                        <blockquote cite="https://www.facebook.com/research-paperbd/"><a href="https://www.facebook.com/research-paperbd/">Bank Prikrama</a></blockquote>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <p class="text-center">© 2017 Bangladesh Institute of Bank Management | 

Design &amp; Developed By <a target="_blank" href="https://zarss.com">ZARSS Solutions Limited</a></p>
            </div>


        </div>
    </div>
</section>


<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.slicknav.min.js"></script>
<script src="js/main.js"></script>
<script src="fancybox/jquery.fancybox.js"></script>
<script src="fancybox/jquery.fancybox.pack.js"></script>
<script src="fancybox/fancybox_init.js"></script>
<script src="jr_admin/jquery-ui/jquery-ui.min.js"></script>
<script>
    $(function () {
        var pgurl = window.location.href.substr(window.location.href
            .lastIndexOf("/") + 1);
        $("#nav ul li a").each(function () {
            if ($(this).attr("href") == pgurl || $(this).attr("href") == '')
                $(this).addClass("active");
        })
    });
</script>
<script>
    $(function () {
        var pgurl = window.location.href.substr(window.location.href
            .lastIndexOf("/") + 1);
        $(".menu ul li a").each(function () {
            if ($(this).attr("href") == pgurl || $(this).attr("href") == '')
                $(this).addClass("active2");
        })
    });
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-97559960-1', 'auto');
  ga('send', 'pageview');

</script>

<script>
    $( ".datepicker" ).datepicker({
        dateFormat: "dd-mm-yy"
    });
</script>



</body>

</html>