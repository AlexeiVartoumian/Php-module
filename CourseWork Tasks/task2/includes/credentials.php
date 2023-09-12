<?php
/* The whole goal of the main part of this page was to set up some sort of secrecy regarding the credentials as such all other pages that
need to acces mysql will use this page which is the sole point that makes the call to the databse* */
try {
    // Establish the database connection
    
    $env_real_path = realpath(__DIR__."/../env");
		if ( !$env_real_path){
			echo "FAILURE TO CONNECT TO ENV!";
		}
    $env_array = [];
    
    $envpath= "";
    $envpath = ("../env/.env");
    

    /* was getting a routing bug depending on which file needed the env file above.  Im guessing you have to set the environment variable as global thing below fixed my problem* */
    $list_of_fules_arr = get_included_files();
    foreach ($list_of_fules_arr as $file_path) {
        if  (substr($file_path,-9) == "index.php"){ # quick fix would like to learn how to prevent this routing bug
            $envpath = ("env/.env");
        }
      }

    $handler = fopen($envpath,'r');

    if ($handler){
        while (($line= fgets($handler)) !== False){
            $env_ex = explode("=",$line);
            
            $env_array[$env_ex[0]] = $env_ex[1]; 
           
        }
        fclose($handler);
    }
    
    $host1  = "";
    $dbname1 = "";
    $username1 = "";
    $password1 = "";
    
   
    
    $env_variables = [$host1 ,$dbname1,$username1,$password1];

    
    function load_variables($data, &$variables){
    //was getting a bunch of errors getting the strings being accepted as authentication parameteres for sql.
    //playing around with them led me to the below get rid of all quotations and semicolons.
        $track = 0;
        foreach( $data as $key => $value){
            $cur = str_replace("'", "",$value);
            $newcur = str_replace(";","",$cur);
            $newestcur = trim($newcur);
            $variables[$track] = $newestcur;
            $track+=1;
        }
        return $variables;
    }
    
    load_variables($env_array, $env_variables);
    
    $host1 = $env_variables[0];
    $dbname1= $env_variables[1] ;
    $username1= $env_variables[2];
    $password1=$env_variables[3];
    
    $pdo = new PDO("mysql:host=$host1;dbname=$dbname1", $username1, $password1);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    #-------------------------------------------------------------------------------------------------------------------------
    /* these three functions are used by queries php, the idea is to generate 1 to 1 arrays so when constructing the html table
    all i have to do is iterate through each array appending html until done. see the queries page to see the two arrays being manipulated* */
    function fetch_from_database($var,$pdo){
        $stmt = $pdo->query($var);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    function grab_results_from_ASSOC_ARR($arr, &$newarr){
        foreach($arr as $key => $value){
            foreach( $value as $innerkey =>$innervalue ){
                $newarr[] = $innervalue;            
            }
        }
        return $arr;
    }
    
    function workflow($queries,&$arright,$pdo){
        for ($i=0; $i < sizeof($queries); $i++){
            $queries[$i] = fetch_from_database($queries[$i],$pdo);
            grab_results_from_ASSOC_ARR($queries[$i] ,$arright);
        }
        return $arright;
    }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>








