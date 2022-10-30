<!-- branche -->
 <?php 
 require_once "BddConnect.php";
$active = 1;
$nInstallId = 0;
$nClientId = 0;
$nNoPageCourante = 1;
/* paramètres permanents */
if(isset($_GET['nopage']))
{
  $nNoPageCourante = $_GET['nopage'];
}

if(isset($GLOBALS['_install_id']))
{

   $nInstallId = $GLOBALS['_install_id'];
}
if(isset($GLOBALS['_client_id']))
{
   $nClientId = $GLOBALS['_client_id'];
}

if(isset($_GET['install_id']))
{
   $GLOBALS['_install_id'] = $_GET['install_id'];
   $nInstallId = $_GET['install_id'];
}
if(isset($_GET['client_id']))
{
   $nClientId = $_GET['client_id'];
}

$sSqlWhere = "where client_id=?";  
if($nInstallId >0){
  $sSqlWhere .= " and install_id=? ";  
}

/* paramètres de recherche */
if(isset($_GET['hall_name'])&& ($_GET['hall_name'] !=''))
{
  $_param = '%'.$_GET['hall_name'].'%'; 
  $sSqlWhere .= " and hall_name like ?";     
}
else
if(isset($_GET['branch_id'])&& ($_GET['branch_id'] !=''))
{
  $_param = $_GET['branch_id'];  
  $sSqlWhere .= " and branch_id = ?";  
}
else 
if(isset($_GET['hall_active']) && ($_GET['hall_active']<2))
{  
  $_param = $_GET['hall_active'];
  $sSqlWhere .= " and hall_active = ?  ";   
}
//compter le nombre de salles filtrés

$sSql = "SELECT count(1) as nb FROM api_clients_halls ".$sSqlWhere;

$stmt = $GLOBALS["_bdd"]->prepare($sSql);
$nParam=0;
$stmt->bindParam(++$nParam,$nClientId);
if ($nInstallId>0) {
  $stmt->bindParam(++$nParam,$nInstallId);
}  
if (isset($_param)) {
  $stmt->bindParam(++$nParam,$_param);
}

$stmt->execute();
$res = $stmt->fetchAll();
foreach ($res as $row ) {
    $nNbClients= $row["nb"];    
}
$nNbClientsParPage = 6;
$nNbPages = (int)($nNbClients / $nNbClientsParPage);
$nReste = $nNbClients % $nNbClientsParPage;
if ($nReste >0) {
   $nNbPages++;
}
$nNoEnregFin = $nNbClientsParPage * $nNoPageCourante;
$nNoEnregDebut = $nNoEnregFin - $nNbClientsParPage+1;

// Récupérer les clients filtrés
$sSql = "select * from 
(
  SELECT *,ROW_NUMBER() OVER(ORDER BY hall_name) NumLg from api_clients_halls ".$sSqlWhere."
) tb_pagination
WHERE NumLg BETWEEN ".$nNoEnregDebut." AND ".$nNoEnregFin;
$stmt = $GLOBALS["_bdd"]->prepare($sSql);
$nParam = 0;
$stmt->bindParam(++$nParam,$nClientId);
if ($nInstallId>0) {
  $stmt->bindParam(++$nParam,$nInstallId);
} 
if (isset($_param))
   {
    $stmt->bindParam(++$nParam,$_param);
   }
