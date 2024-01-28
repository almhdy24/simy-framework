<?php
namespace Almhdy\Simy\Core;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Almhdy\Simy\Core\Database;

class Model extends EloquentModel
{
    protected $table; // Specify the table name
    protected $database;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->database = new Database;
    }

    // You can specify the table name in the child models
    // protected $table = 'your_table_name';

    // The methods like find, findWhere, findAll, create, update, and delete are already provided by Eloquent
    // You don't need to redefine them

    // You can add any additional methods or customize Eloquent queries in your child models

    // Example of an additional custom method
    public function customMethod()
    {
        // Your custom logic here
    }
}