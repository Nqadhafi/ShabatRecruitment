<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearLivewireTmp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'livewire:clear-tmp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hapus semua file sementara dari livewire-tmp';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
public function handle()
    {
        $tmpDir = storage_path('app/livewire-tmp/');
        
        if (File::isDirectory($tmpDir)) {
            File::cleanDirectory($tmpDir);
            $this->info('Semua file sementara Livewire berhasil dihapus.');
        } else {
            $this->warn('Direktori livewire-tmp tidak ditemukan.');
        }
    }
}
