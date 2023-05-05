<?php

namespace App\Services;
 
interface TeacherScheduleServiceInterface 
{
    public function getEntityData(string $entity, array $includes = [], int|string $entityId = null): array;
}