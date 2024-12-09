<?php

namespace App\Models;

use App\Models\Model;
 
class Department extends Model
{
    public int $id;
    public string $department_name;
    public string $created_at;
    public string $updated_at;
    public int $college_id;
    
    public function students()
    {
        return $this->hasMany(Student::class, 'department_id', 'id');
    }
}