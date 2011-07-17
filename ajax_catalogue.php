<?php

  /*
   * Implementing OGP + Multiple like buttons without reloading the page by using JavaScript.
   * Developed by Daniel Torvisco - dani.torvisco@fb.com
   *
   */
?>
<?php

  /*
   * Initialize OG meta tags for each specific item
   */
    
    if (isset($_GET["item_id"]) && $_GET["item_id"]!="") {
        $item_id = $_GET["item_id"];
    }
    else {
        $item_id = "1xyz"; //default item
    }
    
    //perform here your db queries to extract relevant info of this item_id
    $url = "http://dani.fbdublin.com/how-to/ajax_catalogue.php?item_id=" . $item_id; //item canonical URL
    $title = "This is the title of item Number " . $item_id;
    $description = "This is the description of item Number " . $item_id;
    $image = "http://dani.fbdublin.com/how-to/images/item" . $item_id . ".jpg";   
    $og_object_type = "product";
?>

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <title>Implementing OGP + Multiple like buttons without reloading the page by using JavaScript</title>

        <meta property="og:title" content="<?php echo $title; ?>" />
        <meta property="og:description" content="<?php echo $description; ?>" />
        <meta property="og:type" content="<?php echo $og_object_type; ?>" />
        <meta property="og:url" content="<?php echo $url; ?>" />
        <meta property="og:image" content="<?php echo $image; ?>" />
        <meta property="og:site_name" content="Facebook Dublin" />
        <meta property="fb:admins" content="551840413" />

    </head>
    <body style="font-family: Arial; font-size:12px;">

        <div id="menu">
            <div id="1xyz" name="item1xyz">Go to item 1xyz</div>
            <div id="2xyz" name="item2xyz">Go to item 2xyz</div>
            <div id="3xyz" name="item3xyz">Go to item 3xyz</div>
        </div>

        <div id="item" style="clear:both;padding-top:15px;">
            <h1><?php echo $title; ?></h1>
            <h2><?php echo $description; ?></h2>
            <img src="<?php echo $image; ?>" border="0"></img>

            <div id="fb-root"></div>
            <fb:like href="<?php echo $url; ?>" send="false" width="450" show_faces="true" layout="button_count" font=""></fb:like>
        </div>

        <script src="http://connect.facebook.net/en_US/all.js#appId=104502489640174&amp;xfbml=1"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                
                //styling the top menu
                $('div[name^="item"]').css({'float' : 'left', 'cursor' : 'pointer', 'width' : '200px'});

                //detect when an item has been selected from the top menu
                $('div[name^="item"]').click(function() {
                    
                    //perform here your AJAX requests to get JSON item info from "this" item id
                    var title = "This is the title of item Number "+$(this).attr("id");
                    var description = "This is the description of item Number "+$(this).attr("id");
                    var image = "http://dani.fbdublin.com/how-to/images/item"+$(this).attr("id")+".jpg";
                    var url = "http://dani.fbdublin.com/how-to/ajax_catalogue.php?item_id="+$(this).attr("id"); //item canonical URL
                    
                    //styling the selected item on the top menu
                    $('div[name^="item"]').css("font-weight","normal");
                    $("#"+$(this).attr("id")).css("font-weight","bold");
                    
                    //displaying new item
                    $("#item h1").text(title);
                    $("#item h2").text(description);
                    $("#item img").attr("src",image);
                    
                    //changing meta data. This is Optional, not really necessary
                    $('meta[property="og:title"]').attr('content', title);
                    $('meta[property="og:description"]').attr('content', description);
                    $('meta[property="og:image"]').attr('content', image);
                    $('meta[property="og:url"]').attr('content', url);
                    
                    //removing the previous like button
                    $("#fb-root").next().remove();
                    
                    //creating new like button pointing to the new URL
                    $("#fb-root").after('<fb:like href="'+url+'" send="false" width="450" show_faces="true" layout="button_count" font=""></fb:like>');
                    
                    //generating a new iframe by parsing the new created XFBML like button
                    FB.XFBML.parse(document.getElementById('item'));
                    
                });
                
            });
        </script>

        <?php
            echo '<hr />';
            show_source(__FILE__);    
        ?>

    </body>
</html>