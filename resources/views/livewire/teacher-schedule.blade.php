<div class="wrapper">
    <p wire:loading class="loading">Loading...</p>

    <legend>Please select your name (as a teacher) from the list below</legend>
    <select wire:model="selectedTeacher" wire:change="setClasses">
        <option value="-1">Please select your name</option>
        @foreach ($teachers as $key => $teacher)
            <option value="{{$key}}">{{$teacher['forename'].' '.$teacher['surname']}}</option>
        @endforeach
    </select>

    <legend>Please select the class</legend>
    <select wire:model="selectedClass" wire:change="setLessons">
        <option value="-1">Please select the class</option>
        @foreach ($classes as $class)
            <option value="{{$class['id']}}">{{$class['name']}}</option>
        @endforeach
    </select>

    <legend>Please select the lesson date</legend>
    <select wire:model="selectedLesson" wire:change="setStudents">
        <option value="-1">Please select the day</option>
        @foreach ($lessons as $lesson)
            <option value="{{$lesson['id']}}">{{$lesson['date']}}</option>
        @endforeach
    </select>

    <div>
        @if (!empty($students))
            <h1>List of students</h1>
            <table>
                <thead>
                    <tr>
                        <th>
                            Id
                        </th>
                        <th>
                            Forename
                        </th>
                        <th>
                            Surname
                        </th>
                    </tr>
                </thead>
                @foreach ($students as $student)
                <tr>
                    <td>{{$student['id']}}</td>
                    <td>{{$student['forename']}}</td>
                    <td>{{$student['surname']}}</td>
                </tr>
                @endforeach
            </table>
        @endif
    </div>
</div>