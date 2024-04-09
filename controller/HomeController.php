<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\PostManager;
use Model\Managers\UtilisateurManager;
use App\Session;

class HomeController extends AbstractController implements ControllerInterface {

    public function index(){
        return [
            "view" => VIEW_DIR."home.php",
            "meta_description" => "Page d'accueil du forum"
        ];
    }
        
    public function users(){

        // var_dump('test');die;
        $this->restrictTo("ROLE_ADMIN");

        $manager = new UtilisateurManager();
        $utilisateurs = $manager->findAll(['dateInscription', 'DESC']);

        return [
            "view" => VIEW_DIR."list/listUtilisateurs.php",
            "meta_description" => "Liste des utilisateurs du forum",
            "data" => [ 
                "utilisateurs" => $utilisateurs 
            ]
        ];
    }

    public function infosUtilisateur($id){

        $postManager = new PostManager();
        $utilisateurManager = new UtilisateurManager();
        $session = new Session();

        $posts = $postManager->findPostsByUser($id);
        $utilisateur = $utilisateurManager->findOneById($id);
        

        // var_dump(iterator_to_array($posts));die;

        if(Session::isAdmin()){

            return [
                "view" => VIEW_DIR."infosUtilisateur.php",
                "meta_description" => "Liste des informations d'un utilisateur",
                "data" => [ 
                    "posts" => $posts,
                    "utilisateur"=>$utilisateur
                ]
            ];
        } else {

            $session->addFlash("error","Vous n'avez pas les autorisations nécessaires pour effectuer cette action!");

            $this->redirectTo("categorie","index");

        }
    }
}
