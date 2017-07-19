<?php
/**
 * The Listing class that extends to the DatabaseController.
 */
class Listing extends DatabaseController
{
    /**
     * The browse is a function that handles the browsing for the listings on a page.
     */
    public function browse()
    {
      $browseTerm = $_GET['catagory'];
      $page = $_GET['page'];
      $result = $this->model->browse($browseTerm);
      $array = $this->model->getListings($result);

      if($page == 1) $row = 0;
      else $row = ((($page-1)*10)+1);

      $loopEnd = $row+12;
      if($loopEnd> sizeOf($array))
      {
        $loopEnd = sizeOf($array);
      }
      $choice = "browse";
      require APP . 'view/_templates/header.php';
      require APP . 'view/_templates/left_nav.php';
      require APP . 'view/listing/result.php';
      require APP . 'view/_templates/footer.php';
    }
 
    /**
     * The searchListing is a function that handles the searching algorithm on the site.
     */
    public function searchListing()
    {
      if(!isset($_GET['searchKey'])) $searchKey = $_POST['searchKey'];
      else $searchKey = $_GET['searchKey'];
      if(!isset($_GET['catagory'])) $browseTerm = $_POST['catagory'];
      else $browseTerm = $_GET['catagory'];
      if($browseTerm == "all")
      {
        $browseTerm = '';
      }

      $result = $this->model->searchListing($browseTerm, $searchKey);
      $array = $this->model->getListings($result);
      if(!isset($_GET['page']) || ($_GET['page']==1))
      {
        $page = 1;
        $row = 0;
      }
      else
      {
        $page = $_GET['page'];
        $row = ((($page-1)*10)+1);
      }
      $loopEnd = $row+12;
      if($loopEnd> sizeOf($array))
      {
        $loopEnd = sizeOf($array);
      }

      $choice = "search";
      require APP . 'view/_templates/header.php';
      require APP . 'view/listing/result.php';
      require APP . 'view/_templates/footer.php';
    }

    /**
     * The addListingPage is a function that accesses the header, addItem, and footer pages in the view directory.
     */
    public function addListingPage()
    {
      require APP . 'view/_templates/header.php';
      require APP . 'view/listing/addItem.php';
      require APP . 'view/_templates/footer.php';
    }

    public function listingPage()
    {
      
      $result = $this->model->singleListing($_GET['listingNum']);
      $singleListing = $this->model->getListings($result);
      require APP . 'view/_templates/header.php';
      require APP . 'view/listing/listing_single.php';

      require APP . 'view/_templates/footer.php';
    }

    /**
     * The addListing function is responsible for storing listing information into blobs.
     */
    public function addListing()
    {
      if(isset($_POST['submit']))
      {
        $blob = file_get_contents($_FILES['image']['tmp_name']);
        $imageType = $_FILES['image']['type'];
          if(substr($imageType,0,5) == "image")
          {
            $res =$this->model->addListing($_POST['title'], $_POST['price'], $blob, $_POST['description'], $_POST['tag'], $_POST['sellerID']) ; 
          } 
      }
      header('location: ' . URL . 'listing/addListingPage');
      if($res)
      {
        echo"your listing has been uploaded";
      }
      else{echo "we could not upload your listing";}
    }

    public function buyPage()
    {
	$result = $this->model->singleListing($_GET['listingNum']);
        $singleListing = $this->model->getListings($result);
 	$seller = $this->model->getSeller($this->model->sellerFromID($singleListing[0]->getId()));
	$email = $seller->getEmail();
	require APP . 'view/_templates/header.php';
	require APP . 'view/listing/buyPage.php';
	require APP . 'view/_templates/footer.php';
    }    
}

