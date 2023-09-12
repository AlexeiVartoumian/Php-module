<?php
	require_once 'variables.php';
		
		function sub_nav_choice($parameter){
			switch (True) {
				case $parameter == "study":
					return $parameter;
					break;
				case $parameter == "res":
					return $parameter;
					break;
				case $parameter == 'sem':
					return $parameter;
					break;
			}
			}
		function main_Nav ($navLists){
			foreach ($navLists as $key => $value){
				
				if ($key == 'main'){
					
					$content = html_NAV($navLists[$key],"MainNavSelected");
					return $content;
				}
			}

		}
		
		function html_headings($text,$level) {
				if ($level == 3){
					$sentence_filler  = "was selected from the nav menus";
					$html = htmlentities($text);
					return "<h$level>$html $sentence_filler</h$level>";
				}else{
					$html = htmlentities($text);
					return "<h$level>$html</h$level>";
				}

				
			}
		function html_NAV($navData,$URLparams) { 
					/* this function had to be modified so as to match the example given since thier navbar do not have nested ul or li element.
					I guess this is the only way to make the navbar inline without css* */
						$html = '<nav>'; 
						$html.="| ";
						foreach ($navData as $key => $menuitem) { #build the NAV links
							$html.= generate_inline_navbar_without_css($URLparams,$key,$menuitem,$html);
						}
						$html .= '</nav>';
						return $html;
					}
		function generate_inline_navbar_without_css($URLparams,$key,$menuitem,$html){

				$html = "<a href=\"index.php?$URLparams=$key\">$menuitem  | </a>";
				
				return $html;
		}
		
		?>