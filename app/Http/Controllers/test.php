<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Book;

class test extends Controller
{
    public function index(Request $request)
    {
        return view('test_storage.index');
    }

    public function store(Request $request)
    {
        $newBook = new Book();
        $newBook->id = "id";
        $newBook->title = "title";
        $newBook->slug = \Str::slug("title");
        $newBook->synopsis = "synopsis";
        $newBook->author = "author";
        $newBook->publisher = "publisher";
        $cover = $request->file('cover');
        $cover_path = $cover->store('book_cover', 'public');
        $newBook->cover = $cover_path;
        $newBook->save();
    }
}
