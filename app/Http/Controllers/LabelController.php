<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Http\Resources\LabelResource;
use Illuminate\Validation\ValidationException;

class LabelController extends Controller
{

    private EntityController $entity;

    public function __construct()
    {
        $this->entity = new EntityController;
    }

    /**
     *
     * @param string $entityType
     * @param int $entityId
     * @return LabelResource
     */
    public function index(string $entityType, int $entityId)
    {
        $labels = Label::select('label.id', 'label.name')
            ->join('entity_type', function ($join) {
                $join->on('label.entity_type_id', '=', 'entity_type.id');
            })
            ->where('entity_type.name', $entityType)
            ->where('entity_id', $entityId)
            ->get();

        dd(LabelResource::make($labels));
        return LabelResource::make($labels);
    }

    /**
     *
     * @param string $entityType
     * @param int $entityId
     * @param array $labelList
     * @return bool
     * @throws ValidationException
     */
    public function store(string $entityType, int $entityId, array $labelList): bool
    {
        $entityItem = $this->entity->getLabelEntityItem($entityType, $entityId);
        $data = [];

        foreach($labelList as $labelItem){
            if(!is_string($labelItem)) {
                throw ValidationException::withMessages(['Incorrect label data!']);
            }
            $data[] = [
                'name' => $labelItem,
                'entity_type_id' => $entityItem['entityTypeId'],
                'entity_id' => $entityItem['entityItemId'],
            ];
        }

        $labels = Label::insert($data);
        
        return $labels;
    }

    /**
     *
     * @param string $entityType
     * @param int $entityId
     * @param array $labelList
     * v
     * @throws ValidationException
     */
    public function update(string $entityType, int $entityId, array $labelList): bool
    {
        $entityItem = $this->entity->getLabelEntityItem($entityType, $entityId);

        $this->delete($entityType, $entityId, $labelList);

        foreach($labelList as $labelItem){
            if(!is_string($labelItem)) {
                throw ValidationException::withMessages(['Incorrect label data!']);
            }
            $data[] = [
                'name' => $labelItem,
                'entity_type_id' => $entityItem['entityTypeId'],
                'entity_id' => $entityItem['entityItemId'],
            ];
        }

        $labels = Label::insert($data);
        
        return $labels;
    }

    /**
     *
     * @param string $entityType
     * @param int $entityId
     * @param array $labelList
     * @return bool
     * @throws ValidationException
     */
    public function delete(string $entityType, int $entityId, array $labelList): bool
    {
        $entityItem = $this->entity->getLabelEntityItem($entityType, $entityId);

        //Check whether all array values are strings
        if (array_sum(array_map('is_string', $labelList)) == count($labelList) && count($labelList) !== 0 && $entityItem) {
            if (Label::whereIn('name', $labelList)->count() >= count($labelList)) {
                Label::whereIn('name', $labelList)->delete();

                return true;
            }

            throw ValidationException::withMessages(['Incorrect label data!']);
        }

        throw ValidationException::withMessages(['Incorrect label data!']);
    }

}
