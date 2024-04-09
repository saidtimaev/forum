<?php
    $categorie = $result["data"]['categorie']; 
    $topics = $result["data"]['topics']??[]; 
    $id = $_GET["id"];
?>

<h1>Liste des topics de la catégorie <?= $categorie->getNom() ?></h1>

<?php
foreach($topics as $topic ){ ?>
    <p>
        <a href="index.php?ctrl=post&action=listPostsByTopic&id=<?= $topic->getId() ?>"><?= $topic ?></a> par <?= $topic->getUtilisateur() ?> 
        <!-- Si c'est un admin ou l'utilisateur qui a crée le topic -->
        <?php if(App\Session::isAdmin() || App\Session::getUser() && App\Session::getUser()->getId()==$topic->getUtilisateur()->getId()){ ?>
            <!-- Modification -->
            <a href="index.php?ctrl=topic&action=modifierTopic&id=<?=  $topic->getId()?>">Modifier</a> 
        <?php } ?>
        <!-- Si c'est un admin -->
        <?php if(App\Session::isAdmin()){ ?>
            <!-- Verrouiller -->
            <a href="index.php?ctrl=topic&action=verrouillerTopic&id=<?=  $topic->getId()?>"><?= ($topic->getVerrouillage()==1) ? "Déverrouiller" : "Verrouiller"  ?></a>
            <!-- Supprimer -->
            <a href="index.php?ctrl=topic&action=supprimerTopic&id=<?=  $topic->getId()?>">Supprimer</a>
        <?php } ?>
    </p>
<?php } ?>

<!-- Si l'utilisateur n'est pas ban -->
<?php if(App\Session::getUser() && !App\Session::getUser()->isBanned()==1){ ?>
    <!-- Ajouter un topic -->
    <a href="index.php?ctrl=topic&action=ajouterTopicAffichage&id=<?= $id?>">Nouveau topic</a>
<?php } ?>


