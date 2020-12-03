<?php

namespace App\Http\Requests;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        if ($request->category_id) {
            $category = Category::findOrFail($request->category_id);
            if ($request->name == $category->name) {
                return [
                    'name' => 'required|min:2|max:255',
                ];
            } else {
                return [
                    'name' => 'required|min:2|max:255|unique:categories,name',
                ];
            }
        } else {
            return [
                    'name' => 'required|min:2|max:255|unique:categories,name',
                ];
        }
    }
}
