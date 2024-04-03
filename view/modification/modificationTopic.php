<?php
    $topic = $result["data"]['topic']; 
?>

<h1>Modifier un topic</h1>
<form action="index.php?ctrl=topic&action=modifierTopic&id=<?= $topic->getId()?>" method="post">
    
    <!-- TOPIC -->
    <label for="titre">Titre : </label>
    <input type="text" name="titre" value="<?= $topic->getTitre(); ?>" placeholder="Entrez le nom du titre ici" >
    <input type="submit" name="submit" value="Modifier">

</form>

