<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Carbon\Carbon;

class TeacherSchedule extends Component
{
    const NUMBER_OF_TEACHERS = 100;

    public array $teachers = [];
    public array $classes = [];
    public array $lessons = [];
    public array $students = [];

    public int $selectedTeacher;
    public string $selectedClass;
    public string $selectedLesson;

    public function render()
    {
        return view('livewire.teacher-schedule');
    }

    public function mount(){
        
        //get teachers with their classes
        $teachersRequest = Http::withToken(config('services.wonde.token'))
            ->get(
                config('services.wonde.base_api_url').
                config('services.wonde.schools_prefix'). '/'.
                config('services.wonde.testing_school_id').
                config('services.wonde.employees_endpoint').
                '?has_class=1&include=classes&per_page='.self::NUMBER_OF_TEACHERS
            );  

        //check response
        if($teachersRequest->status() !== Response::HTTP_OK){
            return abort(500, 'There seems to be a technical issue, please contact technical support.');
        }
        
        $teachers = json_decode($teachersRequest->getBody()->getContents(), true);

        $this->teachers = $teachers['data'];
    }

    public function setTeacherClasses()
    {
        if($this->selectedTeacher !== -1){
            //set teacher's classes according to the teacher selected
            $this->classes = data_get($this->teachers, $this->selectedTeacher.'.classes.data', []);
        }
    }

    public function getDays()
    {
        if($this->selectedClass !== -1){
            //get class with its students
            $lessonRequest = Http::withToken(config('services.wonde.token'))
                ->get(
                    config('services.wonde.base_api_url').
                    config('services.wonde.schools_prefix'). '/'.
                    config('services.wonde.testing_school_id').
                    config('services.wonde.classes_endpoint'). '/'.
                    $this->selectedClass.
                    '?include=lessons'
                );  

            //check response
            if($lessonRequest->status() !== Response::HTTP_OK){
                return abort(500, 'There seems to be a technical issue, please contact technical support.');
            }
            
            $dayData = json_decode($lessonRequest->getBody()->getContents(), true);
            
            $this->lessons = array_map( 
                fn($lessonData) =>  
                [
                    'id' => data_get($lessonData, 'id',''),
                    'date' => Carbon::parse(data_get($lessonData, 'start_at.date',''))->format('d/m/Y H:i'),
                ],
                data_get($dayData, 'data.lessons.data.*', [])
            );
        }
    }

    public function getClassesWithStudents()
    {
        if($this->selectedLesson !== -1){
            //get the lesson with its class
            $lessonRequest = Http::withToken(config('services.wonde.token'))
                ->get(
                    config('services.wonde.base_api_url').
                    config('services.wonde.schools_prefix'). '/'.
                    config('services.wonde.testing_school_id').
                    config('services.wonde.lessons_endpoint'). '/'.
                    $this->selectedLesson.
                    '?include=class'
                );

            //check response
            if($lessonRequest->status() !== Response::HTTP_OK){
                return abort(500, 'There seems to be a technical issue, please contact technical support.');
            }
            
            $lessonData = json_decode($lessonRequest->getBody()->getContents(), true);

            //get the class id attached to the lesson
            $classId = data_get($lessonData, 'data.class.data.id', '');

            //get the class with its students
            $classRequest = Http::withToken(config('services.wonde.token'))
            ->get(
                config('services.wonde.base_api_url').
                config('services.wonde.schools_prefix'). '/'.
                config('services.wonde.testing_school_id').
                config('services.wonde.classes_endpoint'). '/'.
                $classId.
                '?include=students'
            );

            //check response
            if($classRequest->status() !== Response::HTTP_OK){
                return abort(500, 'There seems to be a technical issue, please contact technical support.');
            }

            $classData = json_decode($classRequest->getBody()->getContents(), true);
            
            $this->students = data_get($classData, 'data.students.data.*', []);
        }
    }
}
