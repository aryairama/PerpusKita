<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Category;
use Yajra\DataTables\DataTables;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
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
        $category = \DB::table('categories')->select(['id', 'name',]);
        if ($request->ajax()) {
            return DataTables::of($category)
            ->addIndexColumn()
            ->addColumn('action', function ($category) {
                $btn = '<a href="javascript:void(0)" class="edit badge badge-success" onclick="editForm('.$category->id.')">Edit</a>
                <a href="javascript:void(0)" class="delete badge badge-danger" onclick="deleteForm('.$category->id.')">Delete</a>';
                return  $btn;
            })->rawColumns(['action'])
            ->make(true);
        }
        return view('category.index');
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
    public function store(CategoryRequest $request)
    {
        try {
            $newCategory = new Category();
            $newCategory->name = $request->name;
            $newCategory->save();
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
            $category_detail = Category::findOrFail($id);
            return $category_detail;
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
    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->name = $request->name;
            $category->save();
            return \Response::json(['method' => 'update'], 200);
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
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return \Response::json(['method' => 'delete'], 200);
        } catch (\Throwable $th) {
            return \Response::json(404);
        }
    }

    public function selectCategory(Request $request)
    {
        $data = [];
        $search = $request->q;
        if ($request->ajax()) {
            $data = Category::where('name', 'LIKE', "%$search%")->get();
            return \response()->json($data);
        }
    }
}
