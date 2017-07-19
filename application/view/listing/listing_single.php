<div class='listing_single'>
     <?php echo $singleListing[0]->displayImage();?><br>
     <h1 class='listing_title'><?php echo $singleListing[0]->getTitle();?></h1>
     <h2 class='listing_price'>$<?php echo $singleListing[0]->getPrice();?></h2>
     <h3 class='listing_description'><?php echo $singleListing[0]->getDescription();?></h3>

     <?php if(isset($_SESSION['user'])) { ?>
     <form method="post" action="<?php echo URL . 'listing/buyPage?listingNum='. $singleListing[0]->getListingNum(); ?>">
     <?php }
      else{ ?>
      <form action="<?php echo URL . 'user/login'; ?>">
      <?php }?>
     <input type="submit" value="Buy!">
     </form>
</div>

