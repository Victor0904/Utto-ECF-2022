<!--Bouton retour à l'index-->
<?php 
 require_once "BddConnect.php";
 $nInstallId = 0;
 $nClientId = 0;
 if(isset($GLOBALS['_install_id']))
  {
    $nInstallId = $GLOBALS['_install_id'];
  }
  if(isset($GLOBALS["_client_id"]))
  {
    $nClientId =$GLOBALS["_client_id"];
  }
 if(isset($_GET["install_id"]))
  {
    $GLOBALS['_install_id']=$_GET["install_id"];
    $nInstallId = $GLOBALS['_install_id'];
  }
  if(isset($_GET["client_id"]))
  {
    $nClientId =$_GET["client_id"];
  }
  if($nInstallId >0){
?>
<div>  
    <button class="retour" onclick="JsClientChargerClients('<?= $nInstallId ?>')">
      <img class="revenir" src="img/revenir.png"> 
    <p>Liste des partenaires </p>
    </button>  
</div>
<?php
}else {
  ?>
  <div> 
    <a style=" text-decoration:none;" href="index.php"> 
    <button class="retour" >
      <img class="revenir" src="img/revenir.png"> 
    <p>Déconnexion </p>
    </button> 
    </a> 
</div>
<?php
}
?>
<!--box principale du client  -->
<div class="all">
<?php 
$active = 1;
$s_logo_url = "";
$stmt = $GLOBALS["_bdd"]->prepare("SELECT * FROM api_clients where client_id = ?");
$stmt->bindParam(1,$nClientId);  
$stmt->execute();
$res = $stmt->fetchAll();
foreach ( $res as $row ) {
  $nClientId = $row["client_id"];
  $sClientName = $row["client_name"];
  $s_logo_url = $row["logo_url"];
?>
  <div class="border">
    <div class="client">
      <div class="image_client">
        <img id="cl-image"src="<?php echo $row["logo_url"] ?>" style="width:100%">
      </div>
      <div class="elements" id="cole">
        <div class="iteme">
          <div>
            <h4> Numéro de client : <?php  echo $row["client_id"]?></h4>
          </div>
          <div>
            <h4><?php echo $row["full_description"] ?></h4>
          </div>
          <div>
            <h4>Site web : <?php echo $row["url"] ?></h4>
          </div>
          <div>
            <h4>Nom du gérant : <?php echo $row["dpo"] ?></h4>
          </div>
          <div>
            <h4> Email technique : <?php echo $row["technical_contact"] ?></h4>
          </div>
          <div>
            <h4>Email commercial : <?php echo $row["commercial_contact"] ?></h4>
          </div>
        </div>
      </div>
    </div>
    
    <label class="switch">
      <input type="checkbox" <?php echo ($row["client_active"] == 1?"checked":"")?> <?php echo ($nInstallId == 0?"disabled":"")?>
        onclick="JsClientActiverDesactiver('<?=$nClientId?>','<?=$sClientName?>',this)"/>
      <span></span>
    </label>
  </div>
<?php   
};
?>
</div> 
<!--box principale du client  -->
 
<!--Add-->
 <div class="boxAll">
    <div class="boxGauche">
        <div class="boxGaucheHaut">
            <div class="boxSearch">
                <input class="cl-search" name="hall_name" id="hall_name"  type="text"   placeholder="Nom de salle" 
                onkeyup="JsClientHallSearchHallName('<?= $nInstallId ?>','<?=$nClientId ?>',this.value,1)">
            </div>
            <div class="boxSearch">
                <input class="cl-search" name="branch_id" id="branch_id"  type="text"   placeholder="Numéro de salle" onkeyup="JsClientHallSearchBranchId('<?= $nInstallId ?>','<?=$nClientId ?>',this.value,1)">
            </div>
        </div> 
        <div class="boxGaucheBas">
            <div class="boxBtnActive">
                <button class="cl-actif" onclick="JsClientHallSearchHallActive(<?=$nInstallId?>,<?=$nClientId ?>,1,1)" >actif</button>
            </div>
            <div class="boxBtnNonActive">
                <button  class="cl-nonActif" onclick="JsClientHallSearchHallActive(<?=$nInstallId?>,<?=$nClientId ?>,0,1)" >non actif</button>
            </div>
        </div>
    </div> 
     <div class="boxDroite">
        <div class="boxDroiteHaute"> 
            <button class="cl-toutes" onclick="JsClientHallSearchHallActive(<?=$nInstallId?>,<?=$nClientId ?>,2,1)">Toutes</button>
        </div>
        <?php
        if($nInstallId >0){
          ?>
          <div class="boxDroiteBas">
            <button class="cl-ajouter" 
             onclick="jsClientHallOpen(<?=$nInstallId?>,<?=$nClientId?>,0)"> 
            Ajouter</button>
        </div> 
        <?php
        }
        ?>
         
    </div>
  </div> 
<div id="contenu"> 
</div>
<div id="div_invisible" style="visibility:hidden"> 
    <input id="noFiltre"  type="text" value="0"/>
</div>  
<div id="div_erreur" style="visibility:hidden"> 
</div>   

 