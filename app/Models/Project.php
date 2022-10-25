<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\AssignOp\Concat;

class Project extends Model
{
    use HasFactory;

    public function contacts(){
        return $this->hasMany(Concat::class);
    }
}
