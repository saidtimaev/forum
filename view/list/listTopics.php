<?php
    $categorie = $result["data"]['categorie']; 
    $topics = $result["data"]['topics']; 
?>

<h1>Liste des topics</h1>

<?php
foreach($topics as $topic ){ ?>
    <p><a href="index.php?ctrl=post&action=listPostsByTopics&id=<?= $topic->getId() ?>"><?= $topic ?></a> par <?= $topic->getUtilisateur() ?></p>
<?php } ?>

<a href="index.php?ctrl=topic&action=ajouterTopicAffichage">Nouveau topic</a>
