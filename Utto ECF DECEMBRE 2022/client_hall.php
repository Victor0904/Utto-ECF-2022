<?php 
 require_once "BddConnect.php";
 $nInstallId = 0;
 $nClientId = 0;
 $nBranchId = 0;
 $bDroitModif = true;
 if(isset($GLOBALS["_install_id"])){
    $nInstallId = $GLOBALS["_install_id"];
    $bDroitModif = false;
 }
 if(isset($GLOBALS["_client_id"]))
    $nClientId = $GLOBALS["_client_id"];
 if(isset($GLOBALS["_branch_id"]))
    $nBranchId = $GLOBALS["_branch_id"];

 if(isset($_GET["install_id"]))
    $nInstallId = $_GET["install_id"];
 if(isset($_GET["client_id"]))
    $nClientId = $_GET["client_id"];
 if(isset($_GET["branch_id"]))
    $nBranchId = $_GET["branch_id"];

  $bNouveau = true;

  $sHallName = "";
  $sHallLogin = "";
  $sHallPwd = "";
  $nHallActive = 1;

  $nDrinkDispenser = 0;
  $nSportsCoach = 0;
  $nCustomerPortal = 0;
  $nEntranceTurnstile = 0;
  $nDiscoveryPack = 0;
  $nEmailService = 0;
  $nAirConditionedCloakroom = 0;
  $nCleaningStaff = 0;
  $nIndoorTv = 0;
  $nSaleOfProteinBar = 0;

  $s_logo_url = "";
  $stmt = $GLOBALS["_bdd"]->prepare("SELECT * FROM api_clients_halls where install_id = ? and client_id = ? and branch_id = ?");
  $stmt->bindParam(1,$nInstallId);  
  $stmt->bindParam(2,$nClientId);  
  $stmt->bindParam(3,$nBranchId);  
  $stmt->execute();
  $res = $stmt->fetchAll();
  foreach ( $res as $row ) {
    $bNouveau  = false;
    $sHallName              = $row["hall_name"];
    $sHallLogin             = $row["hall_login"];
    $sHallPwd               = $row["hall_pwd"];
    $nHallActive            = $row["hall_active"];

    $nDrinkDispenser        = $row["drink_dispenser"];
    $nSportsCoach           = $row["sports_coach"];
    $nCustomerPortal        = $row["customer_portal"];
    $nEntranceTurnstile     = $row["entrance_turnstile"];
    $nDiscoveryPack         = $row["discovery_pack"];
    $nEmailService          = $row["email_service"];
    $nAirConditionedCloakroom = $row["air_conditioned_cloakroom"];
    $nCleaningStaff         = $row["cleaning_staff"];
    $nIndoorTv              = $row["indoor_tv"];
    $nSaleOfProteinBar      = $row["sale_of_protein_bar"];
  }
  if ($bNouveau)
  {
    $stmt = $GLOBALS["_bdd"]->prepare("SELECT max(branch_id) as branch_id FROM api_clients_halls where install_id = ? and client_id = ?");
    $stmt->bindParam(1,$nInstallId);  
    $stmt->bindParam(2,$nClientId);     
    $stmt->execute();
    $res = $stmt->fetchAll();
    foreach ( $res as $row ) {
        if (is_null($row["branch_id"]))
        {
            $nBranchId = 1;
        }
        else 
          $nBranchId = $row["branch_id"] + 1;
    }
  }

?>


