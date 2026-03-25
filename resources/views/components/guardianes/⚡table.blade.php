<?php

use Livewire\Component;
use App\Models\Guardianes;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
new class extends Component {
    public $buscar = '';


    #[Computed]
    #[On('guardian-guardado')]
    public function guardianes()
    {
        return Guardianes::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orWhere('apePaterno', 'like', '%' . $this->buscar . '%')
            ->get();
    }

    public function editarGuardian($id)
    {

        $this->dispatch('editar-guardian', id: $id);
    }
    public function eliminarGuardian($id)
    {
        $this->dispatch('eliminar-guardian', id: $id);

    }

};
?>

<div class="card-body">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-list fa-sm mr-1"></i> Lista de Guardianes
        </h6>
        <input type="text" placeholder="Buscar por nombre..." wire:model.live="buscar"
            class="form-control form-control-sm w-25">
    </div>

    <div class="table-responsive">
        <table class="table table-hover border-0" width="100%" cellspacing="0">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->guardianes() as $guardian)
                    <tr wire:key="guardian-{{ $guardian->id }}">
                        <td>{{ $loop->index+1}}</td>
                        <td>{{ $guardian->nombre }} {{ $guardian->apePaterno }} {{ $guardian->apeMaterno }}</td>
                        <td>
                            @if ($guardian->estado == 'inactivo' )
                                <span class="badge badge-danger">{{ $guardian->estado }}</span>
                            @else
                                <span class="badge badge-success">{{ $guardian->estado }}</span>
                            @endif

                        </td>
                        <td class="text-center">
                            @if ($guardian->estado =='inactivo')
                                <button class="btn btn-sm btn-success" wire:click="editarGuardian({{ $guardian->id }})">
                                    <i class="fas fa-edit fa-sm"></i> Activar
                                </button>
                            @else
                            <button class="btn btn-sm btn-light text-info" wire:click="editarGuardian({{ $guardian->id }})"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-light text-danger" wire:click="eliminarGuardian({{ $guardian->id }})"><i class="fas fa-trash"></i></button>
                            @endif

                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
</div>
