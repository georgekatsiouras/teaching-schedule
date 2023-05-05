<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\TeacherScheduleService;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Enums\EntityEnum;

class TeacherScheduleServiceTest extends TestCase
{
    private TeacherScheduleService $teacherScheduleService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->teacherScheduleService = new TeacherScheduleService();
    }

    public function test_get_entity_data_throws_exception(): void
    {
        $exceptionMessage = 'There seems to be a technical issue, please contact technical support.';

        $this->expectException(HttpException::class);

        $this->expectExceptionMessage($exceptionMessage);

        $this->teacherScheduleService->getEntityData(EntityEnum::CLASSES, ['not_existent_object'], 'ABC123');
    }

    public function test_get_entity_data_returns_teacher_data(): void
    {
        $teacherData = $this->teacherScheduleService->getEntityData(EntityEnum::TEACHERS, ['classes']);

        $this->assertNotEmpty($teacherData);
    }

    public function test_get_entity_data_returns_class_data(): void
    {
        $classData = $this->teacherScheduleService->getEntityData(EntityEnum::CLASSES, ['lessons']);

        $this->assertNotEmpty($classData);
    }

    public function test_get_entity_data_returns_lesson_data(): void
    {
        $lessonData = $this->teacherScheduleService->getEntityData(EntityEnum::LESSONS, ['class']);

        $this->assertNotEmpty($lessonData);
    }
}