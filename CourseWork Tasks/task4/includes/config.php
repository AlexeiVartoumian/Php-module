<?php
#your PDO database connection code should go here

require_once "functions.php";

#approach I tried was to make a single connection to the database which will be defined globally just like environement variable
#as such all functions connecting to database accept the function create_connection as a parameter
$pdo = NULL;
function create_Connection($creds) {
    $host = $creds[0];
    $dbname = $creds[1];
    $username = $creds[2];
    $pass = $creds[3];
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    return $pdo;
}
//$pdo = create_Connection($creds);

function generate_existing_users1($creds,$pdo) {
    if ($pdo == NULL){
        $pdo = create_Connection($creds);
    }
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT  username, password ,userType FROM usersTable";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

   
    $content = "";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $username = $row['username'];
        $password = $row['password'];
        $userType = $row['userType'];

        $content.= generate_ptag_entries($username,$password,$userType);
    }

    
    return $content;
}
function fetch_usernames_for_admin_page($creds,$pdo){
    $arr = [];
    if ($pdo == NULL){
        $pdo = create_Connection($creds);
    }
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT  username FROM usersTable";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $username = $row['username'];
        $arr[] = $username;
    }
    return $arr;
}
function check_user_input_in_database($values,$creds,$pdo){
    if ($pdo == NULL){
        $pdo = create_Connection($creds);
    }

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user = $values[0];
    
	$pwd = $values[1];
    
    $query = "SELECT password ,userType FROM usersTable WHERE username = :username";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':username', $user);
    
    $statement->execute();

    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if($row){
        
        if ($row['password'] == $values[1]){
           
            $success = [TRUE,$row['userType']];
            return $success;
        }else{
            $success = [FALSE,"incorrect password"];
            
            return $success;
        }
    }
    else{
        $success = [FALSE,"user unknown"];
        
        return $success;
    }
 
}

function fetch_from_database($var,$creds,$pdo){
    if ($pdo == NULL){
        $pdo = create_Connection($creds);
    }
    $stmt = $pdo->query($var);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function workflow($queries,&$arright,$creds,$pdo){
    for ($i=0; $i < sizeof($queries); $i++){
        $queries[$i] = fetch_from_database($queries[$i],$creds,$pdo);
        grab_results_from_ASSOC_ARR($queries[$i] ,$arright);
    }
    return $arright;
}

#-------------------------------------------------------------------------------------------------------------------------------------


function grab_results_from_ASSOC_ARR($arr, &$newarr){
    foreach($arr as $key => $value){
        foreach( $value as $innerkey =>$innervalue ){
            $newarr[] = $innervalue;            
        }
    }
    return $arr;
}

$gradesum = "SELECT
    SUM(CASE WHEN grade > 70 THEN 1 ELSE 0 END) AS over_70,
    SUM(CASE WHEN grade >= 60 AND grade <= 70 THEN 1 ELSE 0 END) AS between_60_and_70,
    SUM(CASE WHEN grade >= 50 AND grade < 60 THEN 1 ELSE 0 END) AS between_50_and_60,
    SUM(CASE WHEN grade >= 45 AND grade < 50 THEN 1 ELSE 0 END) AS between_45_and_50,
    SUM(CASE WHEN grade >= 40 AND grade < 45 THEN 1 ELSE 0 END) AS between_40_and_45,
    SUM(CASE WHEN grade < 40 THEN 1 ELSE 0 END) AS under_40
FROM moduleResults
";

$averagesum = "SELECT round(sum(grade)/count(grade)) FROM moduleResults";
$totalstudents= "SELECT count(student_id) FROM moduleResults";

$queries = [$gradesum,$averagesum,$totalstudents];

$arrleft = ["Statistic","1st","2.1","2.2","3rd","Pass","Fail","Average Mark","TOTAL students"];
$arright = ["Number"];
#-------------------------------------------------------------------------------------------------------------------------------------

?>