<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\returned_book;
use \App\borrowed_book;
use \App\Book;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Gate;

class ReturnedBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('rolePetugas');
        $return_book = returned_book::with('books')->with('users');
        if ($request->ajax()) {
            return DataTables::of($return_book)
            ->addIndexColumn()
            ->addColumn('action', function ($return_book) {
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return \view('returned_book.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $this->authorize('roleSiswa');
        try {
            $return_book = returned_book::findOrFail($id);
            $return_book->status_return = "verif_kembali";
            $return_book->return_date = Carbon::now()->format('yy-m-d H:i:s');
            $return_book->save();
            return \Response::json(['method' => 'save'], 200);
        } catch (\Throwable $th) {
            return \Response::json(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('rolePetugasSiswa');
        try {
            $check_return = returned_book::findOrFail($id);
            $book = Book::findOrFail($check_return->book_id);
            $borrow = borrowed_book::findOrFail($check_return->borrowed_book_id);
            if ($check_return->status_return == "pinjam" || $check_return->status_return == "verif_kembali") {
                $book->status = "ada";
                $book->save();
                $borrow->delete();
            } elseif ($check_return->status_return == "kembali") {
                $borrow->delete();
            } elseif ($check_return->status_return == "hilang" || $check_return->status_return == "rusak") {
                return \Response::json(403);
            }
            return \Response::json(['method' => 'delete'], 200);
        } catch (\Throwable $th) {
            return \Response::json(404);
        }
    }

    public function borrowedReturnedIndex(Request $request)
    {
        $this->authorize('rolePetugasSiswa');
        if (Gate::allows('rolePetugas')) {
            $borrow_return = returned_book::with('borrows')->with('books')->with('users');
        } elseif (Gate::allows('roleSiswa')) {
            $borrow_return = returned_book::with('borrows')->with('books')->with('users')->where('user_id', \Auth::user()->id);
        }
        if ($request->ajax()) {
            return DataTables::of($borrow_return)
            ->addIndexColumn()
            ->addColumn('action', function ($borrow_return) {
                $btn = "";
                if (Gate::allows('rolePetugas')) {
                    if ($borrow_return->status_return == "verif_kembali") {
                        $btn = '
                        <a href="javascript:void(0)" class="edit badge badge-success" onclick="verifReturnForm('.$borrow_return->id.')">Veriv Return Book</a>
                        <a href="javascript:void(0)" class="delete badge badge-danger" onclick="deleteForm('.$borrow_return->id.')">Delete</a>';
                    } else {
                        $btn = '
                        <a href="javascript:void(0)" class="delete badge badge-danger" onclick="deleteForm('.$borrow_return->id.')">Delete</a>';
                    }
                } elseif (Gate::allows('roleSiswa')) {
                    if ($borrow_return->status_return == "pinjam") {
                        $btn = '
                        <a href="javascript:void(0)" class="edit badge badge-success" onclick="returnForm('.$borrow_return->id.')">Return Book</a>';
                    } else {
                        $btn = 'No Action';
                    }
                }
                return  $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return \view('returned_book.borrowed_returned_index');
    }
    public function verifReturn(Request $request, $id)
    {
        $this->authorize('rolePetugas');
        try {
            $return_book = returned_book::findOrFail($id);
            if ($request->status_return == "kembali") {
                $return_book->status_return = "kembali";
                $return_book->save();
                $book = Book::findOrFail($return_book->book_id);
                $book->status = "ada";
                $book->save();
            } elseif ($request->status_return == "rusak") {
                $return_book->status_return = "rusak";
                $return_book->save();
                $book = Book::findOrFail($return_book->book_id);
                $book->status = "rusak";
                $book->save();
            } elseif ($request->status_return == "hilang") {
                $return_book->status_return = "hilang";
                $return_book->save();
                $book = Book::findOrFail($return_book->book_id);
                $book->status = "hilang";
                $book->save();
            } else {
                return \Response::json(404);
            }
            return \Response::json(['method' => 'save'], 200);
        } catch (\Throwable $th) {
            return \Response::json(404);
        }
    }
}
