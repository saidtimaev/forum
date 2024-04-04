<?php
    $posts = $result["data"]['posts']; 
    $utilisateur = $result["data"]['utilisateur']
?>

<h1>Informations :</h2>
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



  
