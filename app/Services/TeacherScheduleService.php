<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use App\Enums\EntityEnum;
 
class TeacherScheduleService implements TeacherScheduleServiceInterface {

    const NUMBER_OF_TEACHERS = 100;

    public function getEntityData(string $entity, array $includes = [], int|string $entityId = null): array
    {
        $url = config('services.wonde.base_api_url').
            config('services.wonde.schools_prefix'). '/'.
            config('services.wonde.testing_school_id');

        switch ($entity) {
            case EntityEnum::TEACHERS:
                $url .=  config('services.wonde.employees_endpoint').'?has_class=1&per_page='.self::NUMBER_OF_TEACHERS;
                break;
            case EntityEnum::CLASSES:
                $url .=  config('services.wonde.classes_endpoint');
                break;
            case EntityEnum::LESSONS:
                $url .=  config('services.wonde.lessons_endpoint');
                break;
        }

        if($entityId){
            $url .= '/'.$entityId;
        }

        if(count($includes) > 0){
            $url = $entity === EntityEnum::TEACHERS 
                ? $url.'&include='.implode(',', $includes) 
                : $url.'?include='.implode(',', $includes);
        }

        $response = Http::withToken(config('services.wonde.token'))->get($url);  

        //check response
        if($response->status() !== Response::HTTP_OK){
            return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'There seems to be a technical issue, please contact technical support.');
        }
        
        $entityData = json_decode($response->getBody()->getContents(), true)['data'];

        return $entityData;
    }
}