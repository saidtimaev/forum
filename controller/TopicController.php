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


        $data = [];

        foreach($_POST as $key => $value ){

            if($key != "submit" && $key != "texte"){
                $data[$key] = $value;
                
            }

        }

        // var_dump($data); die;
    
        $topicManager = new TopicManager();
        
        $idNewTopic = $topicManager->add($data);

        $data = [];

        $data['texte'] = $_POST['texte'];
        $data['utilisateur_id'] = $_POST['utilisateur_id'];
        $data['topic_id'] = $idNewTopic;

        $postManager = new PostManager();
        
        $postManager->add($data);

       

        self::redirectTo("post","listPostsByTopic", $idNewTopic);

    }
}