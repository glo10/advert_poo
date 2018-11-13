<?php
    session_start();
    if(isset($_SESSION['email'])){
        header('location:accueil.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'inc/css.inc.php' ?>
    <title>Inscription</title>
</head>
<body>
    <main class="container">
        <form action="process/processSignUp.php" class="form-horizontal" method="POST">

            <div class="form-group">
                <input type="email" name="email" class="form-control col-4" placeholder="Saisir votre email">
            </div>

            <div class="form-group">
                <input type="password" name="mdp" class="form-control col-4" placeholder="Saisir votre mot de passe">
            </div>

            <div class="form-group">
                <input type="password" name="mdpConfirm" class="form-control col-4" placeholder="Confirmer le mot de passe">
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-success col-2" value="Inscription" >
            </div>

        </form>
    </main>
</body>
</html>
