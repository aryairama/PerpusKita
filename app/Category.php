<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";
    protected $primaryKey = "id";
    protected $fillable = ["name"];

    public function books()
    {
        return $this->belongsToMany('App\Book', 'book_category', 'category_id', 'book_id');
    }
}
