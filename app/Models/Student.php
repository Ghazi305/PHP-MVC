<?php

namespace App\Models;

use App\Models\Model;

class Student extends Model
{
   public int $id;
   public string $name;
   public int $age; 
   public string $email;
   public string $phone;
   public string $address;
   public int $national_id;
   public int $university_id;
   public int $degree_type_id;
   public int $department_id;
   public string $created_at;
   public string $updated_at; 
   
    protected $fillable = [
        'name', 
        'age', 
        'email', 
        'phone', 
        'address', 
        'national_id',
        'university_id',
        'department_id',
        'degree_type_id', 
    ];
    
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}