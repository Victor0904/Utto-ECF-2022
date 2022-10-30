  <?php 
    $install_id = 0;
    if(isset($GLOBALS['_install_id']))
    {
      $install_id = $GLOBALS['_install_id'];
    }
    if(isset($_GET["install_id"]))
    {
      $GLOBALS['_install_id']=$_GET["install_id"];
      $install_id = $_GET["install_id"];
    }
   
  ?>   
  <div class="box-retour">
    <a class="btn-retour-a"style=" text-decoration:none;" href="index.php"> 
      <div class="clients-retour" >
        <img class="revenir" src="img/revenir.png"> 
        <p>Déconnexion</p>
      </div> 
    </a>
  </div>
  <div class="search">
    <div class="select">
      <input name="client_name" id="client_name"  type="text"  
            placeholder="Entrer un nom de client " 
            onkeyup="JsClientSearchClientName(<?=$install_id?>,this.value,1)"
      >
      <input name="client_id" id="client_id" type="number"
            placeholder="Entrer un numéro de client"
            onkeyup="JsClientSearchClientId(<?=$install_id?>,this.value,1)"
      >
    </div> 
    <div class="activeOrNot">
      <button class="actif" id="active"
        onclick="JsClientSearchClientActive(<?=$install_id?>,1,1)">
        Actif
      </button>
      <button  class="nonActif" id="nonActive"
        onclick="JsClientSearchClientActive(<?=$install_id?>,0,1)">
        Non actif
      </button>
      <!-- faire css -->
      <button class="actif" 
        onclick="JsClientSearchClientActive(<?=$install_id?>,2,1)">
        Toutes
      </button>
    
       <!-- faire css -->
    </div>
  </div>
  <div id="contenu">          
  </div>
  
  <div id="div_invisible" style="visibility:hidden"> 
    <input id="noFiltre"  type="text" value="0"/>
  </div> 
  <div id="div_erreur" style="visibility:hidden"> 
      <?=$install_id?>
  </div>   
  <script>     
  JsClientSearch(<?=$install_id?>,1);
  </script>
