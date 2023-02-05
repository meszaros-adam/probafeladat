<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status', 'user_id'];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y.m.d H:i');
    }
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y.m.d H:i');
    }
}
