<?php

namespace App\Livewire\Admin;

use App\Models\FileUpload;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        // Obtener los últimos archivos subidos
        $files = FileUpload::with('user')
            ->latest()
            ->take(10)
            ->get();

        // Obtener la fecha del último archivo subido (última actualización)
        $lastUpload = FileUpload::latest()->first();

        return view('livewire.admin.dashboard', compact('files', 'lastUpload'));
    }
}
