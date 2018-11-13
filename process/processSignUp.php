<?php
    if(
        isset($_POST['lastName'])   &&
        !empty($_POST['lastName'])  &&
        isset($_POST['firstName'])  &&
        !empty($_POST['firstName']) &&
        isset($_POST['email'])      &&
        !empty($_POST['email'])     &&
        isset($_POST['pswd'])       &&
        !empty($_POST['pswd'])
    ){
        array_map('htmlspecialchars', $_POST);
        require_once '../classes/User.php';
        $user = new User($_POST['email'],$_POST['pswd']);
        $user->setLastName($_POST['lastName']);
        $user->setFirstName($_POST['firstName']);

        if($user->save())
        {
          if(session_id() == '' || !isset($_SESSION))
          {
              session_start();
              $_SESSION['firstName'] = $user->getFirstName();
              $_SESSION['lasttName'] = $user->getLastName();
              $_SESSION['email'] = $user->getEmail();
          }
            echo 'inscription';
        }
        else
        {
          echo 'Inscription échouée, veuillez recommencer';
        }

    }
    else
    {
        echo 'Les données saisis sont incorrectes.';
    }
