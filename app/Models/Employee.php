<?php

namespace App\Models;

use App\Department;
use App\Designation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'photo', 'password', 'address', 'dept_id', 'design_id'
    ];

    protected $hidden = [
        'password',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }


}

