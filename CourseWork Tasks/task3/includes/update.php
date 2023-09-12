<?php

    include "uservalidationfunctions.php";
    include "htmlgeneration.php";
    
   
    
        #this function will make a call to the database witht the sole purpose of going through each item storing each colmn in a variable
        #and then passing them into the ptag function
        #$loadvariables = loadvariables() as defualt argument?
        function check_if_credentials_exists($creds){
           
            try{
                $host = $creds[0];
                $dbname = $creds[1];
                $username = $creds[2];
                $password = $creds[3];
                $pdo = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);

                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $checkQuery1 = "
                SELECT COUNT(*) AS email_count
                FROM usersTable
                WHERE email = :email
               ";
               if (isset($_POST['email'])){
                   $stmt = $pdo->prepare($checkQuery1);
                   //$stmt->bindParam(':username', $_POST['email']);
                   
                   $stmt->bindParam(':email', $_POST['email']);
                   $stmt->execute();
                   $emailCount = $stmt->fetch(PDO::FETCH_ASSOC)['email_count'];
               };
               $checkQuery2 = "
                SELECT COUNT(*) AS username_count
                FROM usersTable
                WHERE username = :username
               ";
               if (isset($_POST['username'])){
                   $stmt = $pdo->prepare($checkQuery2);
                   $stmt->bindParam(':username',$_POST['username'] );
                   $stmt->execute();
                   $usernameCount = $stmt->fetch(PDO::FETCH_ASSOC)['username_count'];
               }
               
               if ($emailCount > 0 and $usernameCount > 0 )  {
                   
                    
                    return ["email","username","both"];
                   
               } 
               elseif ($usernameCount > 0) {
                  
                   
                   return ["username"]; 
               }
               elseif($emailCount > 0){
                  
                   return ["email"];
               }
               return True;
            }  catch(PDOException $e){
                echo "connection to database Failed!" . $e-> getmessage();
            }
            }
        function update($creds){
            try{
                $host = $creds[0];
                $dbname = $creds[1];
                $username = $creds[2];
                $password = $creds[3];

                $pdo = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);

                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                #---------------------------------------------------------------------------------------------------
                ### the email query for uniqueness and name query for uniqueness are only executed if above pass
                 
                    // Prepare the INSERT statement
                    $query = "
                        INSERT INTO usersTable (email, username, password, userType)
                        VALUES (:email, :username, :password, :userType)
                    ";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':email', $_POST['email']);
                    $stmt->bindParam(':username', $_POST['username']);
                    $stmt->bindParam(':password', $_POST['password']);
                    $stmt->bindParam(':userType', $_POST['userType']);
                    $stmt->execute();
            
                    #echo "User registered successfully.";
                
            }catch(PDOException $e){
                echo "user registration failed" . $e-> getmessage();
            }
        }
        function generate_existing_users($creds) {
            
        
            $host = $creds[0];
            $dbname = $creds[1];
            $username = $creds[2];
            $password = $creds[3];
           
            $pdo = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT userID, email, username, userType FROM usersTable";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
        
           
            $content = "";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $userID = $row['userID'];
                $email = $row['email'];
                $username = $row['username'];
                $userType = $row['userType'];

                $content.= generate_ptag_entries($userID,$email,$username,$userType);
            }
        
            
            return $content;
        }
        function generate_existing_users1() {
            $host='mysqlsrv.dcs.bbk.ac.uk';
            $dbname='avarto01db';
            $username='avarto01';
            $password='bbkmysql';
            $pdo = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "SELECT userID, email, username, userType FROM usersTable";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
        
           
            $content = "";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $userID = $row['userID'];
                $email = $row['email'];
                $username = $row['username'];
                $userType = $row['userType'];

                $content.= generate_ptag_entries($userID,$email,$username,$userType);
            }
        
            
            return $content;
        }
        

?>