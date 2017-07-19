<?php

/**
* The Model class is the bridge between the control and the view. 
*/
class Model
{
    /**
     * function __construct handles by trying  to check if there is a connection to the database and if there is not, it catches and displays the error.
     * @param $db is the variable that represents the database
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    /**
     * addListing is a function that is responsible for adding the titles, prices, and images of a listing.
     * @param $title is the title of a listing
     * @param $price is the price of a listing
     * @param image is the image of a listing
     */
    public function addListing($title, $price, $image, $description, $tag, $sellerID)
    {
      //print_r($_SESSION['userID']);
      $sql = "INSERT INTO listing(title, price, image, description, tag, sellerID) VALUES(:title, :price, :image, :description, :tag, :sellerID)";
      $query = $this->db->prepare($sql);
      $parameters = array(':title' => $title,':price' => $price, ':image' => $image, 'description' => $description, ':tag' => $tag, ':sellerID' => $sellerID);
      $query->execute($parameters);        
    }

    /**
     * varifyUser is a function that checks for a valid user ID and password to access site.
     * @param $id is a 9-digit number that represents the student's SFSU ID
     * @param $password is the password created by the user
     */
    public function varifyUser($id, $password)
    {
      $passwordHash = sha1($password);	
      $sql = "SELECT * FROM user WHERE id= '$id' AND password= '$passwordHash'";
      $query = $this->db->prepare($sql);
      $query->execute();
      $result = $query->fetch(PDO::FETCH_OBJ);
 
      if($result == null)
      {
        echo "You have entered the wrong information";
        exit();
      }
      else{echo "You have logged in successfully";header("Refresh:2;url=".URL);}

      $user = new UserObject($result);
      return $user;
    }

    /**
     * singleListing is a function that handles the searching of listings based on listing tags.
     * @param $listingNum are words that are used to find a specific listing in a search
     * @return string $result which displays listings with matched keywords
     */
    public function singleListing($listingNum)
    {
      //this will return a PDO object with all the results from th query so we can generate all the listing objects
      $sql = "SELECT * FROM listing WHERE listingNum = '$listingNum'";
      $query = $this->db->prepare($sql);
      $query->execute();
      $result = $query->fetchAll();
      return $result;
    }

    /**
     * browse is a function that handles the searching of listings based on listing tags.
     * @param $browseTerm are words that are used to find a specific listing in a search
     * @return string $result which displays listings with matched keywords
     */
    public function browse($browseTerm)
    {
      //this will return a PDO object with all the results from th query so we can generate all the listing objects
      $sql = "SELECT * FROM listing WHERE tag LIKE '$browseTerm%'";
      $query = $this->db->prepare($sql);
      $query->execute();
      $result = $query->fetchAll();
      return $result;
    }


    /**
     * browseRecent is a function that returns the most recently added items first
     * @return string $result which displays listings with matched keywords
     */
    public function browseRecent()
    {
      //this will return a PDO object with all the results from th query so we can generate all the listing objects
      $sql = "SELECT * FROM listing ORDER BY datetime DESC";
      $query = $this->db->prepare($sql);
      $query->execute();
      $result = $query->fetchAll();
      return $result;
    }

    /**
     * userListings is a function that handles the searching of a listing when typed in the search bar.
     * @param $user are words that are used to find a specific listing in a search
     * @return string $result which displays listings with matched keywords
     */
    public function userListings($userID)
    {
      //this will return a PDO object with all the results from th query so we can generate all the listing objects
      $sql = "SELECT * FROM listing WHERE sellerID = '$userID'";
      $query = $this->db->prepare($sql);
      $query->execute();
      $result = $query->fetchAll();
      return $result;
    }
   
     public function sellerFromID($userID)
    {
      $sql = "SELECT * FROM user  WHERE id = '$userID'";
      $query = $this->db->prepare($sql);
      $query->execute();
      $result = $query->fetchAll();
      return $result;
    }

