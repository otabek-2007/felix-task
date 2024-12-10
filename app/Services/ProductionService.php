<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Warehouse;

class ProductionService
{
    public function getProduction($request)
    {
        // So'rovdan mahsulotlar va miqdorlarni olish
        $productIds = $request->query('products');
        $quantities = $request->query('quantities');

        // Kiruvchi parametrlarni tekshirish
        if (empty($productIds) || empty($quantities) || count($productIds) !== count($quantities)) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        $response = [];

        // Har bir mahsulot uchun xomashyolarni hisoblash
        foreach ($productIds as $index => $productId) {
            $product = Product::find($productId);

            // Mahsulot mavjud bo'lsa
            if ($product) {
                $productQuantity = $quantities[$index];
                $materialsNeeded = [];

                // Har bir mahsulotning xomashyolarini olish
                foreach ($product->materials as $material) {
                    $requiredQuantity = $material->pivot->quantity * $productQuantity;
                    $remainingQuantity = $requiredQuantity;

                    // Omborlarni tekshirish va xomashyo zaxiralarini hisoblash
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

                    // Agar xomashyo yetarli bo'lmasa, uni null qilib qaytarish
                    if ($remainingQuantity > 0) {
                        $materialsNeeded[] = [
                            'warehouse_id' => null,
                            'material_name' => $material->name,
                            'qty' => $remainingQuantity,
                            'price' => null,
                        ];
                    }
                }

                // Javobga mahsulot va uning xomashyolarini qo'shish
                $response[] = [
                    'product_name' => $product->name,
                    'product_qty' => $productQuantity,
                    'product_materials' => $materialsNeeded,
                ];
            }
        }

        // Javobni JSON formatida qaytarish
        return ['result' => $response];
    }
}
