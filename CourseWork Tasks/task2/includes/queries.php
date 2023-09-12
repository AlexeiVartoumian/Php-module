<?php
require_once "credentials.php";
#some sql queries 
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

workflow($queries,$arright,$pdo);




?>