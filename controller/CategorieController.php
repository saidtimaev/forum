<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategorieManager;

class CategorieController extends AbstractController implements ControllerInterface{

    public function index() {
        
        // créer une nouvelle instance de CategoryManager
        $categorieManager = new CategorieManager();
        // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
        $categories = $categorieManager->findAll(["nom", "DESC"]);

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [
            "view" => VIEW_DIR."list/listCategories.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [
                "categories" => $categories
            ]
        ];
    }


    public function ajouterCategorieAffichage() {


        return [
            "view" => VIEW_DIR."ajout/ajoutCategorie.php",
            "meta_description" => "Ajout de catégorie",
            "data" => [
                
            ]
        ];
    }

    public function ajouterCategorie() {

        $categorieManager = new CategorieManager();
        $session = new Session();

        $nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(isset($_POST["submit"]) && ($nom != "")) {

            $data = [
                "nom" => str_replace("'","\'",$nom)
            ];


            $idCategorie = $categorieManager->add($data);

            $session->addFlash("success","Catégorie ajoutée");

            self::redirectTo("topic","listTopicsByCategory",$idCategorie);

        } else {

            $session->addFlash("error","Veuillez saisir un nom de catégorie!");

            self::redirectTo("categorie","ajouterCategorieAffichage");


        }

        

    }


}