<?php
    $utilisateurs = $result["data"]['utilisateurs']; 
?>

<h1>Liste des utilisateurs</h1>

<?php
foreach($utilisateurs as $utilisateur){ ?>
    <p><a href="index.php?index.php?ctrl=home&action=infosUtilisateur&id=<?= $utilisateur->getId() ?>"><?= $utilisateur->getPseudonyme() ?></a></p>
<?php } ?>



  
