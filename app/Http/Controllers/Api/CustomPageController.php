<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomPage;
use Illuminate\Support\Facades\Validator;

class CustomPageController extends Controller
{
    public function get()
    {
        $customPage = CustomPage::get();
        if($customPage) {
            return $this->initResult(true, $customPage);
        }
        return $this->initResult(false);
    }
    
    public function detail($id)
    {
        $customPage = CustomPage::find($id);
        if($customPage) {
            return $this->initResult(true, $customPage);
        }
        return $this->initResult(false, null, 404, 'custom page not exist');
    }
    
    public function delete($id)
    {
        $customPage = CustomPage::where('id',$id)->delete();
        return response()->json(['message' => 'Successfully Delete CustomPage']);
    }
    
    public function create(Request $request)
    {
        $user = $request->user();
        $validator = $this->validateRequest($request);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $customPage = CustomPage::create([
            'custom_url' => $request->custom_url,
            'page_content' => $request->page_content,
            'creator_id' => $user['id']
        ]);

        if($customPage) {
            return $this->initResult(true, $customPage);
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

        $customPage = CustomPage::where('id', $id)->update([
            'custom_url' => $request->custom_url,
            'page_content' => $request->page_content,
            'creator_id' => $user['id']
        ]);
        
        return $this->detail($id);
    }
    
    // rappid inner service
    function validateRequest($request) {
        return Validator::make($request->all(), [
            'custom_url'  => 'required',
            'page_content'  => 'required'
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
