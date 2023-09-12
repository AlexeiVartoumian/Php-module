<?php
    
    include "credentials.php";

    
    try {
        // Establish the database connection
        $tablename = "usersTable";
        $query = "SHOW TABLES LIKE '$tablename'";
        $creds = load_variables($env_array, $env_variables);
        $host = $creds[0];
        $dbname = $creds[1];
        $username = $creds[2];
        $password = $creds[3];
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $pdo->query($query);
        if ($result->rowCount() > 0) {
            echo "Table '$tablename' exists.";
        } else {
            echo "Table '$tablename' does not exist.";

            try{
                // Create the database table
            $createTable = "CREATE TABLE IF NOT EXISTS usersTable (
            userID INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(45) NOT NULL UNIQUE,
            username VARCHAR(30) NOT NULL UNIQUE,
            password VARCHAR(15) NOT NULL,
            userType VARCHAR(10) NOT NULL
            
            )";
            $pdo->exec($createTable);
        
        // Execute the CREATE TABLE query
        $pdo->exec($createTable);
        echo "Table created successfully.";
        } catch (PDOException $e) {
        echo "Table creation failed: " . $e->getMessage();
        }

        }
    } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        
    
    
?>