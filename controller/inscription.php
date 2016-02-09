<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

$errors = array();
$isFormGood = true;

if(!empty($_POST))
{
    if(!isset($_POST['username']) || strlen($_POST['username']) < 4)
    {
        $errors['username'] = 'Saisissez un pseudo superieur à 3 caracteres<br>';
        $isFormGood = false;
    }

    if(!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
        $errors['email'] = 'Saisissez un email valide';
        $isFormGood = false;
    }

    if(!isset($_POST['password']) || strlen($_POST['password']) < 6)
    {
        $errors['password'] = 'Saisissez un mdp superieur à 5 caracteres<br>';
        $isFormGood = false;
    }

    if(!isset($_POST['verifPassword']) || $_POST['verifPassword'] !== $_POST['password'])
    {
        $errors['verifPassword'] = 'Saisissez une vérif identique au mdp<br>';
        $isFormGood = false;
    }

    /*if($formOK == true) {
        $success = 'Salut ' . $_POST['username'];
        $secret = "F2fl/6'tg;do";

        $salt = "48@!alsd";
        $password = $_POST['password'];
        $passwordCrypte = sha1(sha1($password) . $salt); // cryptage du password

        echo $passwordCrypte;
    }*/
    if(!$isFormGood)
    {
        http_response_code(400);
        echo(json_encode(array('success'=>false, "errors"=>$errors)));
    }
    else
    {
        //$_POST['password'] = sha1($_POST['password']);

        $salt = "48@!alsd";
        $password = $_POST['password'];
        $_POST['password'] = sha1(sha1($password) . $salt); // cryptage du password

        unset($_POST['verifPassword']);
        echo(json_encode(array('success'=>true, "user"=>$_POST)));
    }
}
else
{
    http_response_code(400);
    echo(json_encode(array('success'=>false, "errors"=>array('Missing form data'))));
}