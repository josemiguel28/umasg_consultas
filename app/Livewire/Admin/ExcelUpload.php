<?php

namespace App\Livewire\Admin;

use App\Imports\InvoicesImport;
use App\Models\CustomerInvoice;
use App\Models\FileUpload;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        
        // Crear registro de histórico
        $fileRecord = FileUpload::create([
            'user_id' => Auth::id(),
            'original_filename' => $this->file->getClientOriginalName(),
            'file_size' => $this->file->getSize(),
            'mime_type' => $this->file->getMimeType(),
            'status' => 'processing',
        ]);

        try {
            // Marcar como procesando
            $fileRecord->update(['status' => 'processing']);
            
            // GUARDAR EL ARCHIVO PERMANENTEMENTE ANTES DE PROCESAR
            $filePath = $this->file->store('uploads', 'public');
            
            // Contar registros antes de la importación
            $recordsBefore = CustomerInvoice::count();
            
            Excel::import(new InvoicesImport, $this->file);
            // Contar registros después de la importación
            $recordsAfter = CustomerInvoice::count();
            $recordsImported = $recordsAfter - $recordsBefore;
            
            // Actualizar el registro con el resultado exitoso
            $fileRecord->update([
                'status' => 'completed',
                'records_imported' => $recordsImported,
                'imported_at' => now(),
                'file_path' => $filePath, // Usar la ruta guardada
                'stored_filename' => basename($filePath), // Nombre del archivo almacenado
                'import_summary' => [
                    'total_records' => $recordsImported,
                    'import_date' => now()->toDateTimeString(),
                    'success' => true,
                ]
            ]);
            
            session()->flash('success', "Archivo Excel importado exitosamente! Se importaron {$recordsImported} registros.");
            
            // Limpiar el archivo después del procesamiento
            $this->reset('file');
            
            return redirect()->route('dashboard');
            
        } catch (\Exception $e) {
            // Actualizar el registro con el error
            $fileRecord->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'import_summary' => [
                    'error' => true,
                    'error_message' => $e->getMessage(),
                    'failed_at' => now()->toDateTimeString(),
                ]
            ]);
            
            session()->flash('error', 'Error al importar el archivo: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.excel-upload');
    }
}
