<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" type="text/css" href="upload.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<head>
	<meta charset="UTF-8">
	<title>Upload</title>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">TGL</a>
        </div>

        <div class="collapse navbar-collapse " id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="upload.php">Upload</a></li>
                <li><a href="look_and_search.php">Look & search</a></li>
                <li><a href="index.php">TGL</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sort by...<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
    <div id="main">
        <h1>UPLOAD NEW PHOTO</h1>
        <form id="in_form" action="../model/save_img.php" enctype="multipart/form-data" method="POST">
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        <!--put all files in $_FILES with array 'upload_file[]' to work with them after-->
                        <!--if files weren't chosen, the button "upload_sb" will not submit request of uploading-->
                        Browse&hellip; <input id="check_empty" required type="file" name="upload_file[]" style="display: none;" multiple accept="image/*">
                    </span>
                </label>
                <input id='preview_file' type="text" class="form-control" readonly>
            </div>
            <button id="upload_sb" type="submit" class="btn btn-primary btn-block" value="UPLOAD">UPLOAD</button>
        </form>
    </div>
</body>
</html>
<script>
    //got this function from stackoverflow
    //its shows for user, the file which he choose or the number of chosen files
    $(function() {
        // We can attach the `fileselect` event to all file inputs on the page
        $(document).on('change', ':file', function() {
            var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
        });
        // We can watch for our custom `fileselect` event like this
        $(document).ready( function() {
            $(':file').on('fileselect', function(event, numFiles, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = numFiles > 1 ? numFiles + ' files selected' : label;

                if( input.length ) {
                    input.val(log);
                } else {
                    if( log ) alert(log);
                }
            });
        });
    });
</script>
