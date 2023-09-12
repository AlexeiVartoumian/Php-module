<?php

$headTitle = "Academic View";
$viewHeading = htmlHeading("Academic View - Module Results",2);

try {
    

	workflow($queries,$arright,$variables,$pdo);
    $content = generate_table2($arright,$arrleft);
	
	$title = "Academic View";
	$heading = htmlHeading("Academic View- MOdule Results", 2);
	$heading .= htmlHeading("Web Programming Using Php",2);
	
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>