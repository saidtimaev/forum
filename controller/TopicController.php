<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\TopicManager;
use Model\Managers\CategorieManager;
use Model\Managers\PostManager;

class TopicController extends AbstractController implements ControllerInterface{

    public function index() {

    }

    public function listTopicsByCategory($id) {

        $topicManager = new TopicManager();
        $categorieManager = new CategorieManager();
        $categorie = $categorieManager->findOneById($id);
        $topics = $topicManager->findTopicsByCategory($id);

        return [
            "view" => VIEW_DIR."list/listTopics.php",
            "meta_description" => "Liste des topics par catégorie : ".$categorie,
            "data" => [
                "categorie" => $categorie,
                "topics" => $topics
            ]
        ];
    }

    // Affichage de la page d'ajout de topic
    public function ajouterTopicAffichage($id) {

        $session = new Session();
        
        // var_dump($_SESSION['user']->isBanned());die;

        // Si l'utilisateur est ban
        if(Session::getUser()->isBanned()==1){

            $session->addFlash("error","Vous avez été ban, vous ne pouvez pas créer de topic, contactez un admin!");

            $this->redirectTo("topic","listTopicsByCategory",$id);

        }

        return [
            "view" => VIEW_DIR."ajout/ajoutTopic.php",
            "meta_description" => "Ajout de topic",
            "data" => [
                
            ]
        ];
    }

    public function ajouterTopic() {

        $postManager = new PostManager();
        $topicManager = new TopicManager();
        $session = new Session();

        $titre = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $idCategorie = filter_input(INPUT_POST, "categorie_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $texte = filter_input(INPUT_POST, "texte", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(isset($_POST["submit"]) && ($titre != "") && ($texte != "")) {

            $data = [
                "titre" => str_replace("'","\'",$titre),
                "categorie_id" => $idCategorie,
                "utilisateur_id"=> $_SESSION['user']->getId()
            ];

            $idTopic = $topicManager->add($data);

            $data = [
                "texte" => str_replace("'","\'",$texte),
                "topic_id" => $idTopic,
                "utilisateur_id"=> $_SESSION['user']->getId()
            ];

            $postManager->add($data);
            
            $session->addFlash("success","Topic crée!");

            $this->redirectTo("post","listPostsByTopic", $idTopic);

        } else {

            $session->addFlash("error","Veuillez remplir tous les champs!");

            $this->redirectTo("topic","ajouterTopicAffichage");
            
        }

    }
    // Modification topic
    public function modifierTopic($id) {

        $topicManager = new TopicManager();
        $session = new Session();

        $titre = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $topic = $topicManager->findOneById($id);

        // Si un utilisateur est en session
        if(Session::getUser()){
            // Si l'utilisateur est un admin ou l'auteur du topic
            if(Session::isAdmin() || Session::getUser()->getId() == $topic->getUtilisateur()->getId()){
                // Si le formulaire a été submit et que le champ titre est rempli
                if(isset($_POST["submit"]) && ($titre != "")) {
    
                    $data = [
                        "titre" => str_replace("'","\'",$titre)
                    ];
        
                    $topicManager->update($data,$id);
        
                    $session->addFlash("success","Topic crée!");
        
                    $this->redirectTo("post","listPostsByTopic", $id);
        
                } 
        
                
            // Si c'est un visiteur ou un utilisateur qui n'est pas auteur du topic
            } else {
    
                $session->addFlash("error","Vous n'avez pas les autorisations nécessaires pour effectuer cette action!");
    
                $this->redirectTo("categorie","index");
    
            }

            return [
                "view" => VIEW_DIR."modification/modificationTopic.php",
                "meta_description" => "Modification de topic",
                "data" => [
                "topic"=>$topic
                ]
            ];
        }
    }

    //Supprimer un topic
    public function supprimerTopic($id) {

        
        $topicManager = new TopicManager();
        $session = new Session();

        
        // Si l'utilisateur est un admin
        if(Session::isAdmin()){
            
            $topic = $topicManager->findOneById($id)->getCategorie()->getId();

            $topicManager->delete($id);

            $session->addFlash("success","Topic supprimé avec succès!");

            $this->redirectTo("topic","listTopicsByCategory",$topic);

        // Si l'utilisateur n'est pas un admin
        } else {

            $session->addFlash("error","Vous n'avez pas les autorisations nécessaires pour effectuer cette action!");
    
            $this->redirectTo("categorie","index");

        }
        
    }

    public function verrouillerTopic($id){


        $topicManager = new TopicManager();
        $session = new Session();

        $topic = $topicManager->findOneById($id);
        $idCategorie = $topicManager->findOneById($id)->getCategorie()->getId();

        // Si l'utilisateur est un admin
        if(Session::isAdmin()){
            // Si le topic n'est pas verrouillé
            if($topic->getVerrouillage() == 0){
                // On le verrouille
                $data = [
                    "verrouillage" => "1"
                ];
        
                $topicManager->update($data,$id);
        
                $session->addFlash("success","Topic verrouillé!");
    
            // S'il est verrouillé
            } else {
                // On le déverrouille
                $data = [
                    "verrouillage" => "0"
                ];
        
                $topicManager->update($data,$id);
        
                $session->addFlash("success","Topic deverrouillé!");
    
            }
    
            $this->redirectTo("topic","listTopicsByCategory",$idCategorie);

        // Si l'utilisateur n'est pas un admin
        } else {

            $session->addFlash("error","Vous n'avez pas les autorisations nécessaires pour effectuer cette action!");
    
            $this->redirectTo("categorie","index");

        }
    }
}