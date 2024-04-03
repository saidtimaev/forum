<?php
    $categorie = $result["data"]['categorie']; 
?>

<h1>Modifier</h1>
<form action="index.php?ctrl=categorie&action=modifierCategorie" method="post">
    <label for="titre">Nom : </label>
    <input type="text" name="nom" value="" placeholder="Entrez le nom de la catégorie ici" required>
    <input type="submit" name="submit" value="Modifier">
</form>