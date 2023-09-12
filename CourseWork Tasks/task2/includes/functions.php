<?php

function html_Paragraph($text) {
    $html = htmlentities($text);
    return "<p>$html</p>";
    }

function html_headings($text,$level) {
    $html = htmlentities($text);
    return "<h$level>$html</h$level>";
}

# the function directly below is what is exported to index php file. string concatenation makes this process easier.
# looked at how tables and rows are defined on w3schools and it just following the pattern after this.

// basically the same as the task4 coursework 1 but the rows and columns are reversed
function generate_table2($grades,$grade_format){
    $html = "<table>";
    $size = sizeof($grades);
    for ($i = 0; $i< $size;$i++){
        $html.= "<tr>";
        $html.= generate_table_row($grades,$grade_format,$i);
        $html .= "</tr>";
    }
    #$html .= generate_table_header($grade_format);
    #$html .= generate_table_cell($grades);
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

?>