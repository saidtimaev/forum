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

            $this->redirectTo("topic","listTopicsByCategory",$idCategorie);

        } else {

            $session->addFlash("error","Veuillez saisir un nom de catégorie!");

            $this->redirectTo("categorie","ajouterCategorieAffichage");

        }
    }

    public function modifierCategorie($id) {

        $categorieManager = new CategorieManager();
        $session = new Session();
        
        $categorie = $categorieManager->findOneById($id);
       
        $nom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Si l'utilisateur souhaitant modifier la catégorie est un admin
        if(Session::isAdmin()){

            if(isset($_POST["submit"])) {

                // Si le champ "nom" du formulaire n'est pas vide
                if($nom != ""){
                    $data = [
                        "nom" => str_replace("'","\'",$nom)
                    ];
        
                    $categorieManager->update($data,$id);
        
                    $session->addFlash("success","Catégorie modifiée!");
    
                    $this->redirectTo("categorie","index");
    
                } else {
    
                    $session->addFlash("error","Veuillez saisir un nom de catégorie!");
    
                }
            }
    
            return [
                "view" => VIEW_DIR."modification/modificationCategorie.php",
                "meta_description" => "Modification de catégorie",
                "data" => [
                "categorie"=>$categorie
                ]
            ];

        // Si l'utilisateur souhaitant modifier la catégorie n'est pas un admin
        } else {

            $session->addFlash("error","Vous n'avez pas les autorisations nécessaires pour effectuer cette action!");
            
            $this->redirectTo("home","index");

        }
    }

    public function supprimerCategorie($id) {

            $categorieManager = new CategorieManager();
            $session = new Session();

        // Si l'utilisateur qui veut supprimer une categorie est un admin
        if(Session::isAdmin()){

            $categorieManager->delete($id);

            $session->addFlash("success","Catégorie supprimée avec succès!");

            $this->redirectTo("categorie","index");


        // Si l'utilisateur qui veut supprimer une categorie n'est pas un admin
        } else {

            $session->addFlash("error","Vous n'avez pas les autorisations nécessaires pour effectuer cette action!");

            $this->redirectTo("categorie","index");

        }
    }
}