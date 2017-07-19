<div class="container">

<?php
   switch($choice)
   {
   case "browse":
     $choiceOne='listing/browse?catagory=' . $browseTerm . '&page=' . ($page+1);
     $choiceTwo='listing/browse?catagory=' . $browseTerm . '&page=' . ($page-1);
     break;
   case "search":
   ?>
      <h2>Showing Results <?php echo $row+1 ?> - <?php echo $loopEnd ?> Out Of <?php echo sizeOf($array) ?> </h2>
   <?php
      $choiceOne='listing/searchListing?catagory=' . $browseTerm . '&searchKey=' . $searchKey . '&page=' . ($page+1);
      $choiceTwo='listing/searchListing?catagory=' . $browseTerm . '&searchKey=' . $searchKey . '&page=' . ($page-1);
      break;
   case "home":
   ?>
      <h2>Welcome to Gator Market, the marketplace for SF State Students!</h2>
   <?php
      $choiceOne='?page=' . ($page+1);
      $choiceTwo='?page=' . ($page-1);
      break;
   case "user":
   ?>
     <h2>Your Listing for Sale</h2>
   <?php
      $choiceOne='user/viewAccount?page=' . ($page+1);
      $choiceTwo='user/viewAccount?page=' . ($page-1);
   }
?>

<?php
    for(; $row < $loopEnd; $row++){?>
      <div class='listing_small'>
      <div class='title_box'>
      <?php $array[$row]->getURL()?>
      <?php if($choice == "home"|| $choice == "search"){?><h3>Buy</h3><?php }; ?>
      <h1><?php echo $array[$row]->getTitle()?></h1><br>
      <h2>$<?php echo $array[$row]->getPrice()?></h2><br>
      </div>
      <?php $array[$row]->displayImage()?>
      </div>
<?php
     }
?>
    </div>
<div class="container">
<?php
   if($page>1)
   {
?>
    <p class="next_button">
      <a href="<?php echo URL . $choiceTwo?>">Previous</a>
    </p>
<?php
   }
   if(sizeOf($array)>$loopEnd){
?>
    <p class="next_button"> 
      <a href="<?php echo URL . $choiceOne;?>">Next</a>
    </p>
<?php
   }

?>
</div>

