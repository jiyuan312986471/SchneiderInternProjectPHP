<?php

class Personne{
	public $id;
	public $utilisateur;
	public $passe;


	public function __construct($id, $utilisateur, $passe){
		$this->id = $id;
		$this->utilisateur = $utilisateur;
		$this->passe = $passe;
	}
	
	public static function login($login, $pass, $connInfo) {
		$select = "SELECT * FROM [ping2].[dbo].[personne] WHERE [utilisateur] = '%s' AND [passe] = '%s'";
		$query = sprintf($select, $login, $pass);
		$result = sqlsrv_query($connInfo, $query, array(), array("Scrollable"=>"buffered"));
		
		return $result;
	}
}

?>