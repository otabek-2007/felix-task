<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Warehouse;
use App\Services\ProductionService;

class ProductionController extends Controller
{
    public function requestMaterials(Request $request)
    {
        $getProduction = new ProductionService($request);
        return $this->sendResponse($getProduction);
    }
}
