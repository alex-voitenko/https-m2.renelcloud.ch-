
   
      <?php  include("header.php");?>
    
       <hr class="style_one"/>
      <section id='content'>
        <div class='container'>
                <div class='col-sm-12'>
                  <div class='box'>
                    <div class='box-header red-background'>
                       <div class='title'><p>Clients : ajouter</p>
                          <a class="btn btn-danger btn-lg" style="float:right;" href="CustomerList.php" title="Retour au tableau des clients">Retour au tableau des clients</a>
                          <hr class="style_two"/>
                      </div>
                      </div>
                    <div class='box-content'>
                       <?php
                       if(!empty($message)){
                         echo "<div class=\"col-sm-12\" id=\"afficheMessage\" style=\"display:block;\">";
                         echo "<p>".$message;
                         echo "</p></div>";
                       }
                        
                         ?>
                   

                    
                     <form class="form" style="margin-bottom: 0;" method="post" action="CustomerEdit.php" enctype="multipart/form-data" >

                      <div class='form-group'>
                        <label for='name_cus'>Nom</label>
                        <?php
                             echo  "<input class=\"form-control\" id=\"name_cus\" name=\"name_cus\" placeholder=\"Nom\" type=\"text\">";
                          
                        ?>
                       
                      </div>
					          <div class='form-group'>
                        <label for="desc_cus">Description</label>
                        <?php
                        
                          echo  "<input class=\"form-control\" id=\"desc_cus\" name=\"desc_cus\" placeholder=\"Description\" type=\"text\">";
                       
                        ?>
                      </div>

					          <div class='form-group'>
                        <label for='tel_cus'>Tel. Bureau</label>
                        <?php
                        
                          echo  "<input class=\"form-control\" id=\"tel_cus\" name=\"tel_cus\" placeholder=\"Tel. Bureau\" type=\"text\">";
                     
                        ?>
                      </div>
					           <div class='form-group'>
                        <label for='contact_cus'>Contact</label>
                         <?php
                        
                          echo  "<input class=\"form-control\" id=\"contact_cus\" name=\"contact_cus\" placeholder=\"Contact\" type=\"text\">";
                      
                        ?>
                      </div>
					           <div class='form-group'>
                        <label for='mob_cus'>Tel. Mobile</label>
                         <?php
                        
                          echo  "<input class=\"form-control\" id=\"mob_cus\" name=\"mob_cus\" placeholder=\"Tel. Mobile\" type=\"text\">";
                       
                        ?>
                      </div>
					           <div class='form-group'>
                        <label for='mail_cus'>Email</label>
                         <?php
                        
                          echo  "<input class=\"form-control\" id=\"mail_cus\" name=\"mail_cus\" placeholder=\"Email\" type=\"text\">";
                        
                        ?>
                      </div>
					           <div class='form-group'>
                        <label for='url_cus'>Site Web</label>
                         <?php
                        
                          echo  "<input class=\"form-control\" id=\"url_cus\" name=\"url_cus\" placeholder=\"http://\" type=\"text\">";
                      
                        ?>
                      </div>	

					   <div class='form-actions form-actions-padding-sm form-actions-padding-md form-actions-padding-lg' style='margin-bottom: 0;'>
						
						  <div class='row' >

                      <div class='col-sm-10'>
                      </div>

                       <div class='col-sm-2' >
                          <input type="submit" id="addCustomer" name="addCustomer" value="AJOUTER" class='btn btn-danger btn-lg'>
                      </div>
                      </div>

                     

                      </form>
              
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        
        </div>
      </section>
    </div>

  </body>


</html>
