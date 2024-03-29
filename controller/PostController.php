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

        if(isset($_POST["submit"])) {

            $texte = filter_input(INPUT_POST, "texte", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $password1 = filter_input(INPUT_POST, "password1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [];

            foreach($_POST as $key => $value ){

                if($key != "submit"){
                    $data[$key] = str_replace("'","\'",$value);
                    
                }

            }

            $postManager->add($data);
        }
        

        // var_dump($data); die;
    
        self::redirectTo("post","listPostsByTopic",$data["topic_id"]);

    }

}