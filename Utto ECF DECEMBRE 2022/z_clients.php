<div class="content">
<?php 
require_once "BddConnect.php";

$sSqlWhere = "";
$active = 1;

$nNoPageCourante = 1;
/* paramètres permanents */
if(isset($_GET['nopage']))
{
  $nNoPageCourante = $_GET['nopage'];
}

if(isset($_GET['install_id']))
{
   $GLOBALS['_install_id'] = $_GET['install_id'];
   $install_id = $_GET['install_id'];
}

/* paramètres de recherche */
if(isset($_GET['client_name'])&& ($_GET['client_name']!=''))
{
    $_param = '%'.$_GET['client_name'].'%'; 
    $sSqlWhere = "where client_name like ?";     
}
else
if(isset($_GET['client_id'])&& ($_GET['client_id']!=''))
{
  $_param = $_GET['client_id'];  
  $sSqlWhere = "where client_id = ?";  
}
else 
if(isset($_GET['client_active']) && ($_GET['client_active']<2))
{
  $_param = $_GET['client_active'];
  $sSqlWhere = "where client_active = ?";    
}

// Compter le nombre de clients filtrés
$sSql = "SELECT count(1) as nb FROM api_clients ".$sSqlWhere;
$stmt = $GLOBALS["_bdd"]->prepare($sSql);
if (isset($_param))
   {
    $stmt->bindParam(1,$_param);
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
  SELECT *,ROW_NUMBER() OVER(ORDER BY client_name) NumLg from api_clients ".$sSqlWhere."
) tb_pagination
WHERE NumLg BETWEEN ".$nNoEnregDebut." AND ".$nNoEnregFin;

$stmt = $GLOBALS["_bdd"]->prepare($sSql);
if (isset($_param))
   {
    $stmt->bindParam(1,$_param);
   }

$stmt->execute();
$res = $stmt->fetchAll();
foreach ( $res as $row ) {
    $client_id = $row["client_id"];
    $client_name = $row["client_name"];
?>

  <div class="card" >
      <div class="container">
        <div class="box-image" >         
          <img src="<?=$row["logo_url"] ?>" onclick="JsClientChargerUnClient('<?=$GLOBALS['_install_id']?>','<?=$client_id ?>')"/>           
        </div>
          <div class="list">
              <ul id="filter" id="filter">
                  <li class="client_id">Numéro de client : <strong><?php echo $row["client_id"] ?> </strong> </li>
                  <li class="client_name">Nom de l'enseigne : <strong> <?php echo $row["client_name"] ?> </strong></li>
                  <li><?php echo $row["short_description"] ?></li>  
                  <li><strong><?php echo $row["url"] ?></strong></li>
              </ul>
          </div>
      </div>
        <label class="switch">
        <input type="checkbox" <?php echo ($row["client_active"] == 1?"checked":"") ?> 
            onclick="JsClientActiverDesactiver('<?php echo $client_id ?>','<?php echo $client_name ?>',this)"/>
        <span></span>
        </label>
  </div>
<?php   
};
?>
</div>
<div class="onglets">
  <?php    
    for ($nNoPage=1; $nNoPage<=$nNbPages; $nNoPage++) {
      $sActive = "";
      if ($nNoPageCourante == $nNoPage)
        $sActive = "active";         
    ?>
    <button class="onglet <?=$sActive ?>"  onclick="JsClientChangerPage(<?=$install_id?>,<?=$nNoPage ?>)">
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

