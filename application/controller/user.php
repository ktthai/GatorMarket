<?php
/**
 * The User class extends to the DatabaseController.
 */
class User extends DatabaseController
{
    /**
     * The login function is responsible for allowing users to log into the site or checks whether or not they are logged in already.
     */
    public function login()
    {   
        require APP . 'view/_templates/header.php';
        if(!isset($_SESSION['user']))
        {
          require APP . 'view/user/loginPage.php';
          require APP . 'view/_templates/footer.php';
        }
        else
        {
          echo "User " . $_SESSION['user']->getName() . " already logged in";
          require APP . 'view/_templates/footer.php';
        }
    }

    /**
     * The logout function is responsible for allowing users to log out of the site.
     */  
    public function logout()
    {
      require APP . 'view/_templates/header.php';
      unset($_SESSION['user']);
      unset($_SESSION['admin']);
      echo 'You have been successfully logged out';
      require APP . 'view/_templates/footer.php';
      header("Refresh:2;url=".URL);
    }

    /** 
     * The createAccount function is responsible for allowing users to create an account on the site.
     */
    public function createAccount()
    {
	require APP . 'view/_templates/header.php';
	require APP . 'view/user/createAccount.php';
	require APP . 'view/_templates/footer.php';
    }

    /**
     * The viewAccount function is responsible for allowing users to check their user account page or require users log into the site to check if they are not already logged in.
     */
    public function viewAccount()
    {
	require APP . 'view/_templates/header.php';
	if(isset($_SESSION['user']))
	{
            $result = $this->model->userListings($_SESSION['user']->getID());
            $array = $this->model->getListings($result);
	    require APP . 'view/user/accountPage.php';

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
            $loopEnd = $row+10;
            if($loopEnd> sizeOf($array))
            {
              $loopEnd = sizeOf($array);
            }
                    
            $choice = "user";
            require APP . 'view/listing/result.php';
	}
	else
	{
	    echo 'Please login to access your account.';
	    require APP . 'view/user/loginPage';
	}
	require APP . 'view/_templates/footer.php';
    }

    /**
     * The varifyUser function verifies by checking if the user has a valid ID and password.
     */
    public function varifyUser()
    {
      if(isset($_POST['submit']))
      { 
	require APP . 'view/_templates/header.php';
        if(!isset($_SESSION['user']))
        {
        $_SESSION['user'] = $this->model->varifyUser($_POST['id'],$_POST['password']);
        $_SESSION['admin']=$_SESSION['user']->isAdmin();
        require APP . 'view/_templates/footer.php';
	}
        else 
        {
          "User " . $_SESSION['user']->getName() . " already logged in";
          require APP . 'view/_templates/footer.php';
        } 
      }
    }

    /**
     * The addAccount function is responsible for storing and saving accounts everytime a new account is created.
     */
    public function addAccount()
    {
      if(isset($_POST['submit']))
      { 
	require APP . 'view/_templates/header.php';
	require APP . 'view/user/loginPage.php';
	require APP . 'view/_templates/footer.php';

        echo $this->model->createAccount($_POST['id'],$_POST['name'],$_POST['password'],$_POST['email']);
      }
    }
}

