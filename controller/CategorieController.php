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


        $data = [];

        foreach($_POST as $key => $value ){

            if($key != "submit"){
                $data[$key] = $value;
                
            }

        }

        // var_dump($data); die;
    
        $categorieManager = new CategorieManager();
        
        $categorieManager->add($data);

        self::redirectTo("categorie","index");

    }


}