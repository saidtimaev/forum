<?php
    $categorie = $result["data"]['categorie']; 
    $topics = $result["data"]['topics']??[]; 
    $id = $_GET["id"];
?>

<h1>Liste des topics de la catégorie <?= $categorie->getNom() ?></h1>

<?php
foreach($topics as $topic ){ ?>
    <p><a href="index.php?ctrl=post&action=listPostsByTopic&id=<?= $topic->getId() ?>"><?= $topic ?></a> par <?= $topic->getUtilisateur() ?> <a href="index.php?ctrl=topic&action=modifierTopic&id=<?=  $topic->getId()?>">Modifier</a> <a href="index.php?ctrl=topic&action=supprimerTopic&id=<?=  $topic->getId()?>">Supprimer</a></p>
<?php } ?>

<a href="index.php?ctrl=topic&action=ajouterTopicAffichage&id=<?= $id?>">Nouveau topic</a>
