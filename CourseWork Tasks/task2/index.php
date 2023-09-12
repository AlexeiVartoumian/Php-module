
		<?php
		#Your PHP solution code should go here...
		include "includes/functions.php";
		include "includes/queries.php";
		
		$title = "Coursework 2";
		$header = html_headings("Web Programming using PHP - Coursework 2  - Task 2 PDO Database read/write",1);

		$content = html_headings("Web Programming Using Php",2);
		$content.= generate_table2($arright,$arrleft);
		
		$htmlTemplate = file_get_contents('pageTemplate.html');
		echo str_replace(['[+title+]','[+header+]','[+content+]'],[$title,$header,$content],$htmlTemplate);

		
		?>
    
