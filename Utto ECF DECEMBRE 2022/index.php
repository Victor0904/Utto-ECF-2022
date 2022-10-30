<?php 
  require_once "php_utiles.php";

  $titre = "API SALLE DE SPORT";
  $page_ref = "login";
  if(isset($_POST['page_ref']))
  {
    if($_POST['page_ref'] == "login_install")
    {
        if (PhpVerifLogin($_POST['login'], $_POST['password']))
        {
            $page_ref = $GLOBALS['_page_ref'];
        }
        else
        if ($GLOBALS['_install_id'] == 0 ) {
            $_message_erreur = "Login ou mot de passe incorrect";  
        }  
    }
    if(($_POST['page_ref'] == "client_hall_new")
      or ($_POST['page_ref'] == "client_hall_edit"))
    {      
        $sLogin = "";
        $sPwd = "";
        if(isset($_POST['hall_pwd']))
           $sPwd = password_hash($_POST["hall_pwd"], PASSWORD_DEFAULT, ['cost' =>12]); 
        if(isset($_POST['hall_login']))
           $sLogin = $_POST['hall_login']; 

        if (PhpClientHallInsertUpdate(($_POST['page_ref'] == "client_hall_new")
                            ,$_POST["client_id"]
                            ,$_POST["install_id"]
                            ,$_POST["branch_id"]
                            ,$_POST["hall_name"]
                            ,$sLogin
                            ,$sPwd
                            ,(isset($_POST["hall_active"])?1:0)
                            ,(isset($_POST["drink_dispenser"])?1:0)
                            ,(isset($_POST["sports_coach"])?1:0)
                            ,(isset($_POST["customer_portal"])?1:0)
                            ,(isset($_POST["entrance_turnstile"])?1:0)
                            ,(isset($_POST["discovery_pack"])?1:0)
                            ,(isset($_POST["email_service"])?1:0)
                            ,(isset($_POST["air_conditioned_cloakroom"])?1:0)
                            ,(isset($_POST["cleaning_staff"])?1:0)
                            ,(isset($_POST["indoor_tv"])?1:0)
                            ,(isset($_POST["sale_of_protein_bar"])?1:0))
                            )
        {
            $page_ref = "clients";
        }
        else
        if ($GLOBALS['_install_id'] == 0 ) {
            $_message_erreur = "Login ou mot de passe incorrecte";  
        }           
    }    
  }  
    $install_id = 0;
    $client_id = 0;
    if(isset($GLOBALS['_install_id']))
    {
        $install_id = $GLOBALS['_install_id'];
    }
    if(isset($GLOBALS['_client_id']))
    {
        $client_id = $GLOBALS['_client_id'];
    }
?>  
<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="author" content="NoS1gnal"/>            
            <?php 
            if ($page_ref == "clients" || $page_ref == "client" || $page_ref == "hall") {?>
                <link rel="stylesheet" href="css/style.css">
                <link rel="stylesheet" href="css/client_hall.css">               
            <?php
            }
            else {
            ?>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
                <link rel="stylesheet" href="css/login.css"> 
            <?php             
            }
            ?>                       
            <script src="js/js_utiles.js"></script>
            <script src="js/clients.js"></script>
            <script src="js/client_hall.js"></script>
            <script src="js/btn-more.js"></script>
            <script src="js/login_screen.js"></script>
            <title>Utto</title>
        </head>
        <body>     
            <div id="div_principal">       
                <?php 
                if ($page_ref == "clients") 
                {
                include "clients.php";           
                }
                else
                if ($page_ref == "hall") 
                {
                include "client_hall.php";           
                }
                else
                if ($page_ref == "login")
                {
                include "login.php";               
                }
                ?> 
            </div>                 
            <div id="div_test" style="visibility:hidden"> 
                <?=$page_ref?>
            </div>
        </body>   
        <?php         
          if ($page_ref == "client") 
          {
             ?> 
             <script>JsClientChargerUnClient(<?=$install_id?>,<?=$client_id?>);</script>  
             <?php 
          }
        ?>          
</html>
           




