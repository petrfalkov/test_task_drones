<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

<!------------------------------------------------------------------------------------------------->
<!-- For search photos and to not lose information, asking user to put description about photo.  -->
<!-- If description is empty, button "upload_sb" will not submit request and will output warning.-->
<!-- If description(s) is(are) filled, button "upload_sb" will submit request and call           -->
<!-- "put_images_in_db.php" script which then add files with descriptions into base.             -->
<!------------------------------------------------------------------------------------------------->

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" type="text/css" href="save_img.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<head>
	<meta charset="UTF-8">
	<title>Save Image</title>
</head>
<body>
    <div id="main">
        <form method="post" action="put_images_in_db.php">
        <table id="table_preview">
            <thead>
                <h1>ADD A DESCRIPTION</h1>
            </thead>
           <tbody id="t_body">
            <?php
            require_once "db/setup.php";
            session_start();
                foreach ($_FILES["upload_file"]["error"] as $key => $error) {
                    try { //checking for an error of uploading, if file uploaded with and error, getting next one
                        if ($error == UPLOAD_ERR_OK) {
                            //getting "path" of file from $_FILES
                            $path = "temp_files/" . $_FILES['upload_file']['name'][$key];
                            //moving file into temp directory
                            move_uploaded_file($_FILES["upload_file"]["tmp_name"][$key],
                                "temp_files/" . $_FILES["upload_file"]["name"][$key]);
                            //adding specified newRowContent (new row) in our table
                            //Which contains the current photo and text_area - with same name and id of photo, to add description about it
                            echo "<script>
                                    var newRowContent = '<tr><td><div class=\'input-group\'>' +
                                    '<label class=\'input-group-btn\'>' +
                                    '<img src=\'$path\' class=\'descr_form_img\'>' +
                                    '</label><textarea required name=\'$path\' id=\'$path\' rows=\'5\' cols=\'50\' class=\'form-control descr_form\' maxlength=\'2000\'></textarea>' +
                                    '</div></td></tr>';" . "$('#table_preview tbody').append(newRowContent);
                                  </script>";
                            require_once "db/connection.php";
                            $image = addslashes("temp_files/" . $_FILES['upload_file']['name'][$key]);
                            $name = addslashes("temp_files/" . $_FILES['upload_file']['name'][$key]);
                            $name = substr($name, 0, strrpos($name, '.', -1));
                            //attempt to Load files into base... failure
//                            $image = file_get_contents($image);
//                            $image = base64_encode($image);
                            $check_duplicate = mysql_num_rows(mysql_query("SELECT * FROM `photos`
                              WHERE `photo_name`='" . $name . "'"));
                            //if the duplicate is not found - upload the info about file into database
                            if ($check_duplicate == 0) {
                                $img = "INSERT INTO `photos` (`photo_id`, `photo_dscr`, `photo_name` ,`photo_content`, `photo_likes`, `photo_time`) VALUES (NULL, NULL, '" . $name . "' ,'" . $image . "', '0', CURRENT_TIMESTAMP)";
                                mysql_query($img);
                            }
                        }
                    } catch (ErrorException $errorException) {
                        error_log($errorException->getMessage());
                        continue ;
                    }
                }
            ?>
            </tbody>
        </table>
        <button name="upload_sb" id="sub_but" type="submit" class="btn btn-primary btn-block btn-lg" value="UPLOAD">UPLOAD</button>
        </form>
    </div>
</body>
</html>
<script>
     /******************************************\
    |*Check empty input in the description form*|
     \*****************************************/
    document.addEventListener("DOMContentLoaded", function() {
        var elements = document.getElementsByTagName("textarea");
        for (var i = 0; i < elements.length; i++) {
            elements[i].oninvalid = function(e) {
                e.target.setCustomValidity("");
                if (!e.target.validity.valid) {
                    e.target.setCustomValidity("Description cannot be empty");
                }
            };
            elements[i].oninput = function(e) {
                e.target.setCustomValidity("");
            };
        }
    });
</script>