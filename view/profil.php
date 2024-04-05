

<h1><?= $_SESSION["user"]?></h1>
<p><a href="index.php?ctrl=security&action=modifierUtilisateur&id=<?=$_SESSION["user"]->getId()?>">Modifier profil</a></p>
<p><a href="index.php?ctrl=security&action=modifierMotDePasse&id=<?=$_SESSION["user"]->getId()?>">Modifier mot de passe</a></p>
<p><a href="index.php?ctrl=security&action=supprimerUtilisateurAffichage&id=<?=$_SESSION["user"]->getId()?>">Supprimer mon profil</a></p>


<h2>Informations :</h2>

<p><span>Pseudo : </span><?= $_SESSION["user"]->getPseudonyme()?></p>
<p><span>Rôle : </span><?= ($_SESSION["user"]->getRole() == "ROLE_USER") ? "Utilisateur" : "Admin"?></p>
<p><span>Email : </span><?= $_SESSION["user"]->getMail()?></p>
<p><span>Date d'inscription : </span><?= $_SESSION["user"]->getDateInscription()->format('Y-m-d')?></p>
