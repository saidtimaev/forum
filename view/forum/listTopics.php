<?php
    $categorie = $result["data"]['categorie']; 
    $topics = $result["data"]['topics']; 
?>

<h1>Liste des topics</h1>

<?php
foreach($topics as $topic ){ ?>
    <p><a href="#"><?= $topic ?></a> par <?= $topic->getUtilisateur() ?></p>
<?php }
