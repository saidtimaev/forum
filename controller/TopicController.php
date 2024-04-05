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

    public function ajouterTopicAffichage() {


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

    public function modifierTopic($id) {

        $topicManager = new TopicManager();
        $session = new Session();

        $titre = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $topic = $topicManager->findOneById($id);
        
        if(isset($_POST["submit"]) && ($titre != "")) {

            $data = [
                "titre" => str_replace("'","\'",$titre)
            ];

            $topicManager->update($data,$id);

            $session->addFlash("success","Topic crée!");

            $this->redirectTo("post","listPostsByTopic", $id);

        } 

        return [
            "view" => VIEW_DIR."modification/modificationTopic.php",
            "meta_description" => "Modification de topic",
            "data" => [
            "topic"=>$topic
            ]
        ];
    }

    public function supprimerTopic($id) {

        
        $topicManager = new TopicManager();
        $session = new Session();

        $topic = $topicManager->findOneById($id)->getCategorie()->getId();

        // var_dump($post);die;
        
        $topicManager->delete($id);

        $session->addFlash("success","Topic supprimé avec succès!");

        $this->redirectTo("topic","listTopicsByCategory",$topic);
    }

    public function verrouillerTopic($id){


        $topicManager = new TopicManager();
        $session = new Session();

        $topic = $topicManager->findOneById($id);


        if($topic->getVerrouillage() == 0){

            $data = [
                "verrouillage" => "1"
            ];
    
            $topicManager->update($data,$id);
    
            $session->addFlash("success","Topic verrouillé!");

        }
        

    }
}