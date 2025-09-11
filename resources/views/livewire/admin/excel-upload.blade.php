<div class="flex h-full w-full flex-1 flex-col gap-8 p-6 bg-gray-50 dark:bg-gray-900">


    <!-- Header -->
    <div
        class="flex items-center justify-between bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                <flux:icon.upload class="w-8 h-8 text-blue-600 dark:text-blue-400" />
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Subir archivo Excel</h1>
                <p class="text-gray-500 dark:text-gray-400">Importa datos desde un archivo Excel (.xlsx, .xls)</p>
            </div>
        </div>
        <flux:button variant="ghost" href="{{ route('dashboard') }}" wire:navigate>
            <flux:icon.arrow-left class="w-4 h-4 mr-2" />
            Volver al dashboard
        </flux:button>
    </div>


    <!-- Help Section -->
    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-2xl border border-blue-200 dark:border-blue-800 p-6">
        <div class="flex items-start gap-4">
            <div class="p-2 bg-blue-100 dark:bg-blue-900/40 rounded-lg">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Formato requerido del archivo</h3>
                <ul class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                    <li>• El archivo debe estar en formato Excel (.xlsx o .xls)</li>
                    <flux:heading class="flex items-center gap-2">
                        • Las cabeceras deben estar en la tercera fila del archivo

                        <flux:tooltip toggleable>
                            <flux:button icon="information-circle" size="sm" variant="ghost" />

                            <flux:tooltip.content class="max-w-[20rem] space-y-2">
                                <p>Las cabeceras que esperan son:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Ruta</li>
                                    <li>Clave</li>
                                    <li>Propietario</li>
                                    <li>Direccion</li>
                                    <li>Categoria</li>
                                    <li>Estado</li>
                                    <li>Tiene_med</li>
                                    <li>Medidor</li>
                                    <li>M3facturado</li>
                                    <li>Saldoagua</li>
                                    <li>Saldoalca</li>
                                    <li>Saldootro</li>
                                </ul>
                            </flux:tooltip.content>
                        </flux:tooltip>
                    </flux:heading>
                    <li>• Máximo 10,000 registros por archivo</li>
                    <li>• Tamaño máximo: 10MB</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Upload Form -->
    <div
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-8">
            <form wire:submit="save" class="space-y-6">

                <!-- File Upload Area -->
                <div class="space-y-4">
                    <flux:field>
                        <flux:label>Seleccionar archivo</flux:label>

                        <!-- Drag & Drop Area -->
                        <div class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-8 text-center hover:border-blue-400 dark:hover:border-blue-500 transition-colors duration-200"
                            x-data="{
                                isDragging: false,
                                fileName: null
                            }" @dragover.prevent="isDragging = true"
                            @dragleave.prevent="isDragging = false"
                            @drop.prevent="
                                    isDragging = false; 
                                    $refs.fileInput.files = $event.dataTransfer.files;
                                    fileName = $event.dataTransfer.files[0]?.name;
                                "
                            :class="{ 'border-blue-400 bg-blue-50 dark:bg-blue-900/10': isDragging }">
                            <div class="space-y-4">
                                <!-- Upload Icon -->
                                <div
                                    class="mx-auto w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                    <flux:icon.upload class="w-8 h-8 text-gray-400" />
                                </div>

                                <!-- Upload Text -->
                                <div class="space-y-2">
                                    <p class="text-lg font-medium text-gray-700 dark:text-gray-300">
                                        Arrastra tu archivo aquí o
                                        <button type="button"
                                            class="text-blue-600 dark:text-blue-400 underline hover:text-blue-700"
                                            @click="$refs.fileInput.click()">
                                            selecciona uno
                                        </button>
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Formatos soportados: .xlsx, .xls (máximo 10MB)
                                    </p>
                                </div>

                                <!-- Selected File Info -->
                                <div x-show="fileName"
                                    class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mt-4">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <span class="text-sm font-medium text-green-700 dark:text-green-300"
                                            x-text="fileName"></span>
                                        <button type="button" @click="fileName = null; $refs.fileInput.value = ''"
                                            class="ml-auto text-green-600 dark:text-green-400 hover:text-green-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden File Input -->
                            <input type="file" x-ref="fileInput" wire:model="file" accept=".xlsx,.xls" class="hidden"
                                @change="fileName = $event.target.files[0]?.name">
                        </div>

                        <flux:error name="file" />
                    </flux:field>
                </div>

                <!-- Progress Bar (shown during upload) -->
                <div wire:loading wire:target="upload" class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Procesando archivo...</span>
                        <span class="text-blue-600 dark:text-blue-400">0%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full animate-pulse" style="width: 30%"></div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <flux:button type="submit" variant="primary" class="flex-1">
                        <flux:icon.upload class="w-4 h-4 mr-2 " />
                        <span wire:loading.remove wire:target="save">Subir e importar archivo</span>
                        <span wire:loading wire:target="save">Procesando...</span>
                    </flux:button>

                    <flux:button variant="ghost" href="{{ route('dashboard') }}" wire:navigate class="sm:w-auto">
                        Cancelar
                    </flux:button>
                </div>
            </form>
        </div>
    </div>

</div>
