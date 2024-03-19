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
		$validator = new Validation();
		$data = array("email"=>"almhdybdallh","age"=>"9b"); // Assuming the data to be validated is coming from a form submit

		$rules = [
			"email" => "required|email",
			"age" => "required|numeric",
			// Add more fields and rules as needed
		];

		$customMessages = [
			"email.required" => "The email field is required.",
			"age.numeric" => "The age field must be a number.",
			// Add more custom error messages as needed
		];

		$isValid = $validator->validate($data, $rules, $customMessages);

		if ($isValid) {
			// Data is valid, continue with your logic
		} else {
			$errors = $validator->getErrors();
			var_dump($errors);
			// Handle errors or display them to the user
		}
	}
	public function info()
	{
		return phpinfo();
	}
}
