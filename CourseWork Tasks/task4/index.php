<?php
/*	Web Programming Using PHP Cwk2 Task 4 - MVC Controller
	This script should act as the controller for a Single Point of Entry MVC design model
*/
include 'includes/functions.php';  #your user defined function library to be implemented
include 'includes/config.php'; #your database connection returns $pdo connection variable
include 'includes/credentials.php';

/* there are four parts here  1.initial state , 2.conditional logic when a user logs 3. routing logic when a user is logged in. 4.inside part three when a user logs out
all parts are delineated with green lines. */

#1.-------------------------------------------------------intial state--------------------------------------------------------
	session_start();
	$loginform = login_form();
	$htmlTemplate = file_get_contents('html/pageTemplate.html');
	
	$title = "PHP Cw2 Home Page";
	$success = [FALSE, 'home']; # handle user state logic i.e initial state is False = not logged in and 'home' being the current view 
	
	$homenav = change_navBar($success[0], $success[1]);
	$nav = html_NAV($homenav, 'views');
	$variables = load_variables($env_array, $env_variables); # credentials for connections
	$pdo = create_Connection($variables);
	$content = generate_existing_users1($variables,$pdo);
	
	
	if (isset($_GET['views']) ) { #URL parameter detected...
		$view = $_GET['views']; #get URL parameter from $_GET[]
		
	} elseif (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
		
		
		$view = $_GET['views'];
		
	}
	else {
		$view = 'home'; #set default model as Home page
	}
#---------------------------------------------------------------------------------------------------------------------------
#2.-------------------------------------------------------login logic-----------------------------------------------------------------
	if (isset($_POST['login'])) {
		$name = read_user_name();
		$pass = read_user_pass();
		$values = [$name, $pass];
		$success = check_user_input_in_database($values,$variables,$pdo);
	
		if ($success[0]) {
			
			
			$_SESSION['name'] = $name;
			$_SESSION['success'] = $success; // Store success value in session
			$loginform = logout_form($name,$success[1]);
			$NAVBAR = change_navBar(True, $success[1]);
			$nav = html_NAV($NAVBAR, 'views');
			$heading = htmlHeading("Home Page View", 2);
			$_SESSION['loggedin'] = TRUE;

			if(isset ($_COOKIE[$name])){
				
				$view = $_COOKIE[$name];
				$current = $_SERVER['REQUEST_URI'];
				$parts = parse_url($current);
				parse_str($parts['query'],$params);
				$params['views'] = $view;
				$newurl = http_build_query($params);
				$newurl = $parts['path'] . "?" . $newurl;
				header("Location: " . $newurl);
				
			}
			
			echo str_replace(['[+loginOutForm+]', '[+nav+]', '[+heading+]', '[+content+]'], [$loginform, $nav, $heading, $content], $htmlTemplate);
			exit; 
		}
		if ($success[1] == "incorrect password"){
			$loginform = login_form("incorrect password");
		}else{
			$loginform = login_form("user unknown");
		}
	}
#---------------------------------------------------------------------------------------------------------------------------------

#3.------------------------------------------------------- logged in state ---------------------------------------------------------------
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
		
		$name = $_SESSION['name'];
		$success = $_SESSION['success'];
		$loginform = logout_form($name, $success[1]);
		
		
		$NAVBAR = change_navBar(True, $success[1]);
		$nav = html_NAV($NAVBAR, "views");
		$heading = htmlHeading("Logged-in View", 2);
		
		switch ($view) {
			case 'home':
				include 'views/home.php';
				break;
			case 'admin':
				include 'views/admin.php';
				break;
			case 'academic':
				include 'views/academic.php';
				break;
			case 'student':
				include 'views/student.php';
				break;
			default:
				include 'views/404.php';
		}
		#4.-----------------------------------------------subsection of 3 user logs out--------------------------------------------
		if (isset($_POST['logout'])) {	
			$cookiename = $_SESSION['name'];
			$cookiepage = $_GET['views'];
			$_COOKIE['name'] = $cookiepage;
		
			setcookie($cookiename,$cookiepage,time()+(3600*24* 7));
			
			session_unset();
			session_destroy();
			$loginform = login_form();
			$success = [FALSE, 'home'];
			$NAVBAR = change_navBar(False, 'home');
			
			$nav = html_NAV($NAVBAR, 'views');
			
			$heading = htmlHeading("Home Page View", 2);
			$content = generate_existing_users1($variables,$pdo);
			
			$current = $_SERVER['REQUEST_URI'];
				
			$parts = parse_url($current);
			
			parse_str($parts['query'],$params);
			$params['views'] = 'home';
			$newurl = http_build_query($params);
			$newurl = $parts['path'] . "?" . $newurl;
			header("Location: " . $newurl);
			
			exit;
		}
		#--------------------------------------------------------------------------------------------------------------------------------
		echo str_replace(['[+title+]','[+loginOutForm+]', '[+nav+]', '[+heading+]', '[+content+]'], [$title,$loginform, $nav, $heading, $content], $htmlTemplate);
	} else {# this block fires if the user is not logged in and is related to the part 1
		include 'views/home.php';
		echo str_replace(['[+title+]','[+loginOutForm+]', '[+nav+]', '[+heading+]', '[+content+]'], [$title,$loginform, $nav, $heading, $content], $htmlTemplate);
	}

?>


