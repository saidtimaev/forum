<?php
    $topic = $result["data"]['topic']; 
    $posts = $result["data"]['posts']??[]; 
?>

<h1><?= $topic->getTitre() ?></h1>
<h2>Posts : </h2>

<?php
foreach($posts as $post ){ ?>
    <p>"<?= $post ?>" par <a href="#"><?= $post->getUtilisateur()?></a> le <?= $post->getDateCreation() ?> 
    <!-- Si l'utilisateur est un ADMIN ou que c'est le l'auteur du post et qu'il n'est pas ban -->
    <?php if(App\Session::getUser() && $post->getUtilisateur() && App\Session::getUser()->isBanned()==0 && App\Session::getUser()->getId()== $post->getUtilisateur()->getId() || App\Session::isAdmin()){?><a href="index.php?ctrl=post&action=modifierPost&id=<?=$post->getId()?>">Modifier</a> </p><?php } ?>
    
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


