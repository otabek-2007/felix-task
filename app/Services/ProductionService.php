<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Warehouse;

class ProductionService
{
    public function getProduction($request)
    {
        $productIds = $request->query('products');
        $quantities = $request->query('quantities');

        if (empty($productIds) || empty($quantities) || count($productIds) !== count($quantities)) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        $response = [];

        foreach ($productIds as $index => $productId) {
            $product = Product::find($productId);

            if ($product) {
                $productQuantity = $quantities[$index];
                $materialsNeeded = [];

                foreach ($product->materials as $material) {
                    $requiredQuantity = $material->pivot->quantity * $productQuantity;
                    $remainingQuantity = $requiredQuantity;

                    $warehouses = Warehouse::where('material_id', $material->id)->orderBy('id')->get();
                    foreach ($warehouses as $warehouse) {
                        if ($remainingQuantity <= 0) break;

                        $available = min($remainingQuantity, $warehouse->remainder);
                        $materialsNeeded[] = [
                            'warehouse_id' => $warehouse->id,
                            'material_name' => $material->name,
                            'qty' => $available,
                            'price' => $warehouse->price,
                        ];
                        $remainingQuantity -= $available;
                    }

                    if ($remainingQuantity > 0) {
                        $materialsNeeded[] = [
                            'warehouse_id' => null,
                            'material_name' => $material->name,
                            'qty' => $remainingQuantity,
                            'price' => null,
                        ];
                    }
                }
                $response[] = [
                    'product_name' => $product->name,
                    'product_qty' => $productQuantity,
                    'product_materials' => $materialsNeeded,
                ];
            }
        }

        return ['result' => $response];
    }
}
