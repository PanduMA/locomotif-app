<?php

namespace App\Models\Mongo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;

class Locomotif extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'locomotif-models';
}
