<?php

use Livewire\Component;
use App\Models\Guardianes;
use App\Models\Campos;
use Livewire\Attributes\On;
new class extends Component {

    public $nombre, $guardian_id,$guardianes, $id, $colorAlerta = ''; 
     
    private $sms = '';

    protected $rules= [
        'nombre'=>'required|string',
        'guardian_id'=>'required'
    ];

    public function mount()
    {
        $this->guardianes = Guardianes::where('estado', '=', 'activo')->get();
    }

    #[On('editar-campo')]
    public function editar($id)
    {   
        $this->id=$id;
        
        $dataCampo=Campos::find($id);
        if($dataCampo->estado == 'inactivo'){
           
            $dataCampo->update([
                'estado'=>'activo'
            ]);
             session()->flash('message', [
                'text' => 'Campo activado correctamente.',
                'color' => 'success',
            ]);
        }else{
            $this->nombre=$dataCampo->nombre;
            $this->guardian_id=$dataCampo->guardianes_id;
        }
        $this->dispatch('recargar');
      
    }
    #[On('eliminar-campo')]
    public function eliminar($id){
       
        $data=Campos::find($id);
        $data->update([
            'estado'=>'inactivo'
        ]);
        session()->flash('message', [
                'text' => 'Campo eliminado correctamente.',
                'color' => 'danger',
            ]);
        $this->dispatch('recargar');
    }
    public function  guardarCampos()
    {

        //dd($this->nombre);

        $this->validate();
         $dataCampo=Campos::find($this->id);
        if($this->id){
            $dataCampo->update([
                'nombre'=>$this->nombre,
                'guardianes_id'=>$this->guardian_id
            ]);
             $this->sms = 'Campo actualizado correctamente.';
                $this->colorAlerta = 'warning';
        }else{
            Campos::create([
                'nombre'=>$this->nombre,
                'guardianes_id'=>$this->guardian_id
            ]);
            $this->sms = 'Campo creado correctamente.';
            $this->colorAlerta = 'success';
             
        }

        $this->reset(['nombre','guardian_id','id']);
        $this->dispatch('recargar');
        session()->flash('message', [
            'text' => $this->sms,
            'color' => $this->colorAlerta,
        ]);
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
    <form wire:submit="guardarCampos" autocomplete="off">
        @csrf
        <div class="form-group">
            <label class="small font-weight-bold text-dark" for="nombre">Nombre(s)</label>
            <input type="text" class="form-control bg-light border-0" id="nombre" name="nombre"
                placeholder="Ej: Campo Deportivo ..." wire:model="nombre" require>
            <div>
                @error('nombre')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="small font-weight-bold text-dark" for="apeMaterno">Seleccionar Guardian</label>
          <select name="guardian_id" id="guardian_id" wire:model="guardian_id" class="form-control bg-light border-0">
                <option value="">Seleccione un guardian</option>
                @foreach($this->guardianes as $guardian)
                    <option value={{ $guardian->id }}>{{ $guardian->nombre }} {{ $guardian->apePaterno }} {{ $guardian->apeMaterno }}</option>
                @endforeach
            </select>
            <div>
                @error('guardian_id')
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
