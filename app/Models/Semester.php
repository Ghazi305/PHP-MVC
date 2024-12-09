<?php

namespace App\Models;

use App\Models\Model;

class Semester extends Model
{
    public int $id;
    public string $name; 
    public int $degree_type_id;
    public string $created_at;
    public string $updated_at;  
}