<?php

use Livewire\Component;
use App\Models\Campos;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
new class extends Component
{
    public $buscar='';
    #[Computed]
    #[on('recargar')]
     public function dataCampos()
    {
        return Campos::where('nombre','like','%'.$this->buscar.'%')->get();
    }

    
    public function editarCampo($id)
    {
        
        $this->dispatch('editar-campo',id:$id);
    }
    public function eliminarCampo($id)
    {
        $this->dispatch('eliminar-campo',id:$id);
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
                    <th>Guardian</th>
                    <th>Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                
                    @foreach ($this->dataCampos() as $campo)
                    <tr>
                         <th>{{ $loop->index +1 }}</th>
                        <th>{{ $campo->nombre }}</th>
                        <th>{{ $campo->guardian->nombre }} {{ $campo->guardian->apePaterno }} {{ $campo->guardian->apeMaterno }}</th>
                         <td>
                            @if ($campo->estado == 'inactivo' )
                                <span class="badge badge-danger">{{ $campo->estado }}</span>
                            @else
                                <span class="badge badge-success">{{ $campo->estado }}</span>
                            @endif

                        </td>
                         <td class="text-center">
                            @if ($campo->estado =='inactivo')
                                <button class="btn btn-sm btn-success" wire:click="editarCampo({{ $campo->id }})">
                                    <i class="fas fa-edit fa-sm"></i> Activar
                                </button>
                            @else
                            <button class="btn btn-sm btn-light text-info" wire:click="editarCampo({{ $campo->id }})"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-light text-danger" wire:click="eliminarCampo({{ $campo->id }})"><i class="fas fa-trash"></i></button>
                            @endif

                        </td>
                    </tr>
                       
                    @endforeach
               


            </tbody>
        </table>
    </div>
</div>
