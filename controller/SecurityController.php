<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UtilisateurManager;

class SecurityController extends AbstractController{
    // contiendra les méthodes liées à l'authentification : register, login et logout

    public function register() {

        // var_dump($_POST);

        $managerUtilisateur = new UtilisateurManager();
        
        if(isset($_POST["submit"])) {

            $pseudonyme = filter_input(INPUT_POST, "pseudonyme", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $password1 = filter_input(INPUT_POST, "password1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password2 = filter_input(INPUT_POST, "password2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // var_dump("test");

            $data = [
                "pseudonyme" => $pseudonyme,
                "mail" => $email,
                "motDePasse" => password_hash($password1,PASSWORD_DEFAULT)
            ];

            $users = $managerUtilisateur->findUtilisateur($pseudonyme, $email);


            if($users){

                var_dump("L'utilisateur existe déjà!");

            } else {

                if($password1 == $password2){

                    $managerUtilisateur->add($data);
                } else {

                    var_dump("Les mots de passe ne sont pas identiques!");
                }

            }
            
        }
        
        
        
        
        return [
            "view" => VIEW_DIR."inscription.php",
            "meta_description" => "Inscription",
            "data" => [ 
               
            ]
            ];
        
    }
    public function login () {}
    public function logout () {}
}