<?php
require_once "includes/config.php";
require_once "includes/functions.php";

$title = "Admin View";
$heading = htmlHeading("Admin View - show all user browsing history",2);

$content = retrieve_cookies($_COOKIE,fetch_usernames_for_admin_page($variables,$pdo));

$heading = htmlHeading("Admin page view Page View", 2);



?>