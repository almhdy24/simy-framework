<?php
namespace Almhdy\Simy\Controllers;

use Almhdy\Simy\Core\Controller;
use Almhdy\Simy\Core\Validation\Validation;

class UserController extends Controller
{
  public function index()
  {
    // code
    echo "index";
  }
  public function show($id)
  {
    // code
    echo "show".$id;
  }
  public function store()
  {
    // code
    echo "store";
  }
  public function update($id)
  {
    // code
    echo "update" . $id;
  }
  public function delete($id)
  {
    // code
    echo "delete" . $id;
  }
}