    /**
     * searchListing is a function that handles the searching of a listing when typed in the search bar.
     * @param $keywords are words that are used to find a specific listing in a search
     * @return string $result which displays listings with matched keywords
     */
    public function searchListing($browseTerm, $keywords)
    {
      //this will return a PDO object with all the results from th query so we can generate all the listing objects
      $sql = "SELECT * FROM listing WHERE tag LIKE '$browseTerm%' AND title LIKE '%$keywords%'";
      $query = $this->db->prepare($sql);
      $query->execute();
      $result = $query->fetchAll();
      return $result;
    }

    /**
     * getListings is a function that handles getting information for listings.
     * @param $result is the result display from searching for listings
     * @return string $newListing holds information of new listing objects to be displayed
     */ 
    public function getListings($result) 
    {
      //We will make this return an array of Listing objects to display
      $listingArray = array();
      foreach($result as $i) {       
        $newListing = new ListingObject($i);
        $listingArray[] = $newListing;
      }
     //$newListing =  new ListingObject($this->db, $result);
     return $listingArray;
    }

    public function getSeller($result)
    {
	$seller = new UserObject($result[0]);
	return $seller;
    }

    /**
     * createAccount is the function that allows a user to create an account on the site and asks for their id, name, pw, and email which would be stored.
     * @param $id the student SFSU ID
     * @param $name the name of the student creating an account
     * @param $password the password created by the student
     * @param $email the student's email address
     */
    public function createAccount($id, $name, $password, $email)
    { 
        if(!is_numeric($id))
	    {
		echo 'Please enter a vaild id number.';
	    exit();
	    }
	if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
	    echo 'Please enter a vaild email.';
	    exit();
	  
	}
	$passwordHash = sha1($password);
	$sql = "INSERT INTO user(id,name,password,email)VALUES(:id,:name,:password,:email)";
	$query = $this->db->prepare($sql);
	$parameters = array(':id'=>$id, ':name'=>$name, ':password'=>$passwordHash, ':email'=>$email);
	$query->execute($parameters);
	echo 'Account created';
    }
}

/**
 * ListingObject is a class that handles the listings as an object.
 */
class ListingObject
{
    public $Title = null;
    public $Price = null;
    public $Image = null;
    private $Description = null;
    private $Tags = array();
    private $ListingNum = null;
    private $ID = null;

    /**
     * __construct is a function that checks forthe database connection and instantiates objects for list tags
     * @param $db is the database
     * @param $result is result displayed
     */ 
    function __construct($result)
    {
        $this->Title = $result->title;
        $this->Price = $result->price;
        $this->Image = $result->image;
        $this->Description = $result->description;
        $this->Tags = $result->tag;
        $this->ListingNum = $result->listingNum;
	$this->ID = $result->sellerID;         
    }

    public function getURL()
    {
       echo '<a href="'.URL.'listing/listingPage?listingNum=' . $this->ListingNum . '"</a>';
    }

    /**
     * displayImage is a function that displays the image associated with the lisitng
     */
    public function displayImage()
    {
       echo '<img src="data:image/jpeg;base64,'.base64_encode($this->Image).'"/>' . "</a><br>";
    }

    public function getId()
    {
	return $this->ID;
    }

    /**
     * display is a function that displays the result tags of a listing
     */
    public function display()
    {
       echo '<a href="'.URL.'listing/listingPage?listingNum=' . $this->ListingNum . '"</a>' . $this->Title . "<br>";
       echo $this->Price . "<br>";
       echo '<img src="data:image/jpeg;base64,'.base64_encode($this->Image).'"/>' . "</a><br>";       
       //echo $this->Description . "<br>";
       // Display description and tags here
    }


