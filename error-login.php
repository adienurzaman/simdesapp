<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

    <head>

        <title>...Redirecting...</title>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

        <meta name="description" content="Expand, contract, animate forms with jQuery wihtout leaving the page" />

        <meta name="keywords" content="expand, form, css3, jquery, animate, width, height, adapt, unobtrusive javascript"/>

		<link rel="shortcut icon" href="images/title.png" type="image/x-icon"/>

        <link rel="stylesheet" type="text/css" href="css/login.css" />



    </head>

    <body>

		<div class="wrapper">

			

			<div class="content">

				<div id="form_wrapper" class="form_wrapper">

		   

<?php

// Warning Error To Login Admin Page

$error_login = "Maaf, Username atau Password yang Anda Masukan Tidak Tepat";



// View Error Message To Browser

#echo "<img src=\"images/kali.png\" width=\"30\" height=\"31\" align=\"absmiddle\" class=\"img_lock\"/> $error_login ";

echo "<script>alert('Maaf, Username atau Password yang Anda Masukan Tidak Tepat'); </script>";

echo "<meta http-equiv='refresh' content='0; url=index.php'>";

?>

					</form>

                    

					</div>

				<div class="clear"></div>

			</div>

			</div>

		

    </body>

</html>