<div class="formAll">
<?
if($bDroitModif){
?>
  <form action="index.php" method="post">
<? 
}
?>
  <div class="boxHidden" style="visibility:hidden">
    <div class="box1">
      <p>installId : </p>
      <p class="pleft"><input type="text" name="install_id" readonly value="<?=$nInstallId?> " /></p>
    </div>
  </div>
  

  <div class="box12">
    <div class="box1">
      <p>Numéro de client : </p>
      <p class="pleft"><strong><input type="text" name="client_id" readonly value="<?=$nClientId?>" /> </strong></p>
    </div>
  </div>
  

  <div class="box12">
    <div class="box1">
      <p>Nom de salle :</p>
      <p class="pleft"><input type="text" name="hall_name" value="<?=$sHallName?>" required <?=($bDroitModif?"":"disabled")?>/></p>
    </div>
  </div>
  
  <div class="box12">
    <div class="box1">
      <p>Numéro de salle :</p>
      <p class="pleft"><input type="text" name="branch_id" readonly value="<?=$nBranchId?>" required <?=($bDroitModif?"":"disabled")?>/></p>
    </div>
  </div>
  
    <?php 
    if ($bNouveau) 
    {?>    
      <div class="box12">  
        <div class="box1">
          <p>Créer un login :</p>
          <p class="pleft"><input type="text" name="hall_login" value="<?=$sHallLogin?>" required <?=($bDroitModif?"":"disabled")?>/></p>
        </div>
      </div>
      <div class="box12">
        <div class="box1">
          <p>Créer un mot de passe :</p>
          <p class="pleft"><input type="password" name="hall_pwd" value="<?=$sHallPwd?>" required <?=($bDroitModif?"":"disabled")?>/></p>
        </div>
      </div>
    <?php 
    } else 
    {?>
      <div class="box12">
        <div class="box1">
          <p>login :</p>
          <p class="pleft"><input type="text" name="hall_login" value="<?=$sHallLogin?>" required disabled/></p>
        </div>
      </div>
    <?php 
    }?>
    
  <div class="box12">
    <div class="box1">
      <p class="pActive"><strong>Actif :</strong></p>
      <label class="form_btn_switch">
        <input type="checkbox" name="hall_active" <?=($nHallActive==1?"checked":"")?>
        <?=($bDroitModif?"":"disabled")?>/>
        <span></span>
      </label>
    </div>
  </div>



  <div class="allbox">
    <div class="box12">
      <div class="box1">
        <p>Distributeur de boisson :</p>
        <div class="box1btn">
          <label class="form_btn_switch">
          <input type="checkbox" name="drink_dispenser" <?=($nDrinkDispenser==1?"checked":"")?>
          <?=($bDroitModif?"":"disabled")?>/>
          <span></span>
        </label>
        </div>
        
        </div>

        <div class="separeted"></div>
      
      <div class="box2">
        <p>Coach sportif :</p>
        <div class="box1btn">
          <label class="form_btn_switch">
            <input type="checkbox" name="sports_coach" <?=($nSportsCoach==1?"checked":"")?>
            <?=($bDroitModif?"":"disabled")?>/>
            <span></span>
          </label>
        </div>
    </div>
    </div>

    <div class="box34">
      <div class="box1">
        <p>Portail client :</p>
        <div class="box1btn">
          <label class="form_btn_switch">
            <input type="checkbox" name="customer_portal" <?=($nCustomerPortal==1?"checked":"")?>
            <?=($bDroitModif?"":"disabled")?>/>
            <span></span>
          </label>
        </div>
      </div>

      <div class="separeted"></div>

      <div class="box2">
        <p>Tourniquet d'entrée :</p>
        <div class="box1btn">
          <label class="form_btn_switch">
            <input type="checkbox" name="entrance_turnstile" <?=($nEntranceTurnstile==1?"checked":"")?>
            <?=($bDroitModif?"":"disabled")?>/>
            <span></span>
          </label>
        </div>
      </div>
    </div>

    <div class="box56">
      <div class="box1">
        <p>Pack de découverte :</p>
        <div class="box1btn">
          <label class="form_btn_switch">
          <input type="checkbox" name="discovery_pack" <?=($nDiscoveryPack==1?"checked":"")?>
          <?=($bDroitModif?"":"disabled")?>/>
          <span></span>
        </label>
        </div>
      </div>

      <div class="separeted"></div>

      <div class="box2">
        <p>Service emailing :</p>
        <div class="box1btn">
          <label class="form_btn_switch">
          <input type="checkbox" name="email_service" <?=($nEmailService==1?"checked":"")?>
          <?=($bDroitModif?"":"disabled")?>/>
          <span></span>
        </label>
        </div>
      </div>
    </div>

    <div class="box78">
      <div class="box1">
        <p>Vestiaire climatisé :</p>
        <div class="box1btn">
          <label class="form_btn_switch">
            <input type="checkbox" name="air_conditioned_cloakroom" <?=($nAirConditionedCloakroom==1?"checked":"")?>
            <?=($bDroitModif?"":"disabled")?>/>
            <span></span>
          </label>
        </div>
      </div>

      <div class="separeted"></div>

      <div class="box2">
        <p>Personnel de ménage :</p>
        <div class="box1btn">
          <label class="form_btn_switch">
            <input type="checkbox" name="cleaning_staff" <?=($nCleaningStaff==1?"checked":"")?>
            <?=($bDroitModif?"":"disabled")?>/>
            <span></span>
          </label>
        </div>
      </div>
    </div>

    <div class="box910">
      <div class="box1">
        <p>Télévision en salle :</p>
        <div class="box1btn">
          <label class="form_btn_switch">
            <input type="checkbox" name="indoor_tv" <?=($nIndoorTv==1?"checked":"")?>
            <?=($bDroitModif?"":"disabled")?> />
            <span></span>
          </label>
        </div>
      </div>

      <div class="separeted"></div>

      <div class="box2">
        <p>Vente de barre protéinée :</p>
        <div class="box1btn">
          <label class="form_btn_switch">
            <input type="checkbox" name="sale_of_protein_bar" <?=($nSaleOfProteinBar==1?"checked":"")?>
            <?=($bDroitModif?"":"disabled")?>/>
            <span></span>
          </label>
        </div>
      </div>
    </div>
  </div>

  <?php
  if($bDroitModif){
  ?>
    <div class="form-btn">
      <div class="form-group">
        <button type="submit" class="btn-ok">Valider</button>
      </div>
      <div class="form-group">
        <button class="btn-ok" onclick="JsClientChargerUnClient('<?=$nInstallId?>','<?=$nClientId ?>')">
          Annuler</button>
      </div>
      <div>
        <input type="text" name="page_ref"
        style="visibility:hidden">
      </div>
      <div>
        <input type="text" name="page_ref" value="client_hall_<?=($bNouveau==true?"new":"edit")?>" style="visibility:hidden">
      </div> 
    </div>
</form>
  
<br>
<br>
<?php
}else {
?>

  <a style=" text-decoration:none;" href="index.php">
    <button class="retour">
       <img class="revenir" src="img/revenir.png"> 
      <p>Déconnexion </p>
    </button>
  </a>
<?php
  }
  ?>
</div>