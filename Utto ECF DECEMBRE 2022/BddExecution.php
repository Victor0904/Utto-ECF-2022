<?php 
require_once "BddConnect.php";

if(isset($_GET['install_id']))
    $GLOBALS['_install_id'] = $_GET['install_id'];

if(isset($_GET['client_id']))
  $nClientId = $_GET['client_id'];

if(isset($_GET['branch_id']))
  $nBranchId = $_GET['branch_id'];

if(isset($_GET['perm_name']))
  $sPermName = $_GET['perm_name'];  

if(isset($_GET['perm_lib']))
  $sPermLib = $_GET['perm_lib'];

if(isset($_GET['action']))
{
  $nAction = $_GET['action'];
 echo $nClientId;
  if ($nAction == 1) 
  {
    $stmt = $GLOBALS["_bdd"]->prepare("update api_clients set client_active = 1-client_active where client_id = ?");   
    $stmt->bindParam(1,$nClientId);  
    $stmt->execute();
    // echo "c'est ok";
  }  
  if ($nAction == 2) 
  {   
    $stmt = $GLOBALS["_bdd"]->prepare("update api_clients_halls set hall_active = 1-hall_active where client_id = ? and branch_id = ? and install_id = ?");   
    $stmt->bindParam(1,$nClientId); 
    $stmt->bindParam(2,$nBranchId);  
    $stmt->bindParam(3,$GLOBALS['_install_id']); 
    $stmt->execute();
  } 
  if ($nAction == 3) 
  {
    //echo $nClientId." ".$nBranchId." ".$GLOBALS['_install_id']." ".$sPermName;
    $sSql = "update api_clients_halls set ".$sPermName." = 1-".$sPermName." where client_id = ? and branch_id = ? and install_id = ?";
    $stmt = $GLOBALS["_bdd"]->prepare($sSql);   
    $stmt->bindParam(1,$nClientId); 
    $stmt->bindParam(2,$nBranchId);  
    $stmt->bindParam(3,$GLOBALS['_install_id']); 
    $stmt->execute();

    $sSql = "select  c.technical_contact
                    ,i.install_email
                    ,".$sPermName." as champ_modif
                    ,h.hall_name  
                    ,i.install_name
             from api_clients_halls as h
             inner join api_clients as c on c.client_id= h.client_id 
             inner join api_install as i on i.install_id = h.install_id
             where h.client_id = ? and h.branch_id = ? and h.install_id = ?";
    $stmt = $GLOBALS["_bdd"]->prepare($sSql);   
    $stmt->bindParam(1,$nClientId); 
    $stmt->bindParam(2,$nBranchId); 
    $stmt->bindParam(3,$GLOBALS['_install_id']); 
    $stmt->execute();
    $res = $stmt->fetchAll();
    foreach ( $res as $row ) {
        if($row["champ_modif"]==1)   
        $sDroit = "activé ".$sPermLib ;
        else 
        $sDroit = "désactivé ".$sPermLib;

        $sTo      =  $row["technical_contact"] ;
        $sSubject = 'Modification des permissions';
        $sMessage = "Bonjour, "."\r\n" 
                    ."  Nous avons ".$sDroit." de la salle ".$row["hall_name"]."."."\r\n" 
                    ." Sportivement, l'équipe ".$row["install_name"]."." ;
        $sHeaders = "From: ".$row["install_email"]."\r\n" .
                    "Reply-To: ".$row["install_email"]."\r\n" .
                    'X-Mailer: PHP/' . phpversion();
        try {
          
          mail($sTo, $sSubject, $sMessage, $sHeaders);

        } catch (Exception $e) {
          
          echo 'Exception reçue : ',  $e->getMessage(), "\n";
        }                
      } 
  }
}
?>