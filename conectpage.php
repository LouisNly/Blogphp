<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="conect.css" rel="stylesheet">
</head>

<?php

require_once 'bddconect.php';
//partie ou on compare les données de la bdd a ceux que l'utilisateur a entrer

    if(isset($_POST['email']) && isset($_POST['password']))
    {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        $check = $bdd ->('SELECT pseudo, email, password FROM users WHERE email = ?');
        $check ->execute(array($email));
        $data = $check->fetch();
        $row = $check->rowCount();

        if($row == 1 )
        {
            if (filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $password = hash('sha256', $password);
                if ($data['password'] == $password)
                {
                    $_SESSION['user'] = $data['pseudo'];
                }else header('location:index.php?login_err=pasword');
            }else header('location:index.php?login_err=email');
        }else header('location:index.php?login_err=already');
    }else header('location:index.php');
?>

<body>
<div class="login-page">
    <div class="form">
        <form class="login-form">
            <input type="text" placeholder="pseudo"/>
            <input type="password" placeholder="password"/>
            <button>login</button>
            <p class="message">Pas enregistrer <a href="createpage.php">Créer un compte</a></p>
        </form>
    </div>
</div>
</body>
</html>