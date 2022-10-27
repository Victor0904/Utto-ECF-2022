<?php  
 require_once "BddConnect.php";  
  function PhpVerifLoginInstall($psLogin, $psPassWord)
  {
      $GLOBALS['_install_id'] = 0;
      $GLOBALS['_client_id'] = 0;
      $GLOBALS['_branch_id'] = 0;
      /* utiliser "?" pour éviter les injections SQL */
      $stmt = $GLOBALS["_bdd"]->prepare("SELECT * 
                            FROM api_install 
                            WHERE install_login = ?");
      $stmt->bindParam(1,$psLogin);
      $stmt->execute();
      $res = $stmt->fetchAll();
      foreach ( $res as $row ) {
        if (password_verify($psPassWord, $row["install_pwd"]))
        {
          $GLOBALS['_install_id'] = $row["install_id"]; 
        }
      }

      return  ($GLOBALS['_install_id'] !=0 );
  }
  function PhpVerifLoginClient($psLogin, $psPassWord)
  {
      $GLOBALS['_install_id'] = 0;
      $GLOBALS['_client_id'] = 0;
      $GLOBALS['_branch_id'] = 0;
      $stmt = $GLOBALS["_bdd"]->prepare("SELECT * 
                            FROM api_clients
                            WHERE client_login = ?                       
                            and client_active = 1");
      $stmt->bindParam(1,$psLogin);
      $stmt->execute();
      $res = $stmt->fetchAll();
      foreach ( $res as $row ) {
        if (password_verify($psPassWord, $row["client_pwd"]))
        {
          $GLOBALS['_client_id'] = $row["client_id"]; 
        }
      }

      return  ($GLOBALS['_client_id'] !=0 );
  }
  function PhpVerifLoginHall($psLogin, $psPassWord)
  {
      $GLOBALS['_install_id'] = 0;
      $GLOBALS['_client_id'] = 0;
      $GLOBALS['_branch_id'] = 0;
      $stmt = $GLOBALS["_bdd"]->prepare("SELECT * 
                            FROM api_clients_halls
                            WHERE hall_login = ?");
      $stmt->bindParam(1,$psLogin);
      $stmt->execute();
      $res = $stmt->fetchAll();
      foreach ( $res as $row ) {
        if (password_verify($psPassWord, $row["hall_pwd"]))
        {
          $GLOBALS['_install_id'] = $row["install_id"];
          $GLOBALS['_client_id'] = $row["client_id"];
          $GLOBALS['_branch_id'] = $row["branch_id"];
        }
      }

      return  ($GLOBALS['_branch_id'] !=0 );
  }
  function PhpVerifLogin ($psLogin, $psPassWord){   
    $GLOBALS['_page_ref'] = "clients";
    $return = PhpVerifLoginInstall($psLogin, $psPassWord);
    if(!$return){
      $GLOBALS['_page_ref'] = "client";
      $return = PhpVerifLoginClient($psLogin, $psPassWord);
      if(!$return){
        $GLOBALS['_page_ref'] = "hall";
        $return = PhpVerifLoginHall($psLogin, $psPassWord); 
        if(!$return){
          $GLOBALS['_page_ref'] = "";
        } 
      } 
    }
    return($return);
  }

  function PhpClientHallInsertUpdate($bInsertUpdate
                                      ,$pnClientId
                                      ,$pnInstallId
                                      ,$pnBranchId
                                      ,$psHallName
                                      ,$psHallLogin             
                                      ,$psHallPwd               
                                      ,$pnHallActive            
                                      ,$pnDrinkDispenser        
                                      ,$pnSportsCoach           
                                      ,$pnCustomerPortal        
                                      ,$pnEntranceTurnstile     
                                      ,$pnDiscoveryPack         
                                      ,$pnEmailService          
                                      ,$pnAirConditionedCloakrom
                                      ,$pnCleaningStaff         
                                      ,$pnIndoorTv              
                                      ,$pnSaleOfProteinBar      
                                  )
{ 
   
   $GLOBALS['_install_id'] = $pnInstallId; 

   if ($bInsertUpdate==true)
   {
    $sSql= "insert api_clients_halls
         (hall_name  
          ,hall_login 
          ,hall_pwd 
          ,hall_active 
          ,drink_dispenser 
          ,sports_coach 
          ,customer_portal 
          ,entrance_turnstile 
          ,discovery_pack 
          ,email_service 
          ,air_conditioned_cloakroom 
          ,cleaning_staff
          ,indoor_tv 
          ,sale_of_protein_bar
          ,client_id
          ,install_id
          ,branch_id
          )
       values(?,?,?,?,?
             ,?,?,?,?,?
             ,?,?,?,?,?
             ,?,?)";      
   }
   else
   {
    $sSql= "update api_clients_halls
      set hall_name = ? 
          ,hall_active = ?
          ,drink_dispenser = ?
          ,sports_coach = ?
          ,customer_portal = ?
          ,entrance_turnstile = ?
          ,discovery_pack = ?
          ,email_service = ?
          ,air_conditioned_cloakroom = ?
          ,cleaning_staff = ?
          ,indoor_tv = ?
          ,sale_of_protein_bar = ?
          where client_id = ?
            and install_id = ?
            and branch_id = ?";
   }
    $stmt = $GLOBALS["_bdd"]->prepare($sSql);   
    $nParam = 1;
    $stmt->bindParam($nParam++,$psHallName); 
    if ($bInsertUpdate)
    {
      $stmt->bindParam($nParam++,$psHallLogin);             
      $stmt->bindParam($nParam++,$psHallPwd);                
    }
    $stmt->bindParam($nParam++,$pnHallActive);             
    $stmt->bindParam($nParam++,$pnDrinkDispenser);         
    $stmt->bindParam($nParam++,$pnSportsCoach);           
    $stmt->bindParam($nParam++,$pnCustomerPortal);         
    $stmt->bindParam($nParam++,$pnEntranceTurnstile);     
    $stmt->bindParam($nParam++,$pnDiscoveryPack);          
    $stmt->bindParam($nParam++,$pnEmailService);           
    $stmt->bindParam($nParam++,$pnAirConditionedCloakrom); 
    $stmt->bindParam($nParam++,$pnCleaningStaff);          
    $stmt->bindParam($nParam++,$pnIndoorTv);               
    $stmt->bindParam($nParam++,$pnSaleOfProteinBar); 
    $stmt->bindParam($nParam++,$pnClientId); 
    $stmt->bindParam($nParam++,$pnInstallId); 
    $stmt->bindParam($nParam++,$pnBranchId);   
    $retour = $stmt->execute();
    // $retour   : 1 if inserted. 2 if the row has been updated.
    return ($retour >0);
}