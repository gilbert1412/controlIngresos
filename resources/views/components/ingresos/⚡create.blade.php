<?php

use Livewire\Component;
use App\Models\Guardianes;
use App\Models\Campos;
use App\Models\Ingreos;
new class extends Component
{
    public $numRecibo,$fechaIngreso,$campos_id,$guardianes_id,$monto;
    public $guardianes=[];
    public $campos=[];
    
    protected   $rules=[
        'numRecibo'=>'required',
        'fechaIngreso'=>'required',
        'campos_id'=>'required',
        'guardianes_id'=>'required',
        'monto'=>'required'
    ];

    public function guardarIngresos(){
        $this->validate();
        Ingreos::create([
            'numRecibo'=> $this->numRecibo,
            'fechaIngreso'=> $this->fechaIngreso,
            'campos_id'=> $this->campos_id,
            'guardianes_id'=> $this->guardianes_id,
            'monto'=>$this->monto
        ]);
        $this->reset(['numRecibo','fechaIngreso','campos_id','guardianes_id','monto']);
        session()->flash('success', 'Ingreso Registrado con exito.');
    }
    public function mount(){
        $this->guardianes=Guardianes::where('estado','activo')->get();
        $this->campos=Campos::where('estado','activo')->get();
    }
};
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                {{-- Cabecera --}}
                <div class="card-header border-0 py-3 px-4" style="background-color: #185FA5;">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <div class="d-flex align-items-center justify-content-center rounded-circle"
                                    style="width:32px; height:32px; background:rgba(255,255,255,0.2);">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="white"
                                        stroke-width="2.5">
                                        <circle cx="12" cy="12" r="10" />
                                        <path d="M4.93 4.93l14.14 14.14" />
                                        <path d="M4.93 19.07L19.07 4.93" />
                                        <circle cx="12" cy="12" r="4" />
                                    </svg>
                                </div>
                                <span class="text-white fw-medium" style="font-size:15px; letter-spacing:.3px;">
                                    Campo Deportivo
                                </span>
                            </div>
                            <small style="color:rgba(255,255,255,.6); font-size:12px; padding-left:40px;">
                                Sistema de Gestión de Ingresos
                            </small>
                        </div>

                        <div class="text-center px-3 py-2 rounded-3"
                            style="background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.3); min-width:110px;">
                            <div style="color:rgba(255,255,255,.7); font-size:11px;">N° Recibo</div>
                            <div class="text-white fw-medium" style="font-size:15px;">
                                <p> <span>Nº</span> {{$numRecibo}} </p>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Cuerpo --}}
                <div class="card-body px-4 py-4">

                    @if (session('success'))
                    <div class="alert d-flex align-items-center gap-2 py-2 rounded-3 border-0 mb-3"
                        style="background:#d1fae5; color:#065f46; font-size:13px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        {{ session('success') }}
                    </div>
                    @endif

                    <form wire:submit="guardarIngresos" autocomplete="off">
                        @csrf

                        {{-- Fila 1: N° Recibo + Fecha --}}
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label text-uppercase fw-medium text-secondary"
                                    style="font-size:11px; letter-spacing:.5px;">
                                    Número de Recibo
                                </label>
                                <input type="text" wire:model.live="numRecibo" placeholder="Ej: 000123"
                                    class="form-control form-control-sm rounded-3 @error('numRecibo') is-invalid @enderror">
                                @error('numRecibo')
                                <div class="invalid-feedback" style="font-size:12px;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label text-uppercase fw-medium text-secondary"
                                    style="font-size:11px; letter-spacing:.5px;">
                                    Fecha de Ingreso
                                </label>
                                <input type="date" wire:model="fechaIngreso"
                                    class="form-control form-control-sm rounded-3 @error('fechaIngreso') is-invalid @enderror">
                                @error('fechaIngreso')
                                <div class="invalid-feedback" style="font-size:12px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Fila 2: Campo + Guardián --}}
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label text-uppercase fw-medium text-secondary"
                                    style="font-size:11px; letter-spacing:.5px;">
                                    Campo
                                </label>
                                <select wire:model.live="campos_id"
                                    class="form-select form-control rounded-3 @error('campos_id') is-invalid @enderror">
                                    <option value="">Seleccione un campo</option>
                                    @foreach($this->campos as $campo)
                                    <option value="{{ $campo->id }}">{{ $campo->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('campos_id')
                                <div class="invalid-feedback" style="font-size:12px;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label text-uppercase fw-medium text-secondary"
                                    style="font-size:11px; letter-spacing:.5px;">
                                    Guardián Responsable
                                </label>
                                <select wire:model="guardianes_id"
                                    class="form-select form-control rounded-3 @error('guardianes_id') is-invalid @enderror"
                                    wire:key="{{ $campos_id }}">
                                    <option value="">Seleccione un guardián</option>


                                    @foreach (Campos::where('guardianes_id','=' ,$campos_id)->get() as $guardianes)
                                    <option value="{{ $guardianes->id }}">
                                        {{ $guardianes->guardian->nombre }} {{ $guardianes->guardian->apePaterno }}
                                        {{ $guardianes->guardian->apeMaterno }}
                                    </option>
                                    @endforeach



                                </select>
                                @error('guardianes_id')
                                <div class="invalid-feedback" style="font-size:12px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Monto --}}
                        <div class="rounded-3 p-3 mb-4" style="background:#f8fafc; border:1px solid #e2e8f0;">
                            <label class="form-label text-uppercase fw-medium text-secondary d-block"
                                style="font-size:11px; letter-spacing:.5px;">
                                Monto Recaudado
                            </label>
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-medium text-secondary" style="font-size:22px;">S/.</span>
                                <input type="number" wire:model="monto" placeholder="0.00" step="0.01" min="0"
                                    class="form-control border-0 fw-medium p-0 @error('monto') is-invalid @enderror"
                                    style="font-size:36px; color:#0F6E56; background:transparent; box-shadow:none;">
                            </div>
                            @error('monto')
                            <div class="text-danger mt-1" style="font-size:12px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr style="border-color:#e2e8f0;">

                        {{-- Botones --}}
                        <div class="d-flex justify-content-between align-items-center">

                            <button type="button"
                                class="btn btn-light btn-sm rounded-3 d-flex align-items-center gap-2 border"
                                wire:click="$set('numRecibo',''); $set('campos_id',''); $set('guardianes_id',''); $set('monto',''); $set('fechaIngreso','') ">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M3 6h18M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                                    <path d="M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2" />
                                </svg>
                                Limpiar
                            </button>

                            <button type="submit"
                                class="btn btn-sm rounded-3 d-flex align-items-center gap-2 fw-medium text-white"
                                style="background:#185FA5; padding:8px 20px;">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="white"
                                    stroke-width="2.5">
                                    <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                                    <polyline points="17 21 17 13 7 13 7 21" />
                                    <polyline points="7 3 7 8 15 8" />
                                </svg>
                                Guardar Recibo
                            </button>

                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>