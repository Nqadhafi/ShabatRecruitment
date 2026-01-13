<?php

namespace App\Http\Livewire\Applicant\Boarding;

use App\Models\ApplicantProfile;
use App\Models\Education;
use Livewire\Component;
use App\Models\Grade;
use App\Models\Majority;
use App\Models\User;
use Livewire\WithFileUploads;
class CompleteProfile extends Component
{
    use WithFileUploads;
    public $step = 1;
    public $school_name, $graduate_year, $last_score;
    public $full_name, $surname, $ktp_number, $address, $phone_number, $photo_path, $instagram_surname, $linkedin_surname , $ktp_path;
    public $grades, $majorities, $selectedGrade, $selectedMajority;
    public $loading = false; // Add loading state

    public function mount(){
        $this->grades = cache()->remember('grades', 3600, function() {
            return Grade::all();
        });
        $this->selectedGrade = null;
    }

    public function updatedSelectedGrade($value)
    {
        if ($value) {
            $this->majorities = cache()->remember('majorities_' . $value, 3600, function() use ($value) {
                return Majority::where('grade_uuid', $value)->get(['id', 'name']);
            });
        } else {
            $this->majorities = [];
        }
    }

    public function validateStep($step){
        $this->loading = true; // Set loading state
        if($step == 1){
            $this->validate([
                'ktp_number' => 'required|string|regex:/^[0-9]{16}$/',
                'ktp_path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                'full_name' => 'required|string|max:50',
                'surname' => 'required|string|max:50',
                'phone_number' => 'required|string|regex:/^([0][8][1-9][0-9]{7,11})$/',
                'address' => 'required|max:255'
            ]);
        
        }
                elseif($step == 2){
            $Tyear = 2025;
            $this->validate([
                'selectedGrade' => 'required',
                'selectedMajority' => 'required',
                'school_name' => 'required|string|max:50',
                'graduate_year' => 'required|numeric|min:1|digits_between:4,4|BeforeOrEqual:' . $Tyear
            ]);
        }
        elseif($step == 3){
                $this->validate([
                    'photo_path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                    'instagram_surname' => 'nullable|string|max:255',
                    'linkedin_surname' => 'nullable|string|max:255',
                ]);
            
        }
        $this->loading = false; // Reset loading state
    }

    public function save(){
        $this->loading = true; // Set loading state
        $education = Education::create([
        'school_name' => $this->school_name,
        'graduate_year' => $this->graduate_year,
        'last_score' => $this->last_score,
        'majority_uuid' => $this->selectedMajority,
    ]);
    $ktpPath = null;
        if ($this->ktp_path) {
            $ktpPath = $this->ktp_path->store('ktp', 'public'); // Upload file ke folder 'ktp'
        }
        $photoPath = null;
        if ($this->photo_path) {
            $photoPath = $this->photo_path->store('photos', 'public'); // Upload file ke folder 'photos'
        }
        $profile = ApplicantProfile::create([
            'full_name' => $this->full_name,
            'surname' => $this->surname,
            'ktp_number' => $this->ktp_number,
            'ktp_path' => $ktpPath,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'photo_path' => $photoPath,
            'instagram_surname' =>$this->instagram_surname,
            'linkedin_surname' => $this->linkedin_surname
        ]);

$profile->update(['education_uuid' => $education->id]);
$userid = auth()->user()->id;
$user = User::where('id', $userid);
$user->update(['profiles_uuid' => $profile->id]);



$this->loading = false; // Reset loading state
return redirect()->route('applicant.dashboard')->with('success', 'data berhasil di input');



    }


    public function nextStep()
    {
        $this->validateStep($this->step);

        if ($this->step < 3) {
            $this->step++;
        }
    }
    public function previousStep(){
        if($this->step>1){
            $this->step--;
        }
    }

    public function render()
    {
        return view('livewire.applicant.boarding.complete-profile');
    }
}
