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
    <title>Connexion/Inscription</title>
</head>
<body>
    <div class="container">
        <?php include 'inc/menu.inc.php';?>
        <?php include 'inc/search.inc.php' ?>

        <?php if(isset($_GET['connect']) && intval($_GET['connect']) == -1) :?>
        <div>
          <p class="alert alert-info text-center">Pour ajouter une annonce, veuillez vous connecter ou vous inscrire</p>
        </div>
        <?php endif;?>
        <div id="top">
            <button class="btn btn-default btnSign" data-content="#signIn" data-hide="#signUp">Connexion</button>
            <button class="btn btn-default btnSign" data-content="#signUp" data-hide="#signIn">Inscription</button>
        </div>
        <div>
        <p id="userMsg" class="text-info"></p>
        </div>
        <div id="signIn">
            <h3 class="text-info">Connexion</h3>
            <form data-url="../process/processSignIn.php">
                <div class="form-group">
                    <input type="email" name="email" class="form-control col-4" placeholder="Saisir votre email" required>
                </div>

                <div class="form-group">
                    <input type="password" name="pswd" class="form-control col-4" placeholder="Saisir votre mot de passe" required>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-success col-2" value="connexion" data-action="0">
                </div>
            </form>
        </div>

        <div id="signUp">
            <h3 class="text-info">Inscription</h3>
            <form data-url="../process/processSignUp.php">
                <div class="form-group">
                    <input type="text" name="lastName" class="form-control col-4" placeholder="Saisir votre nom">
                </div>

                <div class="form-group">
                    <input type="text" name="firstName" class="form-control col-4" placeholder="Saisir votre prénom">
                </div>

                <div class="form-group">
                    <input type="email" name="email" class="form-control col-4" placeholder="Saisir votre email">
                </div>

                 <div class="form-group">
                    <input type="password" name="pswd" class="form-control col-4" placeholder="Saisir votre mot de passe">
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-info col-2" value="Inscription"  data-action="1">
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="js/appJquery.js"></script>
</body>
</html>
