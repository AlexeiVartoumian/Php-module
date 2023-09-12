<?php
		include "includes/functions.php";

		
		$title = "Dynamic Menu building";
		$header = html_headings("Web Programming using PHP - Coursework 2",1);
		$header.=  html_headings("Task 1 Dynamic Menu building",1);
		$mainNav = main_Nav($navLists);
		#$subNav = ''; see comment at line 39
		$content = "";
		if (isset($_GET['MainNavSelected'])) { 
                
                $subNAVurlParams = "MainNavSelected=$_GET[MainNavSelected]&subNAVselected";
                
				if (sub_nav_choice($_GET['MainNavSelected'])){
					$choice = sub_nav_choice($_GET['MainNavSelected']);
					
					$subNAV = "";
                    $subNAV .= html_NAV($navLists[$choice],$subNAVurlParams);
					
					#echo $subNAV;
                }
				if (isset($_GET["subNAVselected"])){
					/* as per specification clicking a anchor tag will ony display that tag. clicking study and then research degree in the example given
					 redirects to to research anchor tag and sub menu which was not detailed in the current specs. as such clicking study and then research degrees will only display "research degrees selected from nav menus" and will not redirect
					 * */
					$inner =  $navLists[$_GET['MainNavSelected']][$_GET["subNAVselected"]];
					$content = html_headings($inner,3);
					#echo $content;
				}
				else{
					$content = html_headings($navLists['main'][$_GET['MainNavSelected']],3);
					#echo $content;
				}
				
            }
			else{
				$content = html_headings("Home Page",3);
			}
			$htmlTemplate = file_get_contents('pageTemplate.html');

			#was getting a bug where on intial load of screen subnav would come up as undefined even when defining it as an emptystring
			# below handles that.
			if (!isset($subNAV)){
				$subNAV = "";
			}
			echo str_replace(['[+title+]','[+header+]','[+mainNAV+]','[+subNAV+]','[+content+]'],[$title,$header,$mainNav,$subNAV,$content],$htmlTemplate);
?>
