<?php
    $topic = $result["data"]['topic']; 
    $posts = $result["data"]['posts']??[]; 
?>

<h1><?= $topic->getTitre() ?></h1>
<h2>Posts : </h2>

<?php
foreach($posts as $post ){ ?>

    <p>"<?= $post ?>" par <a href="#"><?= $post->getUtilisateur()?></a> le <?= $post->getDateCreation() ?> 
   
    <!-- Si un utilisateur est connecté, qu'il n'est pas ban et que l'utilisateur qui a crée le post n'est pas "anonyme" ou que c'est un admin -->
    <?php if(App\Session::getUser() && App\Session::getUser()->isBanned()==0  && $post->getUtilisateur() !== "Anonyme" || App\Session::isAdmin()){?><a href="index.php?ctrl=post&action=modifierPost&id=<?=$post->getId()?>">Modifier</a> </p><?php } ?>
   
<?php } ?>

<!-- Si un utilisateur est connecté -->
<?php if(App\Session::getUser()){ ?> 
    <form action="index.php?ctrl=post&action=ajouterPost" method="post">
        <label for="texte">Message : </label>
        <input type="text" name="texte" value="" placeholder="Entrez le message ici" required>
        <input type="hidden" name="topic_id" value="<?= $id?>" > 
        <input type="submit" name="submit" value="Publier">
    </form>
<?php } ?>


