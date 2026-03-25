<?php

use Livewire\Component;
use App\Models\Guardianes;
use Livewire\Attributes\On;
new class extends Component {
    public $apePaterno,
        $apeMaterno,
        $nombre,
        $id,
        $colorAlerta = '';
    private $sms = '';
    protected $rules = [
        'apePaterno' => 'required|string|max:255',
        'apeMaterno' => 'required|string|max:255',
        'nombre' => 'required|string|max:255',
    ];

    #[On('editar-guardian')]
    public function editar($id)
    {
        $this->id = $id;
        $guardian = Guardianes::find($id);
        if ($guardian->estado == 'inactivo') {
            $guardian->update([
                'estado' => 'activo',
            ]);
            session()->flash('message', [
                'text' => 'Guardían activado correctamente.',
                'color' => 'success',
            ]);
            $this->reset(['apePaterno', 'apeMaterno', 'nombre']);
        } else {
            $this->apePaterno = $guardian->apePaterno;
            $this->apeMaterno = $guardian->apeMaterno;
            $this->nombre = $guardian->nombre;
        }
        $this->dispatch('guardian-guardado');
    }
    #[On('eliminar-guardian')]
    public function eliminar($id)
    {
        $guardian = Guardianes::find($id);
        if ($guardian) {
            $guardian->update([
                'estado' => 'inactivo',
            ]);
            session()->flash('message', [
                'text' => 'Guardían eliminado correctamente.',
                'color' => 'danger',
            ]);
        }
        $this->dispatch('guardian-guardado');
    }

    public function guardarGuardianes()
    {
        $this->validate();

        // Aquí puedes agregar la lógica para guardar el guardián en la base de datos
        // Por ejemplo:
        if ($this->id) {
            $guardian = Guardianes::find($this->id);
            if ($guardian) {
                $guardian->update([
                    'apePaterno' => $this->apePaterno,
                    'apeMaterno' => $this->apeMaterno,
                    'nombre' => $this->nombre,
                ]);
                $this->sms = 'Guardían actualizado correctamente.';
                $this->colorAlerta = 'warning';
            }
        } else {
            Guardianes::create([
                'apePaterno' => $this->apePaterno,
                'apeMaterno' => $this->apeMaterno,
                'nombre' => $this->nombre,
            ]);
            $this->sms = 'Guardían creado correctamente.';
            $this->colorAlerta = 'success';
        }
        session()->flash('message', [
            'text' => $this->sms,
            'color' => $this->colorAlerta,
        ]);
        $this->reset(['id']);
        // Después de guardar, puedes limpiar los campos o redirigir a otra página
        $this->reset(['apePaterno', 'apeMaterno', 'nombre']);
        $this->dispatch('guardian-guardado');
    }
};
?>

<div class="card-body">

    @if (session('message'))
        <div class="alert alert-{{ session('message')['color'] }} alert-dismissible fade show" role="alert">
            {{ session('message')['text'] }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <form wire:submit="guardarGuardianes" autocomplete="off">
        @csrf
        <div class="form-group">
            <label class="small font-weight-bold text-dark" for="apePaterno">Apellido Paterno</label>
            <input type="text" class="form-control bg-light border-0" id="apePaterno" placeholder="Ej: García"
                wire:model="apePaterno" require>
            <div>
                @error('apePaterno')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="small font-weight-bold text-dark" for="apeMaterno">Apellido Materno</label>
            <input type="text" class="form-control bg-light border-0" id="apeMaterno" placeholder="Ej: López"
                wire:model="apeMaterno" require>
            <div>
                @error('apeMaterno')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="small font-weight-bold text-dark" for="nombre">Nombre(s)</label>
            <input type="text" class="form-control bg-light border-0" id="nombre" name="nombre"
                placeholder="Ej: Juan Carlos" wire:model="nombre" require>
            <div>
                @error('nombre')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <hr>

        <div class="d-flex justify-content-between">
            <button type="reset" class="btn btn-light btn-icon-split shadow-sm">
                <span class="icon text-gray-600"><i class="fas fa-eraser"></i></span>
                <span class="text">Limpiar</span>
            </button>
            <button type="submit" class="btn btn-primary btn-icon-split shadow-sm">
                <span class="icon text-white-50"><i class="fas fa-save"></i></span>
                <span class="text">Guardar</span>
            </button>
        </div>
    </form>
</div>
