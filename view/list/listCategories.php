<?php
    $categories = $result["data"]['categories']; 
?>

<h1>Liste des catégories</h1>

<?php
foreach($categories as $categorie ){ ?>
    <p><a href="index.php?ctrl=topic&action=listTopicsByCategory&id=<?= $categorie->getId() ?>"><?= $categorie->getNom() ?></a></p>
<?php } ?>

<a href="index.php?ctrl=categorie&action=ajouterCategorieAffichage&id=<?= $id?>">Nouvelle catégorie</a>


  
