<?php
    $categories = $result["data"]['categories']; 
?>

<h1>Liste des catégories</h1>

<?php
foreach($categories as $categorie ){ ?>
    <p><a href="index.php?ctrl=topic&action=listTopicsByCategory&id=<?= $categorie->getId() ?>"><?= $categorie->getNom() ?></a> <a href="index.php?ctrl=categorie&action=modifierCategorie&id=<?=$categorie->getId()?>">Modifier</a></p>
<?php } ?>

<a href="index.php?ctrl=categorie&action=ajouterCategorieAffichage">Nouvelle catégorie</a>


  
