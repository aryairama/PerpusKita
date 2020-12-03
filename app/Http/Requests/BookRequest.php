<?php

namespace App\Http\Requests;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        if ($request->book_id) {
            $book = Book::findOrFail($request->book_id);
            if ($request->id == $book->id) {
                return [
                    'id' => 'required|min:5|max:20',
                    'title' => 'required|min:5|max:255',
                    'synopsis' => 'required|min:20',
                    'author' => 'required|min:5|max:255',
                    'publisher' => 'required|min:5|max:255',
                    'cover' => 'mimes:png,jpg,jpeg'
                ];
            } else {
                return [
                    'id' => 'required|min:5|max:20|unique:books,id',
                    'title' => 'required|min:5|max:255',
                    'synopsis' => 'required|min:20',
                    'author' => 'required|min:5|max:255',
                    'publisher' => 'required|min:5|max:255',
                    'cover' => 'mimes:png,jpg,jpeg'
                ];
            }
        } else {
            return [
                    'id' => 'required|min:5|max:20|unique:books,id',
                    'title' => 'required|min:5|max:255',
                    'synopsis' => 'required|min:20',
                    'author' => 'required|min:5|max:255',
                    'publisher' => 'required|min:5|max:255',
                    'cover' => 'required|mimes:png,jpg,jpeg'
                ];
        }
    }
}
