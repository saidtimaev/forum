<?php
    $post = $result["data"]['post']; 
?>

<h1>Modifier un post</h1>
<form action="index.php?ctrl=post&action=modifierPost&id=<?=$post->getId()?>" method="post">
    <!-- POST -->
    <label for="texte">Message : </label>
    <input type="text" name="texte" value="<?=$post->getTexte()?>" placeholder="Entrez le message ici" size="50">
    <input type="hidden" name="topic_id" value="<?=$post->getTopic()->getId()?>">
    <input type="submit" name="submit" value="Modifier">
</form>