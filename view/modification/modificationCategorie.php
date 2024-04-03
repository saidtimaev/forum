<?php
    $categorie = $result["data"]['categorie']; 
?>

<h1>Modifier</h1>
<form action="index.php?ctrl=categorie&action=modifierCategorie&id=<?= $categorie->getId() ?>" method="post">
    <label for="titre">Nom : </label>
    <input type="text" name="nom" value="<?= $categorie->getNom() ?>" placeholder="Entrez le nom de la catégorie ici" >
    <input type="submit" name="submit" value="Modifier">
</form>