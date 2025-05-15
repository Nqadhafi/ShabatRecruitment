<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Majority;
use App\Models\Grade;

class MajorityCrud extends Component
{
    public $majorities, $name, $grade_uuid, $majority_id;
    public $isEditing = false;
    public $selectedMajorityId; // Untuk menyimpan ID mayoritas yang akan dihapus
    public $modalType = ''; // 'create', 'edit', or 'delete'
    public $grades;

    // Menampilkan semua mayoritas
    public function mount()
    {
        $this->majorities = Majority::with('grade')->orderByDesc('created_at')->get();
        $this->grades = Grade::orderByDesc('created_at')->get(); // Ambil data grades untuk dropdown
    }

    // Menampilkan form Create
    public function create()
    {
        $this->resetFields();
        $this->modalType = 'create';  // Set type modal to 'create'
        $this->emit('openModal', 'create');
    }

    // Simpan data baru atau update mayoritas
    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'grade_uuid' => 'required|exists:grades,id', // Validasi bahwa grade_uuid ada di kolom 'id' tabel 'grades'
        ]);
    
        $majority = $this->isEditing ? Majority::find($this->majority_id) : new Majority();
        $majority->name = $this->name;
        $majority->grade_uuid = $this->grade_uuid;
        $majority->save();
    
        session()->flash('message', $this->isEditing ? 'Majority updated successfully.' : 'Majority created successfully.');
        $this->resetFields();
        $this->emit('closeModal');
        $this->majorities = Majority::with('grade')->orderByDesc('created_at')->get();
    }

    // Mengedit data mayoritas
    public function edit($id)
    {
        $majority = Majority::find($id);
        $this->majority_id = $majority->id;
        $this->name = $majority->name;
        $this->grade_uuid = $majority->grade_uuid;
        $this->isEditing = true;
        $this->modalType = 'edit';  // Set type modal to 'edit'
        $this->emit('openModal', 'edit');
    }

    // Menghapus mayoritas
    public function delete()
    {
        Majority::find($this->selectedMajorityId)->delete();
        session()->flash('message', 'Majority deleted successfully.');
        $this->majorities = Majority::with('grade')->orderByDesc('created_at')->get();
        $this->selectedMajorityId = null;
        $this->emit('closeModal');
    }

    // Menampilkan modal konfirmasi penghapusan
    public function confirmDelete($id)
    {
        $this->selectedMajorityId = $id;
        $this->modalType = 'delete';  // Set type modal to 'delete'
        $this->emit('openModal', 'delete');
    }

    // Menutup modal
    public function closeModal()
    {
        $this->emit('closeModal');
    }

    // Reset form fields
    private function resetFields()
    {
        $this->name = '';
        $this->grade_uuid = '';
        $this->majority_id = '';
        $this->isEditing = false;
        $this->modalType = '';
    }

    public function render()
    {
        return view('livewire.admin.majority-crud');
    }
}
