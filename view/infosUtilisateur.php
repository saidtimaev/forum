<?php
    $posts = $result["data"]['posts'] ?? []; 
    $utilisateur = $result["data"]['utilisateur']
?>

<h1><?= $utilisateur->getPseudonyme()?></h2>
<p>
    <a href="index.php?ctrl=security&action=bannirUtilisateur&id=<?=$utilisateur->getId()?>">
        <!-- On affiche ban ou unban selon le statut de l'utilisateur -->
        <?= ($utilisateur->isBanned()==1) ? "Unban" : "Ban"  ?>
    </a>
</p>
<p><span>Pseudo : </span><?= $utilisateur->getPseudonyme()?></p>
<p><span>Rôle : </span><?= ($utilisateur->getRole() == "ROLE_USER") ? "Utilisateur" : "Admin"?></p>
<p><span>Email : </span><?= $utilisateur->getMail()?></p>
<p><span>Date d'inscription : </span><?= $utilisateur->getDateInscription()->format('Y-m-d')?></p>
<br>
<h2>Liste des posts de <?= $utilisateur->getPseudonyme()?> :</h1>

<?php
foreach($posts as $post){ ?>
    <p>"<?= $post->getTexte() ?>" dans <a href="#"><?= $post->getTopic()?> </a> <a href="#">(<?= $post->getTopic()->getCategorie()->getNom()?>)</a></p>
<?php } ?>



  
