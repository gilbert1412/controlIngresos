<?php

use Livewire\Component;
use App\Models\Guardianes;
use App\Models\Campos;
new class extends Component
{
    public $guardianes=[];
    public $campos=[];

    public function mount(){
        $this->guardianes=Guardianes::where('estado','activo')->get();
        $this->campos=Campos::where('estado','activo')->get();
    }
};
?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Registro de Guardianes</h5>
    </div>
    <div class="card-body">
        <form wire:submit="guardarGuardianes" autocomplete="off">
            @csrf

            <!-- Fecha de ingreso -->
            <div class="form-group mb-3">
                <label for="fechaIngreso" class="form-label fw-bold">Fecha de Ingreso</label>
                <input type="date" id="fechaIngreso" class="form-control" wire:model="fechaIngreso">
                @error('fechaIngreso')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Monto recaudado -->
            <div class="form-group mb-3">
                <label for="monto" class="form-label fw-bold">Monto Recaudado</label>
                <input type="number" id="monto" class="form-control" wire:model="monto" placeholder="Ej: 1500">
                @error('monto')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Selección de guardián -->
            <div class="form-group mb-4">
                <label for="guardian_id" class="form-label fw-bold">Seleccionar Guardián</label>
                <select id="guardian_id" wire:model="guardian_id" class="form-control">
                    <option value="">Seleccione un guardián</option>
                    @foreach($this->guardianes as $guardian)
                        <option value="{{ $guardian->id }}">
                            {{ $guardian->nombre }} {{ $guardian->apePaterno }} {{ $guardian->apeMaterno }}
                        </option>
                    @endforeach
                </select>
                @error('guardian_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <!-- Selección de campo -->
            <div class="form-group mb-4">
                <label for="campos_id" class="form-label fw-bold">Seleccionar Guardián</label>
                <select id="campos_id" wire:model="campos_id" class="form-control">
                    <option value="">Seleccione un Campo</option>
                    @foreach($this->campos as $campo)
                        <option value="{{ $campo->id }}">
                            {{ $campo->nombre }} 
                        </option>
                    @endforeach
                </select>
                @error('campos_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-between">
                <button type="reset" class="btn btn-outline-secondary">
                    <i class="fas fa-eraser me-1"></i> Limpiar
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Guardar
                </button>
            </div>
    </div>
</div>