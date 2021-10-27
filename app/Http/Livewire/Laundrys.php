<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Laundry;
use App\Models\Type;
use Livewire\WithPagination;

class Laundrys extends Component
{
    use WithPagination;
    public $search;
    //public $mobils;
    public $laundryId,$laundry, $type, $harga;
    public $isOpen = 0;
    public function render()
    {
        $types = Type::all();
        $this->laundrys = Laundry::with('type');
        $searchParams = '%'.$this->search.'%';
        //$this->mobils = Mobil::all();
        return view('livewire.laundrys',[
            'laundrys' => Laundry::where('laundry','like', $searchParams)->latest()
                      ->orWhere('type', 'like', $searchParams)->latest()->paginate(5)
        ], compact('types'));
    }

    public function showModal(){
        $this->isOpen = true;
    }

    public function hideModal(){
        $this->isOpen = false;
    }

    public function store(){


        $types = Type::all();

        $this->validate(
                [
                    'laundry' => 'required',
                    'type' => 'required',
                    'harga' => 'required',
                ]
            );

            Laundry::updateOrCreate(['id' => $this->laundryId], [
                'laundry' => $this->laundry,
                'type' => $this->type,
                'harga' => $this->harga,
            ]);

            $this->hideModal();

            session()->flash('info', $this->laundryId ? 'Laundry Update Successfully' : 'Post Created Successfully');

            $this->laundryId = '';
            $this->laundry = '';
            $this->type = '';
            $this->harga = '';
    }

    public function edit($id){
        $laundrys = Laundry::findOrFail($id);
        $this->laundryId = $id;
        $this->laundry = $laundry->laundry;
        $this->type = $laundry->type;
        $this->harga = $laundry->harga;

        $this->showModal();
    }

    public function delete($id){
        Mobil::find($id)->delete();
        session()->flash('delete','Laundry Deleted Successfully');
    }


}
