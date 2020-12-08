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
        return $this->belongsTo(Book::class, "book_id", "id");
    }

    public function users()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function returned_book()
    {
        return $this->hasOne(returned_book::class, "borrowed_book_id", "id");
    }
}
