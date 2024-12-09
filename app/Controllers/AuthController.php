<?php

namespace App\Controllers;

use Proton\Validation\Validator;
use App\Models\Student;
use App\Models\Department;
use App\Models\Semester;

class AuthController
{ 
    public function index() 
    { 
        $department = Student::all(); 
        return view('welcome', ['department' => $department]);
    }

    public function login()
    { 
        $email = 'ghazi89@gmail.com';
        $student = Student::where(['email' => $email])->first();
        
        if ($student) {
          $data = [
            'name' => $student->name
            ]; 
          return response($data); 
        } else {
          
            return response(["message" => "Student not found"] ); 
        }
    }
     
    public function register()
    {
        // التحقق من المدخلات
        $validator = Validator::make([
            'name' => 'required|string', 
            'age' => 'required|alnum', 
            'email' => 'required|email|unique', 
            'phone' => 'required|string', 
            'address' => 'required|string', 
            'national_id' => 'required|int', 
            'university_id' => 'required|int', 
            'department_id' => 'required|int', 
        ]);

        if ($validator->passes()) {
            $studentData = Student::create([
                'name' => 'Ghaz Esam',
                'age' => 24, 
                'email' => 'ghazi12@gmail.com',
                'phone' => '0967255508',
                'address' => 'Khartoum',
                'national_id' => 1207858336,
                'university_id' => 1918674900, 
                'department_id' => 22,
                'degree_type_id' => 1,
            ]); 

            var_dump($studentData); 
        } else { 
            var_dump($validator->errors());
        }
    }
} 