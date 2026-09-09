<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product; // <-- ye bhi add kar do

class Category extends Model
{
    protected $fillable = ['name'];

    public function products() {
        return $this->hasmany(Product::class); // <-- M chota
    }
}