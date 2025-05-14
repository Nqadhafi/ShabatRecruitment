<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Grade;

class GradeCrud extends Component
{
    public $grades, $name, $grade_id;
    public $isEditing = false;
    public $message = '';
    public $selectedGradeId; // Menyimpan ID untuk grade yang akan dihapus

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



    // Menampilkan modal konfirmasi penghapusan
public function closeModal(){
    $this->emit('closeDeleteModal'); // Menutup modal konfirmasi
}
    // Menghapus data grade
public function delete()
{
    Grade::find($this->selectedGradeId)->delete();
    $this->message = 'Grade deleted successfully.';
    $this->grades = Grade::all();  // Update data setelah penghapusan
    $this->selectedGradeId = null;
    $this->emit('closeDeleteModal'); // Menutup modal setelah penghapusan
}


    // Konfirmasi sebelum menghapus
    public function confirmDelete($id)
    {
        $this->selectedGradeId = $id;
        $this->emit('openDeleteModal'); // Membuka modal konfirmasi
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
