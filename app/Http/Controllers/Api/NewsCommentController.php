<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\NewsComment;
use Illuminate\Support\Facades\Validator;

class NewsCommentController extends Controller
{
    
    public function create(Request $request)
    {
        $validator = $this->validateRequest($request);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $news = News::find($request->news_id);
        if ($news == null) {
            return $this->initResult(false, null, 400, 'news not exist');
        }
        
        $newsComment = NewsComment::create([
            'news_id' => $request->news_id,
            'name' => $request->name,
            'comment' => $request->comment
        ]);

        if($newsComment) {
            return $this->initResult(true, $newsComment);
        }

        return $this->initResult(false);
    }
    
    // rappid inner service
    function validateRequest($request) {
        return Validator::make($request->all(), [
            'news_id'  => 'required',
            'name'  => 'required',
            'comment'  => 'required'
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
