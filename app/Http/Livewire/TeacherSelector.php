<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;

class TeacherSelector extends Component
{
    const NUMBER_OF_TEACHERS = 100;

    public $teachers = [];
    public $classes = [];
    public $students = [];

    public $selectedTeacher;
    public $selectedClass;

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

    public function render()
    {
        //
        //dd(json_decode($x->getBody()->getContents()));
        return view('livewire.teacher-selector');
    }

    public function setTeacherClasses()
    {
        if($this->selectedTeacher !== -1){

            //set teacher's classes according to the teacher selected
            $this->classes = data_get($this->teachers, $this->selectedTeacher.'.classes.data', []);
        }
    }

    public function getClassStudents()
    {
        if($this->selectedClass !== -1){
            //get class with its students
            $classRequest = Http::withToken(config('services.wonde.token'))
                ->get(
                    config('services.wonde.base_api_url').
                    config('services.wonde.schools_prefix'). '/'.
                    config('services.wonde.testing_school_id').
                    config('services.wonde.classes_endpoint'). '/'.
                    $this->selectedClass.
                    '?include=students'
                );  

            //check response
            if($classRequest->status() !== Response::HTTP_OK){
                return abort(500, 'There seems to be a technical issue, please contact technical support.');
            }
            
            $classData = json_decode($classRequest->getBody()->getContents(), true);
            
            $this->students = data_get($classData, 'data.students.data', []);
        }
    }
}
