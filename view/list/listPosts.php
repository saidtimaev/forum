<?php
    $topic = $result["data"]['topic']; 
    $posts = $result["data"]['posts']??[]; 
?>

<h1><?= $topic->getTitre() ?></h1>
<h2>Posts : </h2>

<?php
foreach($posts as $post ){ ?>
    <p>"<?= $post ?>" par <a href="#"><?= $post->getUtilisateur()?></a> le <?= $post->getDateCreation() ?> <a href="index.php?ctrl=post&action=modifierPost&id=<?=$post->getId()?>">Modifier</a> <a href="index.php?ctrl=post&action=supprimerPost&id=<?=$post->getId()?>">Supprimer</a></p>
<?php } ?>

<form action="index.php?ctrl=post&action=ajouterPost" method="post">
    <label for="texte">Message : </label>
    <input type="text" name="texte" value="" placeholder="Entrez le message ici" required>
    <input type="hidden" name="topic_id" value="<?= $id?>" > 
    <input type="submit" name="submit" value="Publier">
</form>

