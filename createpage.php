<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page de connexion</title>
    <link href="conect.css" rel="stylesheet">

</head>

<?php

require_once 'bddconect.php';

if(isset($_POST['pseudo']) && isset ($_POST['email']) && isset($_POST['password']) && isset($_POST['password_retry']))
{
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $password_retry = htmlspecialchars($_POST['pasword_retype']);

    $check = $bdd->('SELECT pseudo, email, password FROM users WHERE email = ?');
    $check ->execute(array($email));
    $data = $check->fetch();
    $row = $check->rowCount();

    if ($row == 0)
    {
        if(strlen($pseudo) <= 100)
        {
            if(strlen($email) <= 100)
            {
                if(filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    if($password == $password_retry)
                    {
                        $password = hash('sha256', $password);
                        $ip = $_SERVER['REMOTE_ADDR'];

                        $insert = $bdd -> prepare('INSERTE INTO user(pseudo, email, password, ip) VALUE(:pseudo, :email, :password, :ip');
                        $insert -> execute(array(
                            'pseudo' => $pseudo,
                            'email' => $email,
                            'password' => $password,
                            'ip' => $ip
                        ));
                        header('Location: inscription.php?reg_err=success');
                    }else header('Location: inscription.php?reg_err=password');
                }else header('Location: inscription.php?reg_err=email');
            }else header('Location: inscription.php?reg_err=email_length');
        }else header('Location: inscription.php?reg_err=nom_length');
    }else header('Location: inscription.php?reg_err=already');
}
?>
<body>
<div class="login-page">
    <div class="form">
        <form class="register-form">
            <input type="text" placeholder="name"/>
            <input type="password" placeholder="password"/>
            <input type="text" placeholder="email address"/>
            <button>create</button>
            <p class="message">Already registered? <a href="#">Sign In</a></p>
        </form>
    </div>
</div>
</body>
</html>