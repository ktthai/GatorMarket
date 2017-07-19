<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Home extends DatabaseController
{
    /**
     * The index function handles getting the information for the most recent browsings and gets the listings. 
     */
    public function index()
    {
        $result = $this->model->browseRecent();
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
        $choice = "home";
        require APP . 'view/_templates/header.php';
        require APP . 'view/listing/result.php';
        require APP . 'view/_templates/footer.php';
     }

}
