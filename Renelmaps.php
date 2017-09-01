 <?php 
include("header.php");
?>

  
    
<!--<div id="page1" style="display:none;" >

<div class="iframe-responsive-wrapper1">
     <img class="iframe-ratio1" src="data:image/gif;base64,R0lGODlhEAAJAIAAAP///wAAACH5BAEAAAAALAAAAAAQAAkAAAIKhI+py+0Po5yUFQA7"/>
<center><iframe src="Manager.php" width="1400" height="1500" align="middle"></iframe>  </center>
</div>
</div> -->



		
<div class="iframe-responsive-wrapper"  id="menu">
     <img class="iframe-ratio" src="data:image/gif;base64,R0lGODlhEAAJAIAAAP///wAAACH5BAEAAAAALAAAAAAQAAkAAAIKhI+py+0Po5yUFQA7"/>
<center><iframe src="renelmap/" frameborder="0" width="1400" height="1500" align="middle"></iframe>  </center>
</div>

				

            
        
        <script src="js/vendor/jquery-1.11.0.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
        <script src="js/bootstrap.js"></script>
        <script src="js/plugins.js"></script>
      

        <script type="text/javascript"> 
function afficher_div(image) 
{ 
switch(image){ 
case 'url1': 
document.getElementById("menu").style.display="none"; 
document.getElementById("page1").style.display="block";

break; 


} 
} 

</script> 
	 <script type="text/javascript">
       
$('iframe').css({
     'width': $(window).width(),
     'height': $(window).height()
});
 
$(window).resize(function(){
$('iframe').css({
     'width': $(window).width(),
     'height': $(window).height()
});
});
</script>
    </body>
</html>