<?php
    $utilisateur = $result["data"]['utilisateur']; 
?>

<h1>Modification utilisateur</h1>
<form action="index.php?ctrl=security&action=modifierUtilisateur&id=<?=$utilisateur->getId()?>" method="post">
    <label for="pseudonyme">Pseudonyme :</label>
    <input type="text" name="pseudonyme" id="pseudo" value="<?=$utilisateur->getPseudonyme()?>"></br>

    <label for="email">Mail :</label>
    <input type="email" name="email" id="email" value="<?=$utilisateur->getMail()?>"></br>

    <label for="password1">Mot de passe : </label>
    <input type="password" name="password1" id="password1" ></br>

    <input type="submit" name="submit" value="Valider modifications"></br>

</form>