<?php
    $topic = $result["data"]['topic']; 
    $posts = $result["data"]['posts']; 
?>

<h1>Liste des posts</h1>

<?php
foreach($posts as $post ){ ?>
    <p>"<?= $post ?>" par <a href="#"><?= $post->getUtilisateur() ?></a> le <?= $post->getDateCreation() ?></p>
<?php }