<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UtilisateurManager;

class SecurityController extends AbstractController{
    // contiendra les méthodes liées à l'authentification : register, login et logout

    public function register() {

        // var_dump($_POST);

        $managerUtilisateur = new UtilisateurManager();
        $session = new Session();

        
        if(isset($_POST["submit"])) {

            $pseudonyme = filter_input(INPUT_POST, "pseudonyme", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $password1 = filter_input(INPUT_POST, "password1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password2 = filter_input(INPUT_POST, "password2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if(($pseudonyme || $email || $password1 || $password2) != ""){

                $data = [
                    "pseudonyme" => $pseudonyme,
                    "mail" => $email,
                    "motDePasse" => password_hash($password1,PASSWORD_DEFAULT),
                    "role"=> "ROLE_USER"
                ];
    
                $users = $managerUtilisateur->findUtilisateur($pseudonyme, $email);
    
    
                if($users){
    
                    $session->addFlash("error","Pseudonyme ou email déjà utilisé!");
    
                } else {
    
                    if($password1 == $password2){
    
                        $managerUtilisateur->add($data);

                        $session->addFlash("success","Inscription reussie");

                        self::redirectTo("security","login");

                    } else {
    
                        $session->addFlash("error","Les mots de passe ne sont pas identiques!");

                    }
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
    public function login () {

        $pseudonymeOuEmail = filter_input(INPUT_POST, "pseudonymeOuEmail", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password1 = filter_input(INPUT_POST, "password1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $managerUtilisateur = new UtilisateurManager();
        $session = new Session();

        
        if(isset($_POST["submit"]) && ($pseudonymeOuEmail != "") && ($password1 != "")) {

            $user = $managerUtilisateur->findUtilisateur($pseudonymeOuEmail, $pseudonymeOuEmail);

            if($user){

                $hash = $user->getMotDePasse();
                // var_dump($user);
                if(password_verify($password1, $hash)){

                    $_SESSION["user"] = $user;
                    // var_dump($_SESSION);
                } else {
                    self::redirectTo("security","login");
                    // Message flash "Mot de passe incorrect, veuillez renouveler votre saisie"
                }

            } else {
                self::redirectTo("security","login");
                // Message flash "utilisateur n'existe pas, créez un compte"
            }
            
        }
        
        
        
        
        return [
            "view" => VIEW_DIR."login.php",
            "meta_description" => "Connexion",
            "data" => [ 
               
            ]
            ];
    }
    public function logout () {

        unset($_SESSION["user"]);
        // var_dump($_SESSION);
        self::redirectTo("home","index");

    }

    public function profile(){

        return [
            "view" => VIEW_DIR."profil.php",
            "meta_description" => "Profil",
            "data" => [ 
               
            ]
            ];
    }
}