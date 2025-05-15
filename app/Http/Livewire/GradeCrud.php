<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Grade;

class GradeCrud extends Component
{
    public $grades, $name, $grade_id;
    public $isEditing = false;
    public $selectedGradeId; // Menyimpan ID untuk grade yang akan dihapus
    public $modalType = ''; // 'create' or 'delete'
    // Menampilkan semua grade
    public function mount()
    {
        $this->grades = Grade::orderByDesc('created_at')->get();
    }

    public function create()
    {
        $this->resetFields();
        $this->modalType = 'create';  // Set type modal to 'create'
        $this->emit('openModal', 'create');
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

        // $this->message = ;
        session()->flash('message', $this->isEditing ? 'Grade updated successfully.' : 'Grade created successfully.');
        // Reset form dan update daftar grade
        $this->resetFields();
        $this->emit('closeModal');
        $this->grades = Grade::orderByDesc('created_at')->get();
    }

    // Mengedit data grade
    public function edit($id)
    {
        $grade = Grade::find($id);
        $this->grade_id = $grade->id;
        $this->name = $grade->name;
        $this->isEditing = true;
        $this->modalType = 'edit';  // Set type modal to 'edit'
        $this->emit('openModal', 'edit');
    }



    // Menampilkan modal konfirmasi penghapusan
    public function closeModal()
    {
        $this->emit('closeModal');
    }
    // Menghapus data grade
public function delete()
{
    Grade::find($this->selectedGradeId)->delete();
    session()->flash('message', 'Grade deleted successfully.');
    $this->grades = Grade::orderByDesc('created_at')->get();  // Update data setelah penghapusan
    $this->selectedGradeId = null;
    $this->emit('closeModal'); // Menutup modal setelah penghapusan
}


    // Konfirmasi sebelum menghapus
    public function confirmDelete($id)
    {
        $this->selectedGradeId = $id;
        $this->modalType = 'delete';  // Set type modal to 'delete'
        $this->emit('openModal', 'delete');
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
        return view('livewire.admin.grade-crud');
    }
}
