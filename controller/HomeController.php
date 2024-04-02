<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UtilisateurManager;

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
}
