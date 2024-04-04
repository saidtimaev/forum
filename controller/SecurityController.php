<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UtilisateurManager;

class SecurityController extends AbstractController implements ControllerInterface{
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

                        $this->redirectTo("security","login");

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

        
        if(isset($_POST["submit"])) {

            if(($pseudonymeOuEmail != "") && ($password1 != "")){

                $user = $managerUtilisateur->findUtilisateur($pseudonymeOuEmail, $pseudonymeOuEmail);

                if($user){

                    $hash = $user->getMotDePasse();

                    if(password_verify($password1, $hash)){

                        $_SESSION["user"] = $user;
                        
                        $session->addFlash("success","Authentification reussie!");

                    } else {
                        $session->addFlash("error","Champs renseignés incorrects");
                    }

                } else {
                    $session->addFlash("error","Champs renseignés incorrects");
                }

            } else {
                $session->addFlash("error","Veuillez renseigner tous les champs!");
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

        $session = new Session();

        unset($_SESSION["user"]);

        $session->addFlash("success","Vous êtes déconnecté!");

        $this->redirectTo("security","login");

    }

    public function profile(){

        return [
            "view" => VIEW_DIR."profil.php",
            "meta_description" => "Profil",
            "data" => [ 
               
            ]
            ];
    }

    public function modifierUtilisateur($id) {

        // var_dump($_POST);

        $managerUtilisateur = new UtilisateurManager();
        $session = new Session();

        $utilisateur = $managerUtilisateur->findOneById($id);

        // var_dump($utilisateur);die;

        
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
                    
                ];
    
                $users = $managerUtilisateur->findUtilisateur($pseudonyme, $email);
    
    
                if($users){
    
                   
                    if($password1 == $password2){
    
                        $managerUtilisateur->update($data,$id);

                        $utilisateur = $managerUtilisateur->findOneById($id);

                        $_SESSION["user"] = $utilisateur;

                        $session->addFlash("success","Modification reussie");

                        $this->redirectTo("security","modifierUtilisateur",$id);

                    } else {
    
                        $session->addFlash("error","Les mots de passe ne sont pas identiques!");

                    }
                }
            }
        }
        
        return [
            "view" => VIEW_DIR."modification/modificationUtilisateur.php",
            "meta_description" => "Modification infos",
            "data" => [ 
               "utilisateur"=>$utilisateur
            ]
            ];
        
    }
}