<?php

namespace App\Livewire\Admin;

use App\Imports\InvoicesImport;
use App\Models\CustomerInvoice;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ExcelUpload extends Component
{
    use WithFileUploads;

    public $file;

    public function save()
    {
        // Validar el archivo
        $this->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:10240', // 10MB
        ]);

        try {
            // Aquí es cuando realmente se sube y procesa el archivo
            Excel::import(new InvoicesImport, $this->file);
            
            session()->flash('success', 'Archivo Excel importado exitosamente!');
            
            // Limpiar el archivo después del procesamiento
            $this->reset('file');
            
            return redirect()->route('dashboard');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al importar el archivo: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.excel-upload');
    }
}
