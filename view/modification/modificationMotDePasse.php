

<h1>Modification mot de passe</h1>
<form action="index.php?ctrl=security&action=modifierMotDePasse&id=<?=$_SESSION['user']->getId()?>" method="post">
    
    <label for="password1">Ancien mot de passe : </label>
    <input type="password" name="password1" id="password1" ></br>

    <label for="password2">Nouveau mot de passe : </label>
    <input type="password" name="password2" id="password2" ></br>

    <label for="password3">Confirmer nouveau mot de passe : </label>
    <input type="password" name="password3" id="password3" ></br>

    <input type="submit" name="submit" value="Valider"></br>

</form>