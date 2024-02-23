<?php 

class DB {
    private static $dbh = null;

    static function executeQuery($query, $values = array(), $returnValues = true){
        
		if(DB::$dbh == null){
			DB::$dbh = new PDO("sqlite:" . DB::getDatabasePath());
		}

		$stmt = DB::$dbh->prepare($query);
		for($i = 0; $i < count($values); $i++){
			$stmt->bindParam($i + 1, $values[$i]);
		}

		if(!$stmt->execute()){
            // Handle error as needed
            die("Error executing query: " . $stmt->errorInfo()[2]);
		}

		if($returnValues){
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}
    
    }

    static function getDatabasePath(){
        return dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .  'arqui.db';
    }

    static function getEnvironment(){
        return parse_ini_file(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .  '.env');
    }
}

