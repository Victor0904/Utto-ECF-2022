<!-- <div class="logo">
    <img src="img/logo-utto.png" width="150px">
<div class="title"> <h1>Bienvenue sur UTTO, veuillez vous connecter</h1></div>
</div> -->

<div id="canvas_container">
<div class="login-form">
      <?php                 
        if(isset($_message_erreur))
        {
          ?>
                    <div class="alert alert-danger">
                        <strong>Erreur : </strong><?php echo $_message_erreur?>
                    </div>
            <?php
        }
        ?>  
    <form action="index.php" method="post">
        <h2 class="text-center">Connexion</h2>       
        <div class="form-group">
            <input type="login" name="login" class="form-control" placeholder="Email" required="required" autocomplete="off" > 
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Mot de passe" required="required" autocomplete="off" >
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Connexion</button>
        </div>
        <div>
            <input type="text" name="page_ref" value="login_install" style="visibility:hidden"> 
        </div>   
    </form>
</div>
</div>