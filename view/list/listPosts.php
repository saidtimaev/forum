<?php
    $topic = $result["data"]['topic']; 
    $posts = $result["data"]['posts']??[]; 
?>

<h1>Liste des posts</h1>

<?php
foreach($posts as $post ){ ?>
    <p>"<?= $post ?>" par <a href="#"><?= $post->getUtilisateur()?></a> le <?= $post->getDateCreation() ?></p>
<?php } ?>

<form action="index.php?ctrl=post&action=ajouterPost" method="post">
    <label for="texte">Message : </label>
    <input type="text" name="texte" value="" placeholder="Entrez le message ici">
    <input type="hidden" name="topic_id" value="<?= $id?>" > 
    <input type="submit" name="submit" value="Publier">
</form>

