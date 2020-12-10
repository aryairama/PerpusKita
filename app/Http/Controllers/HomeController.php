<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (Gate::allows('rolePetugas')) {
            $borrow_return = \App\returned_book::with('borrows')->with('books')->with('users')->where('status_return', 'verif_kembali');
            if ($request->ajax()) {
                return DataTables::of($borrow_return)
            ->addIndexColumn()
            ->make(true);
            }
            $users = \App\User::all()->count();
            $books = \App\Book::all()->count();
            $borrows = \App\returned_book::where('status_return', 'pinjam')->get()->count();
            $returns = \App\returned_book::where('status_return', 'kembali')->get()->count();
            return view('home', \compact('users', 'books', 'borrows', 'returns'));
        } elseif (Gate::allows('roleSiswa')) {
            $borrow_return = \DB::table('returned_books')->join('users', 'users.id', '=', 'returned_books.user_id')
                                ->join('books', 'books.id', '=', 'returned_books.book_id')
                                ->join('borrowed_books', 'borrowed_books.id', '=', 'returned_books.borrowed_book_id')
                                ->where('returned_books.user_id', \Auth::user()->id)
                                ->where('returned_books.status_return', 'pinjam');
            if ($request->ajax()) {
                return DataTables::of($borrow_return)
            ->addIndexColumn()
            ->make(true);
            }
            $gone =  \App\returned_book::where('status_return', 'hilang')->where('user_id', \Auth::user()->id)->get()->count();
            $borrow =  \App\returned_book::where('status_return', 'pinjam')->where('user_id', \Auth::user()->id)->get()->count();
            $return =  \App\returned_book::where('status_return', 'kembali')->where('user_id', \Auth::user()->id)->get()->count();
            $broken =  \App\returned_book::where('status_return', 'rusak')->where('user_id', \Auth::user()->id)->get()->count();
            return view('home', \compact('gone', 'borrow', 'return', 'broken'));
        }
    }
}
