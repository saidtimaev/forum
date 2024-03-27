

<h1><?= $_SESSION["user"]?></h1>

<h2>Informations :</h2>

<p><span>Pseudo : </span><?= $_SESSION["user"]->getPseudonyme()?></p>
<p><span>Rôle : </span><?= ($_SESSION["user"]->getRole() == "ROLE_USER") ? "Utilisateur" : "Rôle non défini"?></p>
<p><span>Email : </span><?= $_SESSION["user"]->getMail()?></p>
<p><span>Date d'inscription : </span><?= $_SESSION["user"]->getDateInscription()->format('Y-m-d')?></p>
