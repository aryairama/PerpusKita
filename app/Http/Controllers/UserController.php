<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use Yajra\DataTables\DataTables;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
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
    public function index()
    {
        return view('user.index');
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
    public function store(UserRequest $request)
    {
        try {
            $newUser = new User();
            $newUser->name = $request->name;
            $newUser->email = $request->email;
            $newUser->password = \Hash::make($request->password);
            $newUser->roles = $request->roles;
            $newUser->address = $request->address;
            $newUser->phone = $request->phone;
            $newUser->gender = $request->gender;
            $newUser->save();
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
            $user_detail = User::findOrFail(\decrypt($id));
            return $user_detail;
        } catch (DecryptException $th) {
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
    public function update(UserRequest $request, $id)
    {
        try {
            $user = User::findOrFail(\decrypt($id));
            if ($request->password == null) {
                $user->name = $request->name;
                $user->email = $request->email;
                $user->roles = $request->roles;
                $user->address = $request->address;
                $user->phone = $request->phone;
                $user->gender = $request->gender;
            } else {
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = \Hash::make($request->password);
                $user->roles = $request->roles;
                $user->address = $request->address;
                $user->phone = $request->phone;
                $user->gender = $request->gender;
            }
            $user->save();
            return \Response::json(['method' => 'update'], 200);
        } catch (DecryptException $th) {
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
            $user = User::findOrFail(\decrypt($id));
            $user->delete();
            return \Response::json(['method' => 'delete'], 200);
        } catch (DecryptException $th) {
            return \Response::json(404);
        }
    }

    public function user_petugas(Request $request)
    {
        $petugas = User::where('roles', 'petugas');
        if ($request->ajax()) {
            return DataTables::of($petugas)
            ->addIndexColumn()
            ->addColumn('action', function ($petugas) {
                $btn = '<a href="javascript:void(0)" class="edit badge badge-success" onclick="editForm(\''.encrypt($petugas->id).'\')">Edit</a>
                <a href="javascript:void(0)" class="delete badge badge-danger" onclick="deleteForm(\''.encrypt($petugas->id).'\')">Delete</a>';
                return  $btn;
            })->rawColumns(['action'])
            ->make(true);
        }
    }

    public function user_siswa(Request $request)
    {
        $siswa = User::where('roles', 'siswa');
        if ($request->ajax()) {
            return DataTables::of($siswa)
            ->addIndexColumn()
            ->addColumn('action', function ($siswa) {
                $btn = '<a href="javascript:void(0)" class="edit badge badge-success" onclick="editForm(\''.encrypt($siswa->id).'\')">Edit</a>
                <a href="javascript:void(0)" class="delete badge badge-danger" onclick="deleteForm(\''.encrypt($siswa->id).'\')">Delete</a>';
                return  $btn;
            })->rawColumns(['action'])
            ->make(true);
        }
    }
}
