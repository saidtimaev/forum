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


        $data = [];

        foreach($_POST as $key => $value ){

            if($key != "submit"){
                $data[$key] = $value;
                
            }

        }

        // var_dump($data); die;
    
        $postManager = new PostManager();
        
        $postManager->add($data);

        self::redirectTo("post","listPostsByTopic",$data["topic_id"]);

    }

}