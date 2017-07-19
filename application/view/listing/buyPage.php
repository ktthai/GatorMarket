
<div class="container">
   <h1>Thank you for your purchase!</h1>
   <p>The seller has been contacted.</p>
   <h2><?php echo $singleListing[0]->getTitle();?></h2>
   <h2>$<?php echo $singleListing[0]->getPrice();?></h2>
   <?php echo $singleListing[0]->displayImage();?>
   <h3><?php echo 'Seller email: '.$email;?></h3>
</div>

