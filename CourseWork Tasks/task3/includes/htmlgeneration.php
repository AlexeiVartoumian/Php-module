<?php

    function html_headings($text,$level) {
        $html = htmlentities($text);
        return "<h$level>$html</h$level>";
    }
    
    function htmlgenerator($content,$creds,$success){
        
        $email = FALSE;
        $username = FALSE;
        $password = FALSE;
        $errors= [$email,$username,$password];
        for ($i = 0; $i < sizeof($content);$i++){
           if ( $content[$i] != 0    ){
                $errors[$i] = True;
           }
        }
        
        $newhtml = "";
        $error1= '<span style="color:red"> invalid email format<span></span></span>';
        $error2= '<span style="color:red"> Username Less than 8 characters or NOT alphanumeric!<span></span></span>';
        $error3 ='<span style="color:red"> not in the required password format<span></span></span>';
        $email_exists= '<span style="color:red"> this email is already registered!<span></span></span>';
        $user_exists= '<span style="color:red"> another user already has this username!<span></span></span>';
        $alreadyexist = check_if_credentials_exists($creds);
        
        if (is_array($alreadyexist)){
            if (sizeof($alreadyexist) == 3){
                $errors[0] = True;
                $errors[1] = True;
                $error1 = $email_exists;
                $error2 = $user_exists;
            }elseif ($alreadyexist[0] == "email"){
                
                $errors[0] = True;
                
                $error1 = $email_exists;
            }else{
                $errors[1] = True;
            
                $error2 = $user_exists;
                
            }
        }
        ;

        $make = [$error1,$error2,$error3];
       
        #$newhtml .= $make[$track]; # the idea here is that given boolean value true we will serve up html on the fly 
        
        $newhtml= head_of_form();
        $newhtml.= form_email_template($errors,$make);
        $newhtml.= form_username_template($errors,$make);
        $newhtml .= form_password_template($errors,$make);
        $newhtml .= end_of_form();
            
        
        return $newhtml;

    }

    function head_of_form(){
        $str = '<div id="userForm">
                <form method="post" novalidate> <!-- post data to this script as no action attribute specified-->
	                <fieldset>
	                <div>';
        
        
        return $str;
    }
    function form_email_template( $errors,$make){
        $str = '<div class="email">
                <label for="email">Email</label>
                <input title="email format required and UNIQUE" type="text" name="email" id="email" maxlength="45" size ="45">';
        if ($errors[0] != False){
            $str.= $make[0];
            
        }
        $str.='</div>';
        return $str;
    }

    function form_username_template($errors,$make){
        $str = '<div class="username">
        <label for="username">Username</label>
        <input title="Alphanumeric >=8 characters and UNIQUE" type="text" name="username" id="username" maxlength="30" size ="45">';
        if ($errors[1] != False){
                $str.= $make[1];
                
            }
        $str.= '</div>';
        return $str;
    }

    function form_password_template($errors,$make){
        $str= '<div class="password">
        <label for="password">Password</label>
        <input title=">= 8 characters, MUST include, uppercase, lowercase, a number, plus one of ! - < > £ $ % & * ~ #" type="text" name="password" id="password" maxlength="15" size ="45">';
        if ($errors[2] != False){
            $str.= $make[2];
            
        }
        $str .= '</div>';
        return $str;
    }

    function end_of_form(){
                $str =' <div >
                            <label for="userType">User Type</label>
                            <select title="Select either Academic, Admin or Student" name="userType" id="userType">
                                <option value="academic">Academic</option>
                                <option value="admin">Admin</option>
                                <option value="student">Student</option>
                            </select>
                        </div>
                        <input type="submit" name="userDataSubmitted"  id = "userDataSubmitted" value="Save" >
                        <input type="submit" name="userDataClear" value="Clear" >
                    </div>
                </fieldset>
            </form>
        </div>';
                return $str;

    }

    function base_form(){
        $str = '<div id="userForm">
                    <form method="post" novalidate> <!-- post data to this script as no action attribute specified-->
                        <fieldset>
                            <div>
                                <div class="email">
                                    <label for="email">Email</label>
                                    <input title="email format required and UNIQUE" type="text" name="email" id="email" maxlength="45" size ="45">
                                </div>
                                <div class="username">
                                    <label for="username">Username</label>
                                    <input title="Alphanumeric >=8 characters and UNIQUE" type="text" name="username" id="username" maxlength="30" size ="45">
                                </div>
                                <div class="password">
                                    <label for="password">Password</label>
                                    <input title=">= 8 characters, MUST include, uppercase, lowercase, a number, plus one of ! - < > £ $ % & * ~ #" type="text" name="password" id="password" maxlength="15" size ="45">
                                </div>
                                <div >
                                    <label for="userType">User Type</label>
                                    <select title="Select either Academic, Admin or Student" name="userType" id="userType">
                                        <option value="academic">Academic</option>
                                        <option value="admin">Admin</option>
                                        <option value="student">Student</option>
                                    </select>
                                </div>
                                <input type="submit" name="userDataSubmitted"  id = "userDataSubmitted" value="Save" >
                                <input type="submit" name="userDataClear" value="Clear">
                            </div>
                        </fieldset>
    
                    </form>
                    </div>';
        return $str;
    }

    function generate_ptag_entries($id,$email,$username,$type){
        $ptag = '<p>';
        $ptag.= "ID: $id ,Email: $email, Username: $username , Type: $type";
        $ptag .= "</p>";
        return $ptag;
    }
#----------------------------------------------------------------------------------------------------------------------------------
    
# for the student view
    
#------------------------------------------------------------------------------------





?>