<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Book;
use Yajra\DataTables\DataTables;
use App\Http\Requests\BookRequest;
use Illuminate\Support\Facades\Gate;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Gate::allows('rolePetugas')) {
                return $next($request);
            }
            abort(403);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $book = Book::with('categories')->orderBy('id', 'ASC');
        if ($request->ajax()) {
            return DataTables::of($book)
            ->addIndexColumn()
            ->addColumn('image', function ($book) {
                $url= asset('storage/'.$book->cover);
                return '<img src="'.$url.'" border="0" width="50" class="img-rounded" align="center" />';
            })
            ->addColumn('action', function ($book) {
                $btn = '<a href="javascript:void(0)" class="edit badge badge-success" onclick="editForm(\''.$book->id.'\')">Edit</a>
                <a href="javascript:void(0)" class="delete badge badge-danger" onclick="deleteForm(\''.$book->id.'\')">Delete</a>';
                return  $btn;
            })->addColumn('category', function ($book) {
                $category ="";
                foreach ($book->categories as $i => $cat) {
                    $category .= $cat->name.", ";
                }
                return $category;
            })
            ->rawColumns(['action','image','category'])
            ->make(true);
        }
        return view('book.index');
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
    public function store(BookRequest $request)
    {
        try {
            $newBook = new Book();
            $newBook->id = $request->id;
            $newBook->title = $request->title;
            $newBook->slug = \Str::slug($request->title);
            $newBook->synopsis = $request->synopsis;
            $newBook->author = $request->author;
            $newBook->publisher = $request->publisher;
            $image = $request->file('cover');
            $name = date('mdYHis') . uniqid().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('storage/book_cover');
            $image->move($destinationPath, $name);
            $newBook->cover = 'book_cover/'.$name;
            $newBook->save();
            $newBook->categories()->attach($request->category);
            return \Response::json(['method' => 'save'], 200);
        } catch (\Throwable $th) {
            return \Response::json(417);
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
        try {
            $book_detail = Book::with('categories')->findOrFail($id);
            return $book_detail;
        } catch (\Throwable $th) {
            return \Response::json(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, $id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->id = $request->id;
            $book->title = $request->title;
            $book->slug = \Str::slug($request->title);
            $book->synopsis = $request->synopsis;
            $book->author = $request->author;
            $book->publisher = $request->publisher;
            $cover = $request->file('cover');
            if ($cover) {
                if ($book->cover && file_exists(storage_path('app/public/' .$book->cover))) {
                    unlink(public_path('storage/').$book->cover);
                }
                $image = $request->file('cover');
                $name = date('mdYHis') . uniqid().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('storage/book_cover');
                $image->move($destinationPath, $name);
                $book->cover = 'book_cover/'.$name;
            }
            $book->save();
            $book->categories()->sync($request->category);
            return \Response::json(['method' => 'update'], 200);
        } catch (\Throwable $th) {
            return \Response::json(417);
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
        try {
            $book = Book::findOrFail($id);
            if ($book->cover && file_exists(storage_path('app/public/' . $book->cover))) {
                unlink(public_path('storage/').$book->cover);
            }
            $book->categories()->detach();
            $book->delete();
            return \Response::json(['method' => 'delete'], 200);
        } catch (\Throwable $th) {
            return \Response::json(404);
        }
    }
}
