
	
		<?php

		/* * */

		#Your PHP solution code should go here...
		require_once "includes/credentials.php";
		include "includes/update.php";
		require_once "includes/htmlgeneration.php";
		require_once "includes/uservalidationfunctions.php";
		
		
		
		$load = load_variables($env_array, $env_variables);
		$title = "Coursework 2";
		$header = html_headings("Web Programming using PHP - Coursework 2  - Task 3 PDO Database read/write",1);
		
		$content = html_headings("Webform data entry, validation, and database storage",2);
		$content .= base_form();
		$content .= html_headings("Users Stored In The Database",2);
		$content .= generate_existing_users($load);
		
		$htmlTemplate = file_get_contents('pageTemplate.html');
		#echo str_replace(['[+title+]','[+header+]','[+content+]'],[$title,$header,$content],$htmlTemplate);
		
		if (isset($_POST['userDataSubmitted'])){
			// if user submuits then we can go ahead and perform logic
			$values = read_user_input();
			$check = valid_email_and_username_and_password1($values);
			if (!$check[1]){
				$htmlTemplate = file_get_contents('pageTemplate.html');
				$content = html_headings("Webform data entry, validation, and database storage",2);
				$content.= htmlgenerator($check[0],$load,FALSE);
				$content.= html_headings("Users Stored In The Database",2);
				$content.= generate_existing_users($load);
				$htmlTemplate = file_get_contents('pageTemplate.html');
				
				echo str_replace(['[+title+]','[+header+]','[+content+]'],[$title,$header,$content],$htmlTemplate);
				
			}else{
				
				update($load);
				$htmlTemplate = file_get_contents('pageTemplate.html');
				$content = html_headings("Webform data entry, validation, and database storage",2);
				#$content.= htmlgenerator([0,0,0],$load,TRUE);
				$content.= head_of_form();
        		$content.= form_email_template([0,0,0],[]);
        		$content.= form_username_template([0,0,0],[]);
        		$content.= form_password_template([0,0,0],[]);
        		$content.= end_of_form();
				$content.= html_headings("Users Stored In The Database",2);
				$content.= generate_existing_users($load);
				$htmlTemplate = file_get_contents('pageTemplate.html');
				echo str_replace(['[+title+]','[+header+]','[+content+]'],[$title,$header,$content],$htmlTemplate);
			}
		
		}else{
			echo str_replace(['[+title+]','[+header+]','[+content+]'],[$title,$header,$content],$htmlTemplate);
		}
		
		
		?>



