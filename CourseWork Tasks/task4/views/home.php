<?php


$headTitle = 'PHP Cwk2 Home Page';
$viewHeading = htmlHeading('Home Page View',2);

$heading = htmlHeading("Home Page View", 2);
$content = generate_existing_users1($variables,$pdo);
$content .= htmlParagraph("The last view a user was browsing should be saved as a Cookie and re-load on subsequent login for up to one week for that user");


?>
