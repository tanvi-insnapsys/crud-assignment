<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description','status', 'technology','start_date','end_date'];

    public function employee()
    {
        return $this->belongsToMany(Employee::class)->withTimestamps();
    }
}