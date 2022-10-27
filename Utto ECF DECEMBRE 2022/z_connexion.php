
<?php require_once "BddConnect.php"; 
$GLOBALS['_install_id'] = 0;
/* utiliser "?" pour éviter les injections SQL */
$stmt = $GLOBALS["_bdd"]->prepare("SELECT * 
                      FROM api_install 
                      WHERE install_login = ?                       
                      AND install_pwd = ?");
$stmt->bindParam(1,$_POST['login']);
$stmt->bindParam(2,$_POST['password']);
$stmt->execute();
$res = $stmt->fetchAll();
foreach ( $res as $row ) {
   $GLOBALS['_install_id'] = $row["install_id"]; 
}
?>
<!-- <body>
<div>
<p>Login : <?php echo htmlspecialchars($_POST['login']); ?>.</p>
<p>Password : <?php echo $_POST['password']; ?> </p>
<p>Install_id : <?php echo $GLOBALS['_install_id'] ; ?> </p>
</div>
</body> -->
<?php
if ($GLOBALS['_install_id'] != 0 ) 
{
  include "clients.php";
   /* header('Location: clients.php');  */
  
}
else
{
  $_message_erreur = "Login ou mot de passe incorrecte";
   include "index.php";  
   /* header('Location: index.php');  */
}

?>
