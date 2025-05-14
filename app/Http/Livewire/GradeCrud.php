<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Grade;

class GradeCrud extends Component
{
    public $grades, $name, $grade_id;
    public $isEditing = false;
    public $message = '';

    // Menampilkan semua grade
    public function mount()
    {
        $this->grades = Grade::all();
    }

    // Simpan data baru atau update data yang sudah ada
    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:grades,name,' . $this->grade_id,
        ]);

        $grade = $this->isEditing ? Grade::find($this->grade_id) : new Grade();

        // Mengisi nama dan menyimpan data
        $grade->name = $this->name;
        $grade->save();

        $this->message = $this->isEditing ? 'Grade updated successfully.' : 'Grade created successfully.';

        // Reset form dan update daftar grade
        $this->resetFields();
        $this->grades = Grade::all();
    }

    // Mengedit data grade
    public function edit($id)
    {
        $grade = Grade::find($id);
        $this->grade_id = $grade->id;
        $this->name = $grade->name;
        $this->isEditing = true;
    }

    // Menghapus data grade
    public function delete($id)
    {
        Grade::find($id)->delete();
        $this->message = 'Grade deleted successfully.';
        $this->grades = Grade::all();
    }

    // Reset form fields
    private function resetFields()
    {
        $this->name = '';
        $this->grade_id = '';
        $this->isEditing = false;
    }

    public function render()
    {
        return view('livewire.grade-crud');
    }
}
