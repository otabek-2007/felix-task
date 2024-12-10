<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Warehouse;
use App\Services\ProductionService;

class ProductionController extends Controller
{
    public function production(Request $request)
    {
        $getProduction = (new ProductionService)->getProduction($request);
        return $this->sendResponse($getProduction);
    }
}
