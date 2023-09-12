<?php
    try {
        // Establish the database connection
        #"/../env" path for when this file will be inside includes
        #/env when file is living on the same branch as folder
        $env_real_path = realpath(__DIR__."/../env");
            if ( !$env_real_path){
                echo "FAILURE TO CONNECT TO ENV!";
            }
        #env
        $env_array = [];
        
        $envpath= "";
        $envpath = ("../env/.env"); #this path for all files in includes
        #$envpath = ("env/.env");
        $list_of_rules_arr = get_included_files();
        foreach ($list_of_rules_arr as $file_path) {
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
        
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }






?>