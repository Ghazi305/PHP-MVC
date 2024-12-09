<?php

namespace App\Models;

use App\Models\Model;

class College extends Model
{
    public int $id;
    public string $college_name;
    public string $description;
    public string $created_at;
    public string $updated_at; 
}