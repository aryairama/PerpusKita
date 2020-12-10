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
            $users = \App\User::where('roles','siswa')->get();
            $user_list = array();
            $borrow_list = array();
            foreach($users as $key => $user){
                $user_list[$key] =  $user->name;
                $borrow_list[$key] = $this->countReturnBook($user->id,'kembali');
            }
            $chartPinjam = app()->chartjs
        ->name('chartPinjam')
        ->type('bar')
        ->size(['width' => 400, 'height' => 220])
        ->labels($user_list)
        ->datasets([
            [
                "label" => "Borrow Books",
                'backgroundColor' => "#ffa534",
                'data' => $borrow_list,
            ],
        ])
        ->options([]);
            $chartPinjam->optionsRaw([
            'responsive'=> true,
            'maintainAspectRatio' => true,
            'legend' => [
                'display' => true,
                'labels' => [
                    'fontColor' => '#000'
                ]
            ],
            'scales' => [
                'xAxes' => [
                    [
                        'stacked' => true,
                        'gridLines' => [
                            'display' => false
                        ]
                    ]
                        ],
                'yAxes' => [
                    [
                        'stacked' => true,
                        'gridLines' => [
                            'display' => true
                        ]
                    ]
                            ],
            ]
        ]);
            ////
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
            return view('home', \compact('users', 'books', 'borrows', 'returns','chartPinjam'));
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

    public function countReturnBook($user_id,$status){
        return \App\returned_book::where('status_return',$status)->whereHas('users',function($query) use ($user_id){
            $query->where('id',$user_id);
        })->get()->count();
    }
}
