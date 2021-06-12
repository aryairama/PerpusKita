<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\borrowed_book;
use \App\Book;
use \App\Category;
use \App\returned_book;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Gate;

class BorrowedBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('roleSiswa');
        $categories = Category::orderBy('id', 'ASC')->get();
        $all_book = Book::with('categories')->paginate(4);
        $book = $request->search_book;
        $category = $request->category;
        if ($request->search_book) {
            if ($request->category) {
                $all_book = Book::with('categories')->where('title', 'LIKE', "%$book%")
            ->whereHas('categories', function ($query) use ($category) {
                $query->where('name', 'LIKE', "%$category%");
            })->paginate(4);
            } else {
                $all_book = Book::with('categories')->where('title', 'LIKE', "%$book%")
            ->paginate(4);
            }
        } elseif ($request->category) {
            $all_book = Book::with('categories')->where('title', 'LIKE', "%$book%")
            ->whereHas('categories', function ($query) use ($category) {
                $query->where('name', 'LIKE', "%$category%");
            })->paginate(4);
        }
        return view('borrowed_book.index', compact('categories', 'all_book'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('roleSiswa');
        try {
            $check_book = Book::findOrFail($request->book_id);
            if ($check_book->status == "ada") {
                $borrow = new borrowed_book();
                $borrow->user_id = \Auth::user()->id;
                $borrow->book_id = $request->book_id;
                $borrow->borrow_date = Carbon::now();
                $borrow->save();
                $returned = new returned_book();
                $returned->user_id = \Auth::user()->id;
                $returned->book_id = $request->book_id;
                $returned->borrowed_book_id = $borrow->id;
                $returned->status_return = "pinjam";
                $check_book->status = "pinjam";
                $returned->save();
                $check_book->save();
                return \Response::json(['method' => 'save'], 200);
            } elseif ($check_book->status == "pinjam") {
                return \Response::json('The book has been borrowed', 403);
            } elseif ($check_book->status == "hilang") {
                return \Response::json('The book is gone', 403);
            } elseif ($check_book->status == "rusak") {
                return \Response::json('The book is damaged', 403);
            }
        } catch (\Throwable $th) {
            return \Response::json(404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('roleSiswa');
        try {
            $random_book =  Book::where('id', '!=', $id)->inRandomOrder()->limit(4)->get();
            $show_book = Book::findOrFail($id);
            return view('borrowed_book.show', compact('show_book', 'random_book'));
        } catch (\Throwable $th) {
            \abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function borrowBooksList(Request $request)
    {
        $this->authorize('rolePetugas');
        $borrow_book = borrowed_book::with('books')->with('users');
        if ($request->ajax()) {
            return DataTables::of($borrow_book)
            ->addIndexColumn()
            ->addColumn('action', function ($borrow_book) {
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return \view('borrowed_book.list');
    }
}
