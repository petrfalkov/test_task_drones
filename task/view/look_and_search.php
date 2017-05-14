<?php
define("COUNT_PER_PAGE", 6);
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" type="text/css" href="look_and_search.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="animated_images.js"></script>

<head>
    <meta charset="UTF-8">
    <title>Look & Search</title>
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

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
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

            <form class="navbar-form" role="search" action="look_and_search.php" method="post">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
							<button type="submit" class="btn btn-default">
								<span class="glyphicon glyphicon-search">
									<span class="sr-only">Search...</span>
								</span>
							</button>
                    </span>
                </div>
            </form>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div id="myModal" class="modal">
        <img class='modal-content' id="img01">
        <textarea id="caption" readonly name='' id='' rows='5' cols='50' class='form-control descr_form' maxlength='2000'></textarea>
</div>
<div id="main" class="main">
    <?php
            require_once "../model/db/connection.php";
            //trying to get number of page, which one we will load (from where it starts to load files from db)
            //if receives nothing, setting defaults
            if ($_GET['page']) {
                 $page = (int)$_GET['page'];
                 if (!$page)
                     $page = 1;
            }
            else {
                $page = 1;
                $_GET['page'] = 1;
            }
            $start = ($page - 1) * COUNT_PER_PAGE; //from where it starts to load files from db
            $qry; // trying to get 'search' value from Post array, but sesstion is always new, as a result of my bad structure of infinite scroll =(
            if (isset($_POST['search'])) {
                $searchq = $_POST['search'];
                $searchq = preg_replace("#[^0-9a-z]#i","", $searchq );
                $qry = "select * from `photos` where `photo_dscr` like '%".$searchq."%' order by `photo_id` limit ". $start . ",".COUNT_PER_PAGE;
            }
            else
                $qry = "SELECT * FROM `photos` ORDER BY `photo_id` LIMIT ". $start .",".COUNT_PER_PAGE;
            $result=mysql_query($qry);
            if (mysql_num_rows($result) == 0)
                echo "<script>
                            var nothing_found = '<div style=\"color: black\">Sorry, there is nothing more to look for</div>';
                            $('#main').append(nothing_found);
                        </script>";
            $photo1 = ''; $photo2 = ''; $dscr_photo1 = ''; $dscr_photo2 = ''; $ident = 0;
            //while there are rows in our array from db, it forms new <div>-blocks and put some info inside of it
            while ($row = mysql_fetch_array($result)) {
                if ($ident == 0) { //I want to place 2 photos in 1 div, so the code waits for next row, if there is only one left, it will put only one photo in div
                    $dscr_photo1 = $row['photo_dscr'];
                    $photo1 = $row['photo_content'];
                    $ident = 1;
                } else {
                    $ident = 0;
                    $dscr_photo2 = $row['photo_dscr'];
                    $photo2 = $row['photo_content'];
                    echo "<script>
                        var newRowContent = '<div>' +
                         '<a style=\"text-decoration: none;\">' +
                            '<div name=\"".$dscr_photo1."\" id=\"../model/".$photo1."\" style=\"background-image: url(\'../model/" . $photo1 . "\')\" class=\"smaller-img references_upld_lk\">' +
                            '</div>' +
                         '</a>' +
                         '<a style=\"text-decoration: none;\">' +
                            '<div name=\"".$dscr_photo1."\" id=\"../model/".$photo2."\" style=\"background-image: url(\'../model/" . $photo2 . "\')\" class=\"smaller-img references_upld_lk\">' +
                            '</div>' +
                         '</a>' +
                       '</div>';
                        $('#main').append(newRowContent);
                        </script>";
                    $photo1 = $photo2 = $dscr_photo2 = $dscr_photo1 = '';
                }
            }
            if ($photo1 !== '') {
                echo "<script>
                        var newRowContent = '<div>' +
                         '<a style=\"text-decoration: none;\">' +
                            '<div name=\"".$dscr_photo1."\" id=\"../model/".$photo1."\" style=\"background-image: url(\'../model/" . $photo1 . "\')\" class=\"smaller-img references_upld_lk\">' +
                            '</div>' +
                         '</a>' +
                      '</div>';
                        $('#main').append(newRowContent);
                      </script>";
            }
            session_write_close();
            ?>

