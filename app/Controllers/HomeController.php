<?php
namespace Almhdy\Simy\Controllers;
use Almhdy\Simy\Core\Controller;
use Almhdy\Simy\Models\User;
use Almhdy\Simy\Core\Request;
use Almhdy\Simy\Core\Validation\Validation;

class HomeController extends Controller
{
  public function index()
  {
    echo "HOME PAGE";
  }
  public function info()
  {
    return phpinfo();
  }
}
