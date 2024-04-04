<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;

class PostController extends AbstractController implements ControllerInterface{

    public function index() {

        $this->redirectTo("categorie");
        
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
        $session = new Session();

        $texte = filter_input(INPUT_POST, "texte", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $idTopic = filter_input(INPUT_POST, "topic_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        

        if(isset($_POST["submit"]) && ($texte != "")) {

            $topic = $topicManager->findOneById($idTopic);

            if($topic?->getVerrouillage()){
                var_dump('Le topic est verrouillé');
            } 
            
            // if($topic){
            //     if($topic->getVerouillage()){
            //         var_dump('Le topic est verrouillé');
            //     }
            // }

            $data = [
                "texte" => str_replace("'","\'",$texte),
                "topic_id" => $idTopic,
            ];

            $data['utilisateur_id'] = !empty($_SESSION['user']) ? $_SESSION['user']->getId() : null;

            $postManager->add($data);

            $session->addFlash("success","Post ajouté");

        } else {

            $session->addFlash("error","Veuillez saisir un message!");
            
        }
    
        $this->redirectTo("post","listPostsByTopic",$idTopic);

    }

    public function modifierPost($id) {

        $postManager = new PostManager();
        $topicManager = new TopicManager();
        $session = new Session();

        $texte = filter_input(INPUT_POST, "texte", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $idTopic = filter_input(INPUT_POST, "topic_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $post = $postManager->findOneById($id);
        $topic = $topicManager->findOneById($idTopic);
        

        // var_dump($topic);die;

        if(isset($_POST["submit"]) && ($texte != "")) {


            if($topic?->getVerrouillage() && !Session::isAdmin()){
            } 
            
            // if($topic){
            //     if($topic->getVerouillage()){
            //         var_dump('Le topic est verrouillé');
            //     }
            // }

            $data = [
                "texte" => str_replace("'","\'",$texte),
            ];

            //$data['utilisateur_id'] = !empty($_SESSION['user']) ? $_SESSION['user']->getId() : null;

            $postManager->update($data,$id);

            $session->addFlash("success","Post modifié");

            $this->redirectTo("post","modifierPost", $id);

        } else {

            
            
        }
    

        return [
            "view" => VIEW_DIR."modification/modificationPost.php",
            "meta_description" => "Modification de post",
            "data" => [
            "post"=>$post
            ]
        ];
    }

    public function supprimerPost($id) {

        
        $postManager = new PostManager();
        $session = new Session();

        $post = $postManager->findOneById($id)->getTopic()->getId();

        // var_dump($post);die;
        
        $postManager->delete($id);

        $session->addFlash("success","Message supprimé avec succès!");

        $this->redirectTo("post","listPostsByTopic",$post);

        
    }

}