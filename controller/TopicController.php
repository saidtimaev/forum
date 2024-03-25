<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\TopicManager;
use Model\Managers\CategorieManager;

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
            "meta_description" => "Liste des topics par catégorie : ",
            "data" => [
                
            ]
        ];
    }

    public function ajouterTopic() {


        $data = [];

        foreach($_POST as $key => $value ){

            if($key != "submit"){
                $data[$key] = $value;
                
            }

        }

        // var_dump($data); die;
    
        $topicManager = new TopicManager();
        $topicManager
        $topicManager->add($data);

        self::redirectTo("topic","listTopicsByCategory", $data["categorie_id"]);

    }
}