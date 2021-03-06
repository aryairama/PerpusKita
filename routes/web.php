<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect()->route('login');
});
Auth::routes();
Route::get('/register', function () {
    return redirect()->route('login');
});
Route::get('/password/reset', function () {
    return redirect()->route('login');
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home/profile', 'HomeController@userIndex')->name('user.profile');
    Route::post('/home/profile/update', 'HomeController@userUpdate')->name('user.profile.update');
    //router crud user
    Route::get('user/listpetugas', 'UserController@user_petugas');
    Route::get('user/listsiswa', 'UserController@user_siswa');
    Route::resource('user', 'UserController');
    //router crud category
    Route::get('category/select', 'CategoryController@selectCategory');
    Route::resource('category', 'CategoryController');
    //router crud book
    Route::resource('book', 'BookController');
    //router crud borrowed book
    Route::get('borrows/bookslist', 'BorrowedBookController@borrowBooksList')->name('borrows.list');
    Route::resource('borrows', 'BorrowedBookController');
    //router crud returned book
    Route::post('returns/verifreturn/{id}', 'ReturnedBookController@verifReturn');
    Route::get('returns/borrows/book', 'ReturnedBookController@borrowedReturnedIndex')->name('returns.borrows.book');
    Route::resource('returns', 'ReturnedBookController');
    //router export excel
    Route::get('export', 'ExportExcelController@indexAllExport')->name('index.export.excel');
    Route::post('export/borrowreturnbook', 'ExportExcelController@allExportBorrowReturnBook')->name('export.excel.borrowreturn');
    //router test
    Route::get('test', 'test@index');
    Route::post('test/store', 'test@store')->name('test.store');
});
