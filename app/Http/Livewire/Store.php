<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Activity;

class Store extends Component
{
    public $type = "0,1";
    public $search_input = '';

    public $date_from;
    public $date_to;

    public function render()
    {
        $new_type = explode(',',$this->type);

        $transactions = Activity::when($this->search_input, function($query){
            $query->search('general_description', $this->search_input)
            ->search('log_time', $this->search_input)
            ->search('quantity', $this->search_input);
        })
        ->whereIn('type', $new_type)
        ->orderBy('log_time', 'desc')
        ->paginate(15, ['general_description', 'quantity', 'log_time', 'type']);

        return view('livewire.store', ['transactions' => $transactions]);
    }

    public function generateReport(){
        $this->validate([
            'date_from' => 'required',
            'date_to' => 'required'
        ]);

        try{

            $transactions = Activity::join('medicines', 'activities.medicine_id', '=', 'medicines.id')
                ->whereDate('log_time','>=', $this->date_from)
                ->whereDate('log_time','<=', $this->date_to)
                ->count();

            if($transactions > 0){
                session()->flash('found','Printable Data!');
            }else{
                session()->flash('not_found', $transactions.' data!');
            }
        }catch(\Exception $e){
            session()->flash('error', 'Something went wrong!');
        }
    }
}