</div>
<div class="load"></div>
</body>
</html>
<script>
    $(document).ready(function() {
        var page;
        var param = location.
                    search.
                    slice(location.search.indexOf('?') + 1).
                    split('&');
        var result = [];
        for (var i = 0; i < param.length; i++){
            var res = param[i].split('=');
            result[res[0]] = res[1];
        }
        if (result['page']) {
            page = result['page'];
        } else {
            page = 1;
        }
        var block = false; //block doesn't let user send another request on server by scrolling, before all actions will be done
        //"infinite scroll" (uploading files) pagination
        $('#main').scroll(function () { //trigger function when user scroll "main"-block
            //if scroll-value + height_of "main"-block is bigger than height_of_"main"-block times count_pages(how much times new content was loaded)
            // then trigger function
            if ($("#main").scrollTop() + $("#main").height() >= $("#main").height() * (page) && !block) {
                block = true;                       //block trigger function
                $('.load').fadeIn(0, function () { //when it starts loading content
                    page++;
                    //put in method "$_GET" new data about page
                    $.ajax({
                        url: "look_and_search.php",
                        type: "get",
                        data: "page=" + page + "&move=1",
                        success: function (html) {
                            var ind;
                            //get the html-code of our site, to form new divs
                            if (html) {
                                var norm = "";
                                var temp = html.substring(html.indexOf("<div id=\"main") + 4);
                                temp = temp.substring(temp.indexOf("<script"), temp.indexOf("<div class=\"load"));
                                 ind = temp.indexOf("script");
                                //check if there's anything to load
                                if (ind != -1) {
                                    $(temp).appendTo($("#main")).hide().fadeOut(1000);
                                    $('.pager').text(page);

                                } else {
                                    //if not, we shouldn't increment the page-variable
                                    page--;
                                }
                            }
                            block = false;  //unblock triggering function by scrolling
                            $('.load').fadeOut(0);
                        }
                    });
                });
            }
        });

        /* There was problem with "infinite scroll" (uploading new elements by scrolling), they were created dynamically
            and ".click()" wasn't working, so that solved the problem. found the solution
            on stackoverflow, just need the right google request)
         */
        $("#main").on('click', '.smaller-img', function(event) {

            var modal = document.getElementById('myModal');
            modal.style.display = "block";

            var modalImg = document.getElementById("img01");
            modalImg.src = event.target.id;

            var width_of_image = modalImg.width; //getting width for choosing size of description block for small screens
            var height_of_block;
            if (width_of_image >= 650)
                height_of_block = modalImg.height - 22 + "px";
            else
                height_of_block = modalImg.height / 3.5;
            var captionText = document.getElementById('caption');
            $("#caption").height(height_of_block);
            captionText.innerHTML = event.target.getAttribute('name'); //put description in block, received from 'name' atr

            var span = document.getElementsByClassName("modal")[0];
            // when the user clicks on <span>, close the modal
            span.onclick = function() {
                modal.style.display = "none";
            };
        });

        $(".smaller-img").click(function(event) {

            var modal = document.getElementById('myModal');
            modal.style.display = "block";

            var modalImg = document.getElementById("img01");
            modalImg.src = event.target.id;

            var width_of_image = modalImg.width;//getting width for choosing size of description block for small screens
            var height_of_block;
            if (width_of_image >= 650)
                height_of_block = modalImg.height - 22 + "px";
            else
                height_of_block = modalImg.height / 3.5;
            var captionText = document.getElementById('caption');
            $("#caption").height(height_of_block);
            captionText.innerHTML = event.target.getAttribute('name');//put description in block, get from 'name' atr

            var span = document.getElementsByClassName("modal")[0];
            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            };
        });
    });

    $(function () {
        function closeSearch() {
            var $form = $('.navbar-collapse form[role="search"].active');
            $form.find('input').val('');
            $form.removeClass('active');
        }

        // Show Search if form is not active // event.preventDefault() is important, this prevents the form from submitting
        $(document).on('click', '.navbar-collapse form[role="search"]:not(.active) button[type="submit"]', function(event) {
            event.preventDefault();
            var $form = $(this).closest('form'),
                $input = $form.find('input');
            $form.addClass('active');
            $input.focus();
        });

        $('form').submit('click', '.navbar-collapse form[role="search"].active button[type="submit"]', function(event) {
            event.preventDefault();
            var $form = $(this).closest('form'),
                $input = $form.find('input');
            $('#showSearchTerm').text($input.val());
            closeSearch();
        });
    });
    // Get the image and insert it inside the modal - use its "alt" text as a caption
</script>