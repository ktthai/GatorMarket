<div class="container">
  <div class="center_box">
  <div class="grey_box">
  <div class="left_align">
  <form action="<?php echo URL; ?>listing/addListing"  method="post" enctype="multipart/form-data">
    <h2>Add Item for Sale</h2>
    <h4>Name of Item:</h4><input type="text" name="title" maxlength="30"><br />
    <h4>Price:</h4><input type="text" name="price" maxlength="7"><br />
    <h4>Tag:</h4><br>
    <input type="checkbox" class="radio" name="tag" value="book">Book<br>
    <input type="checkbox" class="radio" name="tag" value="furniture">Furniture<br>
    <input type="checkbox" class="radio" name="tag" value="electronics">Electroncs<br>
    <input type="checkbox" class="radio" name="tag" value="vehicles">Vehicles<br>
    <input type="checkbox" class="radio" name="tag" value="apparel">Apparel<br>
    <input type="checkbox" class="radio" name="tag" value="housing">Housing<br>
    <input type="checkbox" class="radio" name="tag" value="other">Other<br>

    <h4>Description:</h4><textarea name="description" maxlength="500" cols="50" rows ="5"></textarea><br />
    <h4>Image:</h4><input type="file" name="image"><br />
    <input type="hidden" name="sellerID" value="<?php echo $_SESSION['user']->getID(); ?>">
    </div>
    <input class="submit_button" type="submit" name="submit">
  </form>
  </div>
  </div>
</div> 

