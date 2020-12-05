<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class returned_book extends Model
{
    //kembali buku
    protected $table = "returned_books";
    protected $primaryKey = "id";
    protected $fillable = ["user_id","book_id","return_date","borrowed_book_id","status"];
    public $timestamps = false;
}
