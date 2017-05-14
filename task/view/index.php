<!----------------------------------------------------------------------------------------->
<!-- Main page of resource, here are two choices:                                        -->
<!--    - "add new Photos" - let the user add new Photos in base;                        -->
<!--    - "Look and Search" - let the user search and look for photos which were already -->
<!--       uploaded.                                                                     -->
<!----------------------------------------------------------------------------------------->

<!DOCTYPE html>
<html lang="en" >
<link rel="stylesheet" type="text/css" href="index.css">
<head>
    <meta charset="UTF-8">
    <title>Drone Assets</title>
</head>
<body>
<form id="in_form" action="../model/db/setup.php" method="POST">

<table>
    <tr>
        <td id="logo_di">
           THE GREAT LIBRARY <br>of Alexandria
        </td>
        <td>
            <a href="http://en.unesco.org/" target="_blank"><img id="unesco_logo" align="right" src="src/UNESCO_logo_English.svg.png"></a>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <a href="upload.php" type="submit" style="text-decoration: none"><div id="upload" class="smaller-img references_upld_lk">UPLOAD<br>NEW<br>PHOTO</div></a>
            <a href="look_and_search.php" type="submit" style="text-decoration: none"><div id="look" class="smaller-img references_upld_lk">LOOK<br>&<br>SEARCH</div></a>
        </td>
    </tr>
</table>
</form>
</body>
</html>

<?php
session_start();
?>