$stmt->execute();
$res = $stmt->fetchAll();
foreach ( $res as $row ) {
  $btn_show_perm = "btn_show_perm".$row["branch_id"];
  $btn_hide_perm = "btn_hide_perm".$row["branch_id"];
  $div_branch_id = "branch".$row["branch_id"];
  $fBtnShowPerm = "fnBtnShow('".$btn_show_perm."','".$btn_hide_perm."','".$div_branch_id."')";
  $fBtnHidePerm = "fnBtnHide('".$btn_show_perm."','".$btn_hide_perm."','".$div_branch_id."')";

  $nClientId =$row["client_id"];
  $nBranchId = $row["branch_id"];  
  $sHallName = $row["hall_name"];
?>
<div class="branch">

  <div class="branche">

    <div class="image">
      <img src="img/logo.jpg" style="width:50%" 
      <?php 
      if($nInstallId > 0){
        ?>
        onclick="jsClientHallOpen('<?=$nInstallId?>','<?=$nClientId?>','<?=$nBranchId?>')" 
        <?php
        }
        ?>
        />
    </div>
      <div class="elements" >
        <div class="iteme">
          <div>
            <h4>Nom de la salle : <strong><?= $row["hall_name"]?></strong></h4>
          </div>
          <div>
            <h4>Numéro de salle : <strong><?= $row["branch_id"]?></strong></h4>
          </div>
      </div>
    </div>
  </div>

  
  <!-- Droits des branch -->
  
  <div class="look">
   
      <label class="switch">
      <input type="checkbox" <?php echo ($row["hall_active"] == 1?"checked":"")?> <?php echo ($nInstallId == 0?"disabled":"")?>         
       onclick="JsClientHallActiverDesactiver('<?=$nInstallId?>','<?=$nClientId?>','<?=$nBranchId?>','<?=$sHallName?>',this)"       
      />
      <span></span>
    </label> 
    
  <div class="btn_show_hide">
    <button class="btn_show_perm" type="button" name="button"  id="<?php echo $btn_show_perm?>" 
    onclick="<?php echo $fBtnShowPerm?>">
      +
    </button>

    <button class="btn_hide_perm" type="button" name="button" id="<?php echo $btn_hide_perm?>"  
    onclick="<?php echo $fBtnHidePerm?>">
      -
    </button>
  </div>
  </div>

  <div class="perms" id="<?php echo $div_branch_id?>">
    <div class="item">
      <label class="btn_switch">
        <input type="checkbox" <?php echo ($row["drink_dispenser"]== 1?"checked":"") ?> <?php echo ($nInstallId == 0?"disabled":"")?>  
         onclick="JsClientHallPermActiverDesactiver('<?=$nInstallId?>','<?=$nClientId?>','<?=$nBranchId?>','drink_dispenser','distributeur de boisson',this)"/>
        <span></span>
      </label>
      <p>Distributeur de boisson</p>
    </div>

    <div class="item">
      <label class="btn_switch">
        <input type="checkbox" <?php echo ($row["sports_coach"] == 1?"checked":"") ?> <?php echo ($nInstallId == 0?"disabled":"")?> 
       onclick="JsClientHallPermActiverDesactiver('<?=$nInstallId?>','<?=$nClientId?>','<?=$nBranchId?>','sports_coach','Coach sportif',this)"/>
      <span></span>
    </label>
      <p>Coach sportif</p>
    </div>

    <div class="item">
      <label class="btn_switch">
        <input type="checkbox" <?php echo ($row["customer_portal"]== 1?"checked":"") ?> <?php echo ($nInstallId == 0?"disabled":"")?> 
        onclick="JsClientHallPermActiverDesactiver('<?=$nInstallId?>','<?=$nClientId?>','<?=$nBranchId?>','customer_portal','portail client',this)"/>
      <span></span>
    </label>
      <p>Portail client</p>
    </div>

    <div class="item">
      <label class="btn_switch">
        <input type="checkbox" <?php echo ($row["entrance_turnstile"]== 1?"checked":"") ?> <?php echo ($nInstallId == 0?"disabled":"")?> 
        onclick="JsClientHallPermActiverDesactiver('<?=$nInstallId?>','<?=$nClientId?>','<?=$nBranchId?>','entrance_turnstile','tourniquet d\'entrée',this)"/>
      <span></span>
    </label>
      <p>Tourniquet d'entrée</p>
    </div>

    <div class="item">
      <label class="btn_switch">
       <input type="checkbox" <?php echo ($row["discovery_pack"]== 1?"checked":"")?> <?php echo ($nInstallId == 0?"disabled":"")?> 
       onclick="JsClientHallPermActiverDesactiver('<?=$nInstallId?>','<?=$nClientId?>','<?=$nBranchId?>','discovery_pack','pack de découverte',this)"/>
      <span></span>
    </label>
     <p>Pack de découverte</p>
    </div>

    <div class="item">
      <label class="btn_switch">
       <input type="checkbox" <?php echo ($row["email_service"]== 1?"checked":"")?> <?php echo ($nInstallId == 0?"disabled":"")?> 
       onclick="JsClientHallPermActiverDesactiver('<?=$nInstallId?>','<?=$nClientId?>','<?=$nBranchId?>','email_service','service emailing',this)"/>
      <span></span>
    </label>
     <p>Service emailing</p>
    </div>

    <div class="item">
      <label class="btn_switch">
       <input type="checkbox" <?php echo ($row["air_conditioned_cloakroom"]== 1?"checked":"")?> <?php echo ($nInstallId == 0?"disabled":"")?> 
       onclick="JsClientHallPermActiverDesactiver('<?=$nInstallId?>','<?=$nClientId?>','<?=$nBranchId?>','air_conditioned_cloakroom','vestiaire climatisé',this)"/>
      <span></span>
    </label>
     <p>Vestiaire climatisé</p>
    </div>

    <div class="item">
      <label class="btn_switch">
        <input type="checkbox" <?php echo ($row["cleaning_staff"]== 1?"checked":"")?> <?php echo ($nInstallId == 0?"disabled":"")?> 
        onclick="JsClientHallPermActiverDesactiver('<?=$nInstallId?>','<?=$nClientId?>','<?=$nBranchId?>','cleaning_staff','personnel de ménage',this)"/>
      <span></span>
    </label>
      <p>Personnel de ménage</p>
    </div>
    <div class="item">
      <label class="btn_switch">
        <input type="checkbox" <?php echo ($row["indoor_tv"]== 1?"checked":"")?> <?php echo ($nInstallId == 0?"disabled":"")?> 
        onclick="JsClientHallPermActiverDesactiver('<?=$nInstallId?>','<?=$nClientId?>','<?=$nBranchId?>','indoor_tv','télévision en salle',this)"/>
      <span></span>
    </label>
      <p>Télévision en salle</p>
    </div>
    <div class="item">
      <label class="btn_switch">
        <input type="checkbox" <?php echo ($row["sale_of_protein_bar"]== 1?"checked":"")?> <?php echo ($nInstallId == 0?"disabled":"")?> 
        onclick="JsClientHallPermActiverDesactiver('<?=$nInstallId?>','<?=$nClientId?>','<?=$nBranchId?>','sale_of_protein_bar','vente de barre protéinée',this)"/>
      <span></span>
    </label>
      <p>Vente de barre protéinée</p>
    </div>
    
  </div> 
  
</div>
<?php   
};
?>
<div class="onglets">
  <?php    
    for ($nNoPage=1; $nNoPage<=$nNbPages; $nNoPage++) {
      $sActive = "";
      if ($nNoPageCourante == $nNoPage)
        $sActive = "active";         
    ?>
    <button class="onglet <?=$sActive ?>"  onclick="JsClientHallChangerPage(<?=$nInstallId?>,<?=$nClientId?>,<?=$nNoPage ?>)">
    <?php echo $nNoPage ?>
    </button>
    <?php       
    };
  ?>
 <!--  <div id="NbPages">
    <p>N0 page courant : <?=$nNoPageCourante ?><p>
    </div>
  <div id="NbPages">
    <p>Nombre total de clients : <?php echo $nNbPages ?> <p>
    </div>
  <div id="NbClients">
    <p>Nombre total de clients : <?php echo $nNbClients ?> <p>
    </div> -->
</div>

 <!-- Droits des branch -->
<!-- branche -->
  






