<?php

namespace App\Http\Controllers;

use App\Models\EntityType; 

class EntityController extends Controller
{
    public function registerEntity($entityType)
    {

    }
    
    public function getLabelEntityItem(string $entityType, int $entityId): array {
        $entityType = EntityType::where('name', $entityType)->first();

        if ($entityType) {
            $entityModel = app($entityType->collection_name);
            $entityItem = $entityModel::where('id', $entityId)->first();

            if ($entityItem) {
                return [
                    'entityItemId' => $entityItem->id, 
                    'entityTypeId' => $entityType->id
                ];
            }

            return [];
        }

        return [];
    }
}
