<?php
require_once '/bdd.php';


class personne{
	public $con;
	public $id;
	public $utilisateur;
	public $passe;
	public $conninfo;


public function __construct(){
$this->con=new bdd("RDITS-MDC","bdd_user","user_bdd","ping2");
$this->conninfo = $this->con->Condb();
}

  public function login($login, $pass) {
      
        $select = " SELECT * FROM [ping2].[dbo].[personne] WHERE [utilisateur] = '%s' AND [passe] = '%s'";
		$fixedlogin = $login;
		$fixedpass  = $pass;
		$query = sprintf($select, $fixedlogin, $fixedpass);
		
		
		$result = sqlsrv_query($this->conninfo,$query, array(), array("Scrollable"=>"buffered"));

        if(sqlsrv_num_rows($result) != 1) { 

        echo "authentification incorrecte";

         }   

        else {

        $row = sqlsrv_fetch_array($result);
        $this->id=$row[0];
        $this->utilisateur=$row[1];

        
		
		
     
}


    }




}


?>