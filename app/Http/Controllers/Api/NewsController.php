<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    public function get()
    {
        $news = News::with(['category'])->get();
        if($news) {
            return $this->initResult(true, $news);
        }
        return $this->initResult(false);
    }
    
    public function detail($id)
    {
        $news = News::with(['category', 'news_comment'])->find($id);
        if($news) {
            return $this->initResult(true, $news);
        }
        return $this->initResult(false, null, 404, 'news not exist');
    }
    
    public function delete($id)
    {
        $news = News::where('id',$id)->delete();
        return response()->json(['message' => 'Successfully Delete News']);
    }
    
    public function create(Request $request)
    {
        $user = $request->user();
        $validator = $this->validateRequest($request);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category = Category::find($request->category_id);
        if ($category == null) {
            return $this->initResult(false, null, 400, 'category not exist');
        }
        
        $news = News::create([
            'category_id' => $request->category_id,
            'news_content' => $request->news_content,
            'creator_id' => $user['id']
        ]);

        if($news) {
            return $this->initResult(true, $news);
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

        $category = Category::find($request->category_id);
        if ($category == null) {
            return $this->initResult(false, null, 400, 'category not exist');
        }

        $news = News::where('id', $id)->update([
            'category_id' => $request->category_id,
            'news_content' => $request->news_content,
            'creator_id' => $user['id']
        ]);
        
        return $this->detail($id);
    }
    
    // rappid inner service
    function validateRequest($request) {
        return Validator::make($request->all(), [
            'category_id'  => 'required',
            'news_content'  => 'required'
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
