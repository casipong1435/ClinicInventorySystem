<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Log;

class Logs extends Component
{

    public $search_input = '';

    public function render()
    {
        $logs = Log::when($this->search_input, function($query){
                    $query->search('activity', $this->search_input)
                    ->search('log_time', $this->search_input);
                })
                ->orderBy('log_time', 'desc')
                ->paginate(15);

        return view('livewire.logs', ['logs' => $logs]);
    }
}
