<?php
 
namespace App\Controllers;

use Proton\Validation\Validator;

use App\Models\User;
use App\Models\Student;
use App\Models\College;
use App\Models\Semester;
use App\Models\Department;

class AuthController 
{
   
   public function index() 
   { 
     $department = Department::all(); 
     return view('welcome', ['department' => $department]);
   }
    
    public function login()
    {
        $department = Department::all(); 
        var_dump($department); 
    } 
     
    public function register()
    {
        echo 'Hello PHP mvc';
    }
    
} 