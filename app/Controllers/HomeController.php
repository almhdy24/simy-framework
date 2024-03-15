<?php
namespace Almhdy\Simy\Controllers;
use Almhdy\Simy\Core\Controller;
use Almhdy\Simy\Models\User;
use Almhdy\Simy\Core\Request;

class HomeController extends Controller
{
	public function index()
	{
		//$this->view("home/index");
	   $data = (new Request())->request();
	   var_dump($i);
	    
	}
	public function info()
	{
		return phpinfo();
	}
}
