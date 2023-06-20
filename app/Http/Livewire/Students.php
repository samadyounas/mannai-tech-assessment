<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Student;
use App\Models\temporaryFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Students extends Component
{   
    public $students;
    public $name;
    public $grade;
    public $department;
    public $filepond;

    public function mount()
    {
        // $this->students = Student::all();
        $this->students = Cache::remember('all_students', 60, function () {
            return Student::all();
        });
    }
    public function create()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'grade' => 'required',
            'department' => 'required',
        ]);
        $student = Student::create([
            'name' => $this->name,
            'grade' => $this->grade,
            'department' => $this->department,
        ]);
        $tempFile = temporaryFile::where('user_id', 22)->first();
        $student->update([
            'image' => $tempFile->fileName
        ]);
        $tempFile->delete();
        Cache::forget('all_students');
        $this->resetFields();
        $this->mount();
    }

    public function delete($id)
    {
        $student = Student::find($id);
        if ($student) {
            Storage::delete('/public/avatars/'.$student->image);
            $student->delete();
            $this->mount();
        }
    }

    private function resetFields()
    {
        $this->name = '';
        $this->grade = '';
        $this->department = '';
    }
    public function render()
    {
        return view('livewire.students');
    }
}
