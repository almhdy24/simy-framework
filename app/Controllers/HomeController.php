<?php
namespace Almhdy\Simy\Controllers;
use Almhdy\Simy\Core\Controller;


class HomeController extends Controller
{
  public function index()
  {
    // load view index
    $this->view("home/index");
  }
}
