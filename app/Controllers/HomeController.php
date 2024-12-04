<?php
namespace Almhdy\Simy\Controllers;
use Almhdy\Simy\Core\Controller;

/**
 * HomeController handles the home page functionalities.
 */
class HomeController extends Controller
{
  /**
   * Displays the home page.
   *
   * This method loads the home/index view.
   */
  public function index()
  {
    // Load the view for the home index page.
    $this->view("home/index");
  }
}
