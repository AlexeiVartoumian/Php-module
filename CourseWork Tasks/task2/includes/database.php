<?php
include "../data/p1.csv";
include "credentials.php";


$filename = '../data/p1.csv';
/* the whole flow of this page tries for two things. firstly in the instance where the table of required name exists do not enter the second try block. in which case use the php library function to read data from the csv file in an iterative fashion appending each section of the data to the respective fields in the sql databse.* */
try {
    // Create a new PDO instance
    // Table name to check
    $tableName = "moduleResults";
    // Query to check if the table exists
    $query = "SHOW TABLES LIKE '$tableName'";
    $result = $pdo->query($query);
    // Check if the table exists
    if ($result->rowCount() > 0) {
        echo "Table '$tableName' exists.";
    } else {
        echo "Table '$tableName' does not exist.";

        try {
    
            $createTableQuery = "CREATE TABLE IF NOT EXISTS moduleResults (
                module_code VARCHAR(255),
                student_id INT,
                grade INT
            )";
            $pdo->exec($createTableQuery);
        
            // Prepare the insert statement
            $insertQuery = "INSERT INTO moduleResults (module_code, student_id, grade) VALUES (:module_code, :student_id, :grade)";
            $stmt = $pdo->prepare($insertQuery);
        
            // Read the CSV file
            if (($handle = fopen($filename, "r")) !== false) {
                while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                    $module_code = $data[0];
                    $student_id = $data[1];
                    $grade = $data[2];
                    
                    // Bind the values and execute the statement
                    $stmt->bindParam(':module_code', $module_code);
                    $stmt->bindParam(':student_id', $student_id);
                    $stmt->bindParam(':grade', $grade);
                    $stmt->execute();
                }
                fclose($handle);
            }
        
            echo "Data inserted successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}



?>