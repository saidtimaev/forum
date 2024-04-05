
<h1>Suppression de compte</h1>
<p>Cette action est irreversible, en cliquant sur le bouton "Supprimer mon compte" vous allez perdre tout votre historique de topics et posts sur ce forum</p>
<form action="index.php?ctrl=security&action=supprimerUtilisateur&id=<?= $_SESSION['user']->getId()?>" method="post">

    <label for="password1">Mot de passe : </label>
    <input type="password" name="password1" id="password1" ></br>

    <input type="submit" name="submit" value="Supprimer mon compte"></br>

</form>