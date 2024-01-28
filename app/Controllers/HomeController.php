<?php
namespace Almhdy\Simy\Controllers;
use Almhdy\Simy\Core\Controller;
use Almhdy\Simy\Models\User;

class HomeController extends Controller
{
	public function index()
	{
		$user = new User();
		echo "<pre>";

		var_dump($user->all());
		echo "</pre>";
		 //$this->view("home/index");
	}
	public function info()
	{
		return phpinfo();
	}
}
