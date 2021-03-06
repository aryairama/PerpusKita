<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = "books";
    protected $primaryKey = "id";
    public $incrementing = false;
    protected $fillable = ["id","title","slug","synopsis","author","publisher","cover","status"];

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'book_category', 'book_id', 'category_id');
    }

    public function borrows()
    {
        return $this->hasMany(borrowed_book::class, "book_id", "id");
    }

    public function returned_book()
    {
        return $this->hasMany(returned_book::class, "book_id", "id");
    }
}