    /**
     * displayAll is a function that displays the result tags of a listing
     */
    public function displayAll()
    {
       echo $this->Title . "<br>";
       echo $this->Price . "<br>";
       echo $this->Tags . "<br>";
       echo $this->Description . "<br>";

       echo '<img src="data:image/jpeg;base64,'.base64_encode($this->Image).'"/>' . "<br>";
    }


    
    /**
     * addTags is a function that is handles all the adding of tags of a listing
     * @param $Tags is the tags of a listing
     * @param $newTags are new tags that are added to tags
     */
    public function addTags($Tags, $newTags)
    {
	$this->Tags = array_merge($this->Tags, $newTags);
    }

    /**
     * getPrice gets the price of a listing
     * @return int Price of listing
     */
    public function getPrice()
    {
	return $this->Price;
    }	

    /**
     *  get Title is the name entered as a title for listing
     * @return string Title of the listing
     */
    public function getTitle()
    {
	return $this->Title;
    }

    /**
     * getImage gets the image of the listing and displays it
     * @return string Image of the listing
     */
    public function getImage()
    {
	return $this->Image;
    }

    /**
     * getDescription gets the information of the listing
     * @return string Description of the listing
     */
    public function getDescription()
    {
	return $this->Description;
    }
    
    /**
     * getTags gets the tags of a listing
     * @return int Tags of the listing
     */
    public function getTags()
    {
	return $this->Tags;
    }
    
     /**
     * getListingNum gets the listing number
     * @return int Tags of the listing
     */
    public function getListingNum()
    {
        return $this->ListingNum;
    }


    /**
     * setTitle sets the title of a listing
     * @param @title is the name of a listing
     */
    public function setTitle($title)
    {
	$this->Title = $title;
    }

    /** 
     * setPrice sets the price of a listing
     * @param $price is the cost of a listing
     */
    public function setPrice($price)
    {
	$this->Price = $price;
    }
   
    /**
     * setImage sets the image of a listing
     * @param $image is the image of a listing
     */
    public function setImage($image)
    {
	$this->Image = $image;
    }

    /**
     * setDescription sets a description of a listing
     * @param $description is the description of a listing
     */
    public function setDescription($description)
    {
	$this->Description = $description;
    }

    /**
     * setTags sets the tags of a listing
     * @param $tags are the tags used for labeling listings
     */
    public function setTags($tags)
    {
	$this->Tags = $tags;
    }

}

/**
 * UserObject is a class that handles information of the user as objects
 */
class UserObject
{
    public $userName = null;
    public $Email = null;
    public $ID = null;
    private $Listings = array();
    public $Admin = null;
    
    /**
     * __construct handles the database connection and instantiating of user login details
     * @param $db is the database
     * @param $result is the information displayed
     */
    function __construct($result)
    {  
        $this->userName = $result->name;
        $this->Email = $result->email;
	$this->ID = $result->id;
        $this->Admin = $result->admin;
        //$this->Listings = $result->listings;
    }
   

    /**
     * isAdmin checks if the user is an admin
     * @return bool if the user is an admin return true
     */
    public function isAdmin()
    {
      return $this->Admin;
    }


    /**
     * getName gets the name of the SFSU student
     * @return string the name of the student
     */
    public function getName()
    {
	return $this->userName;
    }

    /**
     * getEmail gets the email address of SFSU student
     * @return string Email address of student
     */
    public function getEmail()
    {
	return $this->Email;
    }

    /**
     * getID gets the SFSU student ID
     * @return int ID of user
     */
    public function getID()
    {
	return $this->ID;
    }

    /**
     * getListings gets the listing information
     * @return string Listings made by the user
     */
    public function getListings()
    {
	return $this->Listings;
    }

    /**
     * setName sets the name of the student
     * @param $name is the name of student
     */
    public function setName($name)
    {
	$this->userName = $name;
    }

    /**
     * setEmail sets the email address of a student
     * @param $email is an SFSU student email address
     */
    public function setEmail($email)
    {
	$this->Email = $email;
    }

    /**
     * setListings sets the listing created by user
     * @param @listings are the listings posted by student
     */
    public function setListings($listings)
    {
	$this->Listing = $listings;
    }
}

