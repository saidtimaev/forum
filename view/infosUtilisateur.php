<?php
    $posts = $result["data"]['posts']; 
    $utilisateur = $result["data"]['utilisateur']
?>

<h1>Liste des posts de <?= $utilisateur->getPseudonyme()?></h1>

<?php
foreach($posts as $post){ ?>
    <p>"<?= $post->getTexte() ?>" par <?= $post->getUtilisateur()?> dans <?= $post->getTopic()?></p>
<?php } ?>



  
