<?php
#some basic HTML generation functions

function htmlHeading($text, $level) {
	$heading = trim(strtolower($text));
	switch ($level) {
		case 1 :
		case 2 :
			$heading = ucwords($heading);
			break;
		case 3 :
		case 4 :
		case 5 :
		case 6 :
			$heading = ucfirst($heading);
			break;
		default: #traps unknown heading level exception
			$heading = '<FONT COLOR="#ff0000">Unknown heading level:' . $level . '</FONT>';
		}
	return '<h' . $level . '>' . htmlentities($heading) . '</h' . $level .  '>';
}

function htmlParagraph($text) {
	return '<p>' . htmlentities(trim($text)) . '</p>';
}

#ADD YOUR USER DEFINED FUNCTIONS HERE

function login_form( $loginfail="" ){
	return "<form method='post'>
	<fieldset>
	<legend>Login</legend>
	<div>
		<label for='username'>username</label>
		<input value='' type='text' name='username' id='username'>
		<label for='password'>password</label>
		<input type='password' name='password' id='password'>
		<input type='submit' name='login' id ='login' value='login' >
		<span style='color:red'> $loginfail</span>
	</div>
	</fieldset>
</form>";

}

function logout_form($name,$usertype){
	$currentUser = $name. " ". "(" . $usertype . ")";
	return "<form method='post'>
	<fieldset>
	<legend>Logged in user</legend>
	<div>
		<label for='username'>$currentUser : </label>
		<input type='submit' name='logout' id = 'logout' value='logout' />
	</div>
	</fieldset>
</form>";
}

function generate_ptag_entries($username,$password,$type){
	$ptag = '<p>';
	$ptag.= "Username:$username , Password :$password , userType:$type";
	$ptag .= "</p>";
	return $ptag;
}


function switch_menu($view){
	switch ($view) {
		case 'home' :
			include 'views/home.php';
			break;
		case 'admin' :
			include 'views/admin.php';
			break;
		case 'academic' :
			include 'views/academic.php';
			break;
		case 'student' :
			include 'views/student.php';
			break;
		default :
			include 'views/404.php';
	}
}

#----------------------------------------------------------------------------------------------

#these functions deal with the logic needed for changing the navigation bar depending on user

$data2 = ['home' => 'Home Page', 'admin' => 'Admin', 'academic' => 'Academic', 'student'=>'Student'];

function change_navBar($isloggedin,$usertype= "None"){
	
	if (!$isloggedin){
		return ['home' => 'Home Page'];
	}
	else{
		switch ($usertype) {
			case 'admin' :
				return ['home' => 'Home Page', 'admin' => 'Admin', 'academic' => 'Academic', 'student'=>'Student'];
				break;
			case 'academic' :
				return ['home' => 'Home Page', 'academic' => 'Academic', 'student'=>'Student'];
				break;
			case 'student' :
				return ['home' => 'Home Page', 'student'=>'Student'];
				break;
			
			default :
				return ['home' => 'Home Page'];
		}
	}
}

function html_NAV($navData,$URLparams) { 
	
		$html = '<nav>'; 
		$html .= '<ul>';
		foreach ($navData as $key => $menuitem){
			$html.= '<li>';
			$html.= generate_menu_item($URLparams,$key,$menuitem);
			$html.= '</li>';
		}
		$html.= '</ul>';
		$html .= '</nav>';
		return $html;
	}

function generate_menu_item($URLparams,$key,$menuitem){

$html = "<a href=\"index.php?$URLparams=$key\">$menuitem </a>";

return $html;
}


#--------------------------------------------------------------

#--------------------------------------------------------------------------------
# these functions will handle the initial input from the user
function read_user_input(){
	
	$username = "";
	$password = "";
	
	if (isset($_POST['username'])){
		$username = $_POST['username'];
	}
	if (isset($_POST['password'])){
		$password = $_POST['password'];
	}
	$array = [$username,$password];
	return $array;
}
function read_user_name(){
	$username = "";
	if (isset($_POST['username'])){
		$username = $_POST['username'];
	}
	return $username;
}
function read_user_pass(){
	$password = "";
	if (isset($_POST['password'])){
		$password = $_POST['password'];
	}
	return $password;
}


#--------------------------------------------------------------------------------------------------------------------------
#all these functions are from the task 3 for generating the academic view 
function generate_table2($grades,$grade_format){
    $html = "<table>";
    $size = sizeof($grades);
    for ($i = 0; $i< $size;$i++){
        $html.= "<tr>";
        $html.= generate_table_row($grades,$grade_format,$i);
        $html .= "</tr>";
    }
    
    $html .= "</table>";
    return $html;
}

function generate_table_row($grades,$grade_format,$current){

        if ($current == 0){
            $html = "<th> $grade_format[$current] </th>";
            $html .= "<th> $grades[$current] </th>";
        }
        else{
            $html = "<td> $grade_format[$current] </td>";
            $html .= "<td> $grades[$current] </td>";
        }
        return $html;      
    }

function generate_table_header($grade_format){
    $html = "<tr>";
    for ($i= 0; $i <sizeof($grade_format); $i++){
        $html .= "<th> $grade_format[$i] </th>";
    }
    $html.= "</tr>";
    return $html;
}
function generate_table_cell($grades){
    $html = "<tr>";
    for ($i= 0; $i <sizeof($grades); $i++){
        $html .= "<td> $grades[$i] </td>";
    }
    $html.= "</tr>";
    return $html;
}
/* these three functions are used by academic php, the idea is to generate 1 to 1 arrays so when constructing the html table
    all i have to do is iterate through each array appending html until done. see the queries page to see the two arrays being manipulated* */
    
#--------------------------------------------------------------------------------------------------------------------------------------------------------
#admin function
function retrieve_cookies($COOKIE, $usernames){

	$content = "";
	if ($COOKIE){
		for ($i=0; $i < sizeof($usernames); $i++){

			if (isset($_COOKIE[$usernames[$i]])){
				$content.= "<p>";
				$content.= $usernames[$i];
				$content.= " viewed the ";
				$content.= $_COOKIE[$usernames[$i]];
				$content.= " page on last Logout </p>";
			}
		}
		return $content;
		
	}
	
	
}

#------------------------------------------------------------------------------------------------------------------------------------------
?>