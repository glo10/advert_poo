<?php
    namespace Advert_poo\Process;
    use Advert_poo\Classes\User;
    use Advert_poo\Classes\FilterException;

    require_once '../classes/User.php';

    if(
        isset($_POST['email'])  &&
        !empty($_POST['email']) &&
        isset($_POST['pswd'])    &&
        !empty($_POST['pswd'])
    )
    {
        array_map('htmlspecialchars', $_POST);
        $email = $_POST['email'];
        $mdp = $_POST['pswd'];

        try
        {
          $user = new User($email,null,null,$mdp,null);
          if($user = $user->connect())
          {
            if(session_id() == '' || !isset($_SESSION))
            {
                session_start();
                $_SESSION['firstName'] = $user->getFirstName();
                $_SESSION['lasttName'] = $user->getLastName();
                $_SESSION['email'] = $user->getEmail();
            }
            echo 'connexion';
          }
          else{
            echo 'La combinaison de l\'email et du mot de passe n\'est pas correcte';
          }
        }
        catch (FilterException $e) {
          echo $e->showError();
        }
    }
    else
    {
        echo 'Les données sont incomplètes, Veuillez recommencer';
    }
