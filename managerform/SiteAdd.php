<?php include("header.php");?>
    <hr class="style_one"/>

      <section id='content'>
        <div class='container'>
         
            <div class='row'>
                <div class='col-sm-12'>
                  <div class='box'>
                    <div class='box-header red-background'>
                      <div class='title'><p>Ajouter un site</p>
                         <a class="btn btn-danger btn-lg" style="float:right;" href="SiteList.php" title="Retour au tableau des sites">Retour au tableau</a>
                          <hr class="style_two"/>
                         
                      </div>
                    </div>
                    <div class='box-content'>
                     <form class="form" style="margin-bottom: 0;" method="post" action="SiteEdit.php" accept-charset="UTF-8">

                     
                         <div class='form-group'>
                        <label for='client'>Client </label> 
                             <select class="form-control" name="customer_id">
                                <option value="0" selected="selected">Choisir</option>
                                <?php
                                
                                  $req2=mysqli_query($connect,"SELECT * FROM CUSTOMER");
                                  while($data2=$req2->fetch_assoc()){
                                     $idClient=$data2["CUSTOMER_ID"];
                                      $clientName=$data2["NAME"];

                                      echo "<option value=\"".$idClient."\"";
                                      echo ">".$clientName."</option>";
                                    }
                                 
                        
                                ?>
                              </select>
                        </div>
                     
                       
                      <div class='form-group'>
                        <label for='site_name'>Nom du site  </label>
                        <input class='form-control' id='site_name' name='site_name' type='text'>
                      </div>

                      <div class='form-group'>
                        <label for='desc_site'>Description  </label>
                        <input class='form-control' id='desc_site'  name='desc_site' type='text'>
                      </div>
                      
  
             
                 
                      <div class="form-group">
                        <label for="user_input_autocomplete_address">Tapez une adresse </label>
                          <input class="form-control" id="user_input_autocomplete_address" name="user_input_autocomplete_address" placeholder="Votre adresse...">
                       <hr class="style_two"/>
                     </div>
             

             
                <div class='col-sm-2'>
                  <div class='form-group'>
                      <label for='street_number'>Numéro de voie</label>
                      <input class="form-control" id="street_number" name="street_number" type="text" >
                    </div>
                  </div>
                <div class='col-sm-10'>
                  <div class='form-group'>
                      <label for='route'>Voie</label>
                      <input class="form-control" id="route" name="route" type="text" >
                  </div>
                </div>
                <hr class="style_one">
             
                    <div class='form-group'>
                      <label for='locality'>Ville</label>
                      <input class="form-control" id="locality" name="locality" type="text" >
                    </div>

                    <div class='form-group'>
                       <label for='administrative_area_level_1'>Province</label>
                       <input class="form-control" id="administrative_area_level_1" name="administrative_area_level_1" readonly>
                    </div>
                 
                    <div class='form-group'>
                       <label for='postal_code'>Code postal</label>
                       <input class="form-control" id="postal_code" name="postal_code" type="text" >
                    </div>
                 
                    <div class='form-group'>
                       <label for='country'>Pays</label>
                       <input class="form-control" id="country" name="country" type="text" >
                    </div>
                     <div class='form-group'>
                      <label for='lat'>Latitude</label>
                      <input class="form-control" id="lng" name="lng" readonly>
                      <label for='lat'>Longitude</label>
                      <input class="form-control" id="lat" name="lat" readonly>
                   </div>
              
       
                  <div class="form-actions form-actions-padding-sm form-actions-padding-md form-actions-padding-lg" >
                     <div class="col-sm-10"> </div>
                      <div class="col-sm-2">
                          <input style="float:right;" type="submit" id="addSite" name="addSite" value="Enregistrer" class="btn btn-danger btn-lg">
                      </div>
                    <hr class="style_two"/>
                  </div>  
                  </div>
              
                 </form>
              
                   
                  </div>
                </div>
              </div>
            </div>
          </div>
        
        </div>
      </section>
    </div>
	
	
	



<script type="text/javascript">
function initializeAutocomplete(id) {
  var element = document.getElementById(id);
  if (element) {
    var autocomplete = new google.maps.places.Autocomplete(element, { types: ['geocode'] });
    google.maps.event.addListener(autocomplete, 'place_changed', onPlaceChanged);
  }
}
function onPlaceChanged() {
  var place = this.getPlace();
  document.getElementById('lat').value = place.geometry.location.lat();
  document.getElementById('lng').value  = place.geometry.location.lng();

  // console.log(place);  // Uncomment this line to view the full object returned by Google API.
   
  for (var i in place.address_components) {
    var component = place.address_components[i];
    
    for (var j in component.types) {  // Some types are ["country", "political"]
       var type_element = document.getElementById(component.types[j]);

      if (type_element) {
        if(type_element==administrative_area_level_1){
          type_element.value = component.short_name;
        }else{
          type_element.value = component.long_name;

        }

      }
    }
  }
}

google.maps.event.addDomListener(window, 'load', function() {
  initializeAutocomplete('user_input_autocomplete_address');
 
});

</script>
    </body>
</html>