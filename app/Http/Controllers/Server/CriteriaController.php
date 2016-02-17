<?php

namespace App\Http\Controllers\Server;

use Illuminate\Http\Request;

use App\Criteria;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Server\CatalogController as CatalogCtrl;

class CriteriaController extends Controller
{

    public function __construct()
    {
         // Apply the jwt.auth middleware to all methods in this controller
         // except for the authenticate method. We don't want to prevent
         // the user from retrieving their token if they don't already have it
         $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addCriteria(CatalogCtrl $catalog, Request $request, $productId)
    {
        if ($catalog->isOwner($productId)) {
            $input = $request->all();
            $input['product_id'] = $productId;

            $criteria = Criteria::create($input);

            if($criteria){
                $params = [
                    'status' => "success",
                    'message' => "kriteria telah ditambahkan",
                ];
            }
            else {
                $params = [
                    'status' => "error",
                    'message' => "kriteria gagal ditambahkan",
                ];
            }

        } else {
            $params = [
                    'status' => "error",
                    'message' => "akses invalid",
                ];
        }
        return json_encode($params);   

    }

    public function deleteCriteria(CatalogCtrl $catalog, $productId, $criteriaId)
    {
        if ($catalog->isOwner($productId)) {
            $productTag = Criteria::where('product_id', $productId)->where('id', $criteriaId)->delete();
            $params = [
                'status' => "success",
                'message' => "kriteria telah dihapus",
            ];
        } else{
            $params = [
                'status' => "error",
                'message' => "akses invalid",
            ];
        }
        
        return json_encode($params);
    }

}
