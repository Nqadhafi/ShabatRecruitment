
<div class="container">
    @if ($step == 1)
        {{-- Form profile umum part 1 --}}
        <label for="" class="mt-2">Nomor KTP :</label>
        @error('ktp_number')
            <div class="text-danger p-0 m-0"><small>{{ $message }}</small></div>
        @enderror
        <input type="number" wire:model="ktp_number" class="form-control ">
        <label for="" class="mt-2">Nama Lengkap :</label>
        @error('full_name')
            <div class="text-danger p-0 m-0"><small>{{ $message }}</small></div>
        @enderror
        <input type="text" wire:model="full_name" class="form-control ">
        <label for="" class="mt-2">Nama Panggilan :</label>
        @error('surname')
            <div class="text-danger p-0 m-0"><small>{{ $message }}</small></div>
        @enderror
        <input type="text" wire:model="surname" class="form-control ">
        <label for="" class="mt-2">Nomor Handphone Aktif</label>
        @error('phone_number')
            <div class="text-danger p-0 m-0"><small>{{ $message }}</small></div>
        @enderror
        <input type="number" wire:model="phone_number" class="form-control ">
        <label for="" class="mt-2">Alamat Domisili :</label>
        @error('address')
            <div class="text-danger p-0 m-0"><small>{{ $message }}</small></div>
        @enderror
        <textarea wire:model="address" cols="30" rows="10" class="form-control "></textarea>
        <button wire:click="nextStep" class="btn btn-primary">Next</button>
    @elseif($step == 2)
        {{-- Form Pendidikan. --}}
        <div>
            <label for="" class="mt-2">Pilih Jenjang Pendidikan :</label>
            @error('selectedGrade')
                <div class="text-danger p-0 m-0"><small>{{ $message }}</small></div>
            @enderror
            <select wire:model="selectedGrade" class="form-control">
                <option value="">Pilih jenjang pendidikan anda</option>
                @foreach ($grades as $grade)
                    <option value="{{ $grade->id }}"> {{ $grade->name }} </option>
                @endforeach
            </select>
            @error('selectedMajority')
                <div class="text-danger p-0 m-0"><small>{{ $message }}</small></div>
            @enderror
            @if ($selectedGrade && $majorities->count() > 0)
                <label for="" class="mt-2">Pilih Jurusan :</label>
                <select wire:model="selectedMajority" class="form-control">
                    <option value="">Pilih Jurusan</option>
                    @foreach ($majorities as $majority)
                        <option value="{{ $majority->id }}">{{ $majority->name }}</option>
                    @endforeach
                </select>
            @endif
            <label for="" class="mt-2">Nama Sekolah/Kampus :</label>
            @error('school_name')
                <div class="text-danger p-0 m-0"><small>{{ $message }}</small></div>
            @enderror
            <input type="text" wire:model="school_name" class="form-control"
                placeholder="Masukan Nama Sekolah, cth : Universitas Pajajaran">
            <label for="" class="mt-2">Tahun Lulus :</label>
            @error('graduate_year')
                <div class="text-danger p-0 m-0"><small>{{ $message }}</small></div>
            @enderror
            <input type="number" wire:model="graduate_year" class="form-control"
                placeholder="Masukan Tahun Lulus, cth : 2019">
            <label for="" class="mt-2">Nilai akhir(IPK/Danem) :</label>
            @error('last_score')
                <div class="text-danger p-0 m-0"><small>{{ $message }}</small></div>
            @enderror
            <input type="number" wire:model="last_score" class="form-control"
                placeholder="Masukan nilai akhir, cth 3.99">
        </div>
        <button wire:click="previousStep" class="btn btn-primary">Back</button>
        <button wire:click="nextStep" class="btn btn-primary">Next</button>
    @elseif($step == 3)
        {{-- Form profile umum part 2 --}}
        <label class="mt-2">Pas Foto Terbaru</label>
        @error('photo_path')
            <div class="text-danger p-0 m-0"><small>{{ $message }}</small></div>
        @enderror
        <input type="file" wire:model="photo_path" class="form-control">
        <label class="mt-2">Username Instagram (Opsional)</label>
        @error('instagram_surname')
            <div class="text-danger p-0 m-0"><small>{{ $message }}</small></div>
        @enderror
        <input type="text" wire:model="instagram_surname" class="form-control">
        <label class="mt-2">Link Linkedin (Opsional)</label>
        @error('linkedin_surname')
            <div class="text-danger p-0 m-0"><small>{{ $message }}</small></div>
        @enderror
        <input type="text" wire:model="linkedin_surname" class="form-control">

        <button wire:click="previousStep" class="btn btn-primary">Back</button>
        <button wire:click="save" class="btn btn-success">Save</button>
    @endif
</div>
