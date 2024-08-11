<?php

namespace App\Controllers;

use Proton\Validation\Validator;

use App\Models\User;
use App\Models\Studan;

class AuthController 
{
    public function login()
    {
        
    } 
     
    public function register()
    {
        var_dump(Studan::create([
          'id' => 1,
          'username' => 'محمد مجتبي محمد احمد', 
          'addaress' => 'Khartoum', 
          'level' => 'المستوى الثالث - نظم معلومات',
          'fees' => 150,000,
          'id_number' => 1918023126,
          ]));
    }
    
    public function index()
    {
        print_r(Studant::all());
    }
} 