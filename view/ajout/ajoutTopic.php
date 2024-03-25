

<h1>Créer un nouveau topic</h1>
<form action="index.php?ctrl=topic&action=ajouterTopic" method="post">
    <label for="titre">Titre : </label>
    <input type="text" name="titre" value="" placeholder="Entrez le nom du titre ici">
    <input type="hidden" name="categorie_id" value="<?= $id?>" > 
    <input type="text" name="utilisateur_id" value="1" >  


    <label for="texte">Message : </label>
    <input type="text" name="texte" value="" placeholder="Entrez le message ici">
    <input type="submit" name="submit" value="Publier">
</form>