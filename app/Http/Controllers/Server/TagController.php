<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Tag;
use App\Product;
use App\ProductTag;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function __construct()
    {
         // Apply the jwt.auth middleware to all methods in this controller
         // except for the authenticate method. We don't want to prevent
         // the user from retrieving their token if they don't already have it
         $this->middleware('jwt.auth');
    }

    public function addTag(Request $request, $productId)
    {
        $input = $request->only('tag_name');
        
        $product = Product::where('id', $productId)->first();
        $tagCount = Tag::where('tag_name', $input);

        if($tagCount->count() > 0) {
            $inputTag['tag_id'] = $tagCount->first()->id;
            $inputTag['product_id'] = $product->id;

            // dd($inputTag);
            $tag = ProductTag::create($inputTag);
            
        }
        else {
            $tag = $product->tags()->create($input);  
        }

        if ($tag){

            $params = [
                'status' => "success",
                'message' => "tag telah ditambahkan",
            ];
        }
        else {
            $params = [
                'status' => "error",
                'message' => "tag gagal ditambahkan",
            ];
        }
        
        return json_encode($params);
    }

    public function deleteTag($productId, $tagId)
    {
        $productTag = ProductTag::where('product_id', $productId)->where('tag_id', $tagId)->delete();
        $params = [
            'status' => "success",
            'message' => "tag telah dihapus",
        ];
        
        return json_encode($params);
    }
}
