<!DOCTYPE html>
<html lang="en">
<?php session_start(); ?>
<head>
    <meta charset="utf-8">
    <title>MINI</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- JS -->
    <!-- please note: The JavaScript files are loaded in the footer to speed up page construction -->
    <!-- See more here: http://stackoverflow.com/q/2105327/1114320 -->

    <!-- CSS -->
    <link href="<?php echo URL; ?>css/style.css" rel="stylesheet">
</head>
<body>

<!-- Google Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81979201-1', 'auto');
  ga('send', 'pageview');

</script>

<!-- Content -->
<div class="content">
    <div class="header_content">

    <!--- Login / Create Account Box -->
    <div class="login">
        <?php 
        if(!isset($_SESSION['user']))
        { 
          echo '<a href="'.URL.'user/login">Login</a>';
          echo '<br> <br>';
	  echo '<a href="'.URL.'user/createAccount">Create Account</a>';
        }
        else
        {
          echo '<a href="'.URL.'user/logout">Logout</a>';
	  echo '<br><br><a href="'.URL.'user/viewAccount">View Account</a>';     
        }
        ?>
    </div>

    <!-- logo and title -->	
    <a href="<?php echo URL; ?>home/index"><img class="logo" src="https://mgtvsportzedge.files.wordpress.com/2014/11/sfsu-gators.png" alt="Gator Market Logo"></a>
    <h1>Gator Market</h1>
    <div class="site_title">    
        <h2>SFSU Computer Science Student Project. For demonstration only.</h2>
    </div>  

    <!-- navigation -->
    <div class="navigation">
        <div class="center_align">
        <?php
        if(isset($_SESSION['user']))
        {
          echo '<a href="'.URL.'listing/addListingPage">Sell Something</a>';
        }
        else
        {  
          echo '<a href="'.URL.'user/login">Sell Something</a>';
        }
        ?>

	<form  method="post" action="<?php echo URL; ?>listing/searchListing" id="searchForm">
		<select class="search_menu" name="catagory">
			<option value="all"<?php if(!isset($browseTerm)){echo "SELECTED";}?>>All</option>
			<option value="book"<?php if(isset($browseTerm)&& $browseTerm =='book'){echo "SELECTED";}?>>Books</option>
			<option value="furniture"<?php if(isset($browseTerm)&& $browseTerm =='furniture'){echo "SELECTED";}?>>Furniture</option>
			<option value="electronics"<?php if(isset($browseTerm)&& $browseTerm =='electronics'){echo "SELECTED";}?>>Electronics</option>
			<option value="vehicles"<?php if(isset($browseTerm)&& $browseTerm =='vehicles'){echo "SELECTED";}?>>Vehicles</option>
			<option value="apparel"<?php if(isset($browseTerm)&& $browseTerm =='apparel'){echo "SELECTED";}?>>Apparel</option>
			<option value="housing"<?php if(isset($browseTerm)&& $browseTerm =='housing'){echo "SELECTED";}?>>Housing</option>
			<option value="other"<?php if(isset($browseTerm)&& $browseTerm =='other'){echo "SELECTED";}?>>Other</option>
		</select>
 		<input class="search_bar" type="text" name="searchKey" value="<?php if(isset($searchKey))echo $searchKey;else echo ''?>">
		<input class="search_button" type="submit" name="submit" value="Search" >
	</form>
	</div>
    </div>
    </div>


