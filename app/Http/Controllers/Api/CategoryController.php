<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function get()
    {
        $category = Category::get();
        if($category) {
            return $this->initResult(true, $category);
        }
        return $this->initResult(false);
    }
    
    public function detail($id)
    {
        $category = Category::find($id);
        if($category) {
            return $this->initResult(true, $category);
        }
        return $this->initResult(false, null, 404, 'category not exist');
    }
    
    public function delete($id)
    {
        $category = Category::where('id',$id)->delete();
        return response()->json(['message' => 'Successfully Delete Category']);
    }
    
    public function create(Request $request)
    {
        $user = $request->user();
        $validator = $this->validateRequest($request);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category = Category::create([
            'category_name' => $request->category_name,
            'creator_id' => $user['id']
        ]);

        if($category) {
            return $this->initResult(true, $category);
        }

        return $this->initResult(false);
    }
    
    public function update($id, Request $request)
    {
        $user = $request->user();
        $validator = $this->validateRequest($request);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category = Category::where('id', $id)->update([
            'category_name' => $request->category_name,
            'creator_id' => $user['id']
        ]);
        
        return $this->detail($id);
    }
    
    // rappid inner service
    function validateRequest($request) {
        return Validator::make($request->all(), [
            'category_name'  => 'required'
        ]);
    }
    
    function initResult($success, $news = null, $failedcode = 409, $message = 'Something Went Wrong') {
        if ($success === false) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], $failedcode);
        } else {
            return response()->json([
                'success' => true,
                'news'=> $news,  
            ], 201);
        }
    }
}



