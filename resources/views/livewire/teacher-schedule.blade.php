<div class="wrapper">
    <p wire:loading class="loading">Loading...</p>

    <legend>Please select your name (as a teacher) from the list below</legend>
    <select wire:model="selectedTeacher" wire:change="setTeacherClasses">
        <option value="-1">Please select your name</option>
        @foreach ($teachers as $key => $teacher)
            <option value="{{$key}}">{{$teacher['forename'].' '.$teacher['surname']}}</option>
        @endforeach
    </select>

    <legend>Please select the class</legend>
    <select wire:model="selectedClass" wire:change="getDays">
        <option value="-1">Please select the class</option>
        @foreach ($classes as $class)
            <option value="{{$class['id']}}">{{$class['name']}}</option>
        @endforeach
    </select>

    <legend>Please select the lesson date</legend>
    <select wire:model="selectedLesson" wire:change="getClassesWithStudents">
        <option value="-1">Please select the day</option>
        @foreach ($lessons as $lesson)
            <option value="{{$lesson['id']}}">{{$lesson['date']}}</option>
        @endforeach
    </select>

    <div>
        @if (!empty($students))
            <h1>List of students</h1>
        @endif
        @foreach ($students as $student)
            <span>{{$student['forename'].' '. $student['surname']}}</span><br>
        @endforeach
    </div>
</div>
