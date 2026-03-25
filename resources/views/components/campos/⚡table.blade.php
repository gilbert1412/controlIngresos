<?php

use Livewire\Component;

new class extends Component
{
    //
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



            </tbody>
        </table>
    </div>
</div>
