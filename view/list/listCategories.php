<?php
    $categories = $result["data"]['categories']; 
?>

<h1>Liste des catégories</h1>

<?php
foreach($categories as $categorie ){ ?>
    <p><a href="index.php?ctrl=topic&action=listTopicsByCategory&id=<?= $categorie->getId() ?>"><?= $categorie->getNom() ?></a></p>
    <p><a href="index.php?ctrl=categorie&action=modifierCategorie&id=<?=$categorie->getId()?>">Modifier</a></p>
    <p class="myBtn">X</p>
    <!-- The Modal -->
    <div class="myModal modal">
        <!-- Modal content -->
        <div class="modal-content">
            <p>Etes vous sur de vouloir supprimer la catégorie? Cela va entraîner la suppression de tous les topics avec leur posts!</p>
            <a href="index.php?ctrl=categorie&action=supprimerCategorie&id=<?=$categorie->getId()?>" >Confirmer</a>
            <div class="close">Annuler</div>
        </div>
    </div>
<?php } ?>

<a href="index.php?ctrl=categorie&action=ajouterCategorieAffichage">Nouvelle catégorie</a>


  
