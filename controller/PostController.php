<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;

class PostController extends AbstractController implements ControllerInterface{

    public function index() {

        self::redirectTo("categorie");
        
    }

    public function listPostsByTopic($id) {

        $postManager = new PostManager();
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);
        $posts = $postManager->findPostsByTopic($id);

        return [
            "view" => VIEW_DIR."list/listPosts.php",
            "meta_description" => "Liste des posts par topic : ".$topic,
            "data" => [
                "topic" => $topic,
                "posts" => $posts
            ]
        ];
    }

    
    

    public function ajouterPost() {

        $postManager = new PostManager();
        $topicManager = new TopicManager();

        if(isset($_POST["submit"])) {

            $texte = filter_input(INPUT_POST, "texte", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $idTopic = filter_input(INPUT_POST, "topic_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            $topic = $topicManager->findOneById($idTopic);

            if($topic?->getVerrouillage()){
                var_dump('Le topic est verrouillé');
            } 
            
            // if($topic){
            //     if($topic->getVerouillage()){
            //         var_dump('Le topic est verrouillé');
            //     }
            // }

            $data = [];

            foreach($_POST as $key => $value ){

                if($key != "submit"){
                    $data[$key] = str_replace("'","\'",$value);
                    
                }

            }

            $data['utilisateur_id'] = !empty($_SESSION['user']) ? $_SESSION['user']->getId() : null;
            $postManager->add($data);
        }
        

        // var_dump($data); die;
    
        self::redirectTo("post","listPostsByTopic",$data["topic_id"]);

    }

}