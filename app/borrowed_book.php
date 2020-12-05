<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class borrowed_book extends Model
{
    //pinjam buku
    protected $table = "borrowed_books";
    protected $primaryKey = "id";
    protected $fillable = ["user_id","book_id","borrow_date"];
    public $timestamps = false;

    public function books()
    {
        return $this->belongsTo("App\Book", "book_id", "id");
    }

    public function users()
    {
        return $this->belongsTo("App\User", "user_id", "id");
    }
}
