<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class returned_book extends Model
{
    //kembali buku
    protected $table = "returned_books";
    protected $primaryKey = "id";
    protected $fillable = ["user_id","book_id","return_date","borrowed_book_id","status_return"];
    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo("App\User", "user_id", "id");
    }

    public function books()
    {
        return $this->belongsTo("App\Book", "book_id", "id");
    }

    public function borrows()
    {
        return $this->belongsTo("App\borrowed_book", "borrowed_book_id", "id");
    }
}
