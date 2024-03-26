<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class UtilisateurManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Utilisateur";
    protected $tableName = "utilisateur";

    public function __construct(){
        parent::connect();
    }


    public function findUtilisateur($pseudonyme, $email){
        $sql = "SELECT * 
                FROM ".$this->tableName." t 
                WHERE t.pseudonyme = :pseudonyme OR t.mail = :email
                ";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, [
                'pseudonyme' => $pseudonyme,
                'email' => $email,

            ]), 
            $this->className
        );
    }
}