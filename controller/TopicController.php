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

        $titre = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $idCategorie = filter_input(INPUT_POST, "categorie_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $texte = filter_input(INPUT_POST, "texte", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(isset($_POST["submit"])) {

            $data = [
                "titre" => str_replace("'","\'",$titre),
                "categorie_id" => $idCategorie,
                "utilisateur_id"=> $_SESSION['user']->getId()
            ];

            // var_dump($data);die;

            $idTopic = $topicManager->add($data);

            // var_dump($idTopic);die;

            $data = [
                "texte" => str_replace("'","\'",$texte),
                "topic_id" => $idTopic,
                "utilisateur_id"=> $_SESSION['user']->getId()
            ];

            // var_dump($data);die;

            $postManager->add($data);

            self::redirectTo("post","listPostsByTopic", $idTopic);
        }

    }
}