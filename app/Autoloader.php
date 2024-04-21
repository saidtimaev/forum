<?php
namespace App;

class Autoloader{

	public static function register(){
		spl_autoload_register(array(__CLASS__, 'autoload'));
	}

	public static function autoload($class){

		//$class = Model\Managers\TopicManager (FullyQualifiedClassName)
		//$class = controller\CategorieController (FullyQualifiedClassName)
		//namespace = Model\Managers, nom de la classe = TopicManager
		//namespace = controller, nom de la classe = CategorieController

		// on explose notre variable $class par \
		$parts = preg_split('#\\\#', $class);
		//$parts = ['Model', 'Managers', 'TopicManager']
		//$parts = ['controller','CategorieController']
		
		// on extrait le dernier element 
		$className = array_pop($parts);
		//$className = TopicManager
		//$className = CategorieController
		
		// on créé le chemin vers la classe
		// on utilise DS car plus propre et meilleure portabilité entre les différents systèmes (windows/linux) 
		
		$path = strtolower(implode(DS, $parts));
		//$path = 'model/managers'
		//$path = 'controller'
		$file = $className.'.php';
		
		//$file = TopicManager.php
		//$file = CategorieController.php

		$filepath = BASE_DIR.$path.DS.$file;
		
		//$filepath = model/managers/TopicManager.php
		//$filepath = controller/CategorieController.php
		if(file_exists($filepath)){
			require $filepath;
		}
	}
}
