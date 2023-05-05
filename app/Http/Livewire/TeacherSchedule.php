<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Services\TeacherScheduleService;
use App\Enums\EntityEnum;

class TeacherSchedule extends Component
{
    public array $teachers = [];
    public array $classes = [];
    public array $lessons = [];
    public array $students = [];

    public int $selectedTeacher;
    public string $selectedClass;
    public string $selectedLesson;

    private TeacherScheduleService $teacherScheduleService;

    public function render()
    {
        return view('livewire.teacher-schedule');
    }

    public function boot(TeacherScheduleService $teacherScheduleService)
    {
        $this->teacherScheduleService = $teacherScheduleService;
    }

    public function mount()
    {
        $this->teachers = $this->teacherScheduleService->getEntityData(EntityEnum::TEACHERS, ['classes']);
    }

    public function setClasses(): void
    {
        if($this->selectedTeacher !== -1){
            //set teacher's classes according to the teacher selected
            $this->classes = data_get($this->teachers, $this->selectedTeacher.'.classes.data', []);
        }
    }

    public function setLessons(): void
    {
        if($this->selectedClass !== -1){
            $classData = $this->teacherScheduleService->getEntityData(EntityEnum::CLASSES, ['lessons'], $this->selectedClass);

            $this->lessons = array_map( 
                fn($lesson) =>  
                [
                    'id' => data_get($lesson, 'id',''),
                    'date' => Carbon::parse(data_get($lesson, 'start_at.date',''))->format('d/m/Y H:i'),
                ],
                data_get($classData, 'lessons.data.*', [])
            );
        }
    }

    public function setStudents(): void
    {
        if($this->selectedLesson !== -1){
           
            $lessonsWithClassAndStudents = $this->teacherScheduleService->getEntityData(EntityEnum::LESSONS, ['class.students'], $this->selectedLesson);

            //get the students from the response
            $this->students = data_get($lessonsWithClassAndStudents, 'class.data.students.data.*', '');
        }
    }
}
