<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Medicine;
use App\Models\Activity;
use App\Models\Unit;
use App\Models\log;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class Home extends Component
{
    public $general_description;
    public $quantity;
    public $unit_of_measure = '';
    public $how_to_use = '';
    public $warning = '';
    public $side_effect = '';
    public $direction = '';
    public $search_input = '';
    public $new_unit;

    public $editID;
    public $deleteID;


    public $isAdd = true;
    public $isAddUnit = false;
    public $total;

    public function render()
    {
        $medicines = Medicine::leftJoin('units', 'medicines.unit_of_measure', '=', 'units.id')
                                    ->when($this->search_input, function($query){
                                        $query->search('general_description', $this->search_input)
                                        ->search('quantity', $this->search_input)
                                        ->search('units.unit_of_measurement', $this->search_input)
                                        ->search('medicines.how_to_use', $this->search_input)
                                        ->search('medicines.warning', $this->search_input)
                                        ->search('medicines.side_effect', $this->search_input)
                                        ->search('medicines.direction', $this->search_input);
                                    })->get(['general_description', 'quantity', 'units.unit_of_measurement', 'medicines.id']);
        $units = Unit::get();

        return view('livewire.home', ['medicines' => $medicines, 'units' => $units]);
    }

    public function resetFields(){
        $this->general_description = '';
        $this->unit_of_measure = '';
        $this->quantity = '';
        $this->editID = '';
        $this->new_unit = '';
        $this->isAddUnit = false;
    }

    public function addMedicine(){
        $this->validate([
            'general_description' => 'required|unique:medicines,general_description',
            'unit_of_measure' => 'required',
        ]);

        try{
            $values = [
                'general_description' => $this->general_description,
                'unit_of_measure' => $this->unit_of_measure,
            ];

            $log_values = [
                'activity' => 'Added '.$this->general_description.' to the list',
                'log_time' => Carbon::now('Asia/Manila')
            ];

            Medicine::create($values);
            Log::create($log_values);
            $this->resetFields();
            session()->flash('added', 'Item Added Successfully!');
        }catch(\Exception $e){
            session()->flash('error', 'Something went wrong!!');
        }
    }

    public function getDeleteID($id){
        $decrypted_id = Crypt::decrypt($id);
        $this->deleteID = $decrypted_id;
    }

    public function deleteMedicine(){
        $medicine = Medicine::where('id', $this->deleteID)->first(['general_description']);

        try{
            $log_values = [
                'activity' => 'Deleted '.$medicine->general_description,
                'log_time' => Carbon::now('Asia/Manila')
            ];

            Log::create($log_values);

            Medicine::where('id', $this->deleteID)->delete();
            session()->flash('success', 'Item Deleted!');
            $this->dispatchBrowserEvent('hide-modal');
        }catch(\Exception $e){
            session()->flash('error', 'Something went wrong!!');
        }
    }

    public function editMedicine(){
        $decrypted_id = Crypt::decrypt($this->editID);

        $this->validate([
            'general_description' => 'required',
            'unit_of_measure' => 'required'
        ]);
       
        try{
            $values = [
                'general_description' => $this->general_description,
                'unit_of_measure' => $this->unit_of_measure,
                'how_to_use' => $this->how_to_use,
                'warning' => $this->warning,
                'side_effect' => $this->side_effect,
                'direction' => $this->direction,
            ];

            $log_values = [
                'activity' => 'Edited '.$this->general_description,
                'log_time' => Carbon::now('Asia/Manila')
            ];

            Log::create($log_values);
            Medicine::where('id', $decrypted_id)->update($values);
            session()->flash('success', 'Item Edited Successfully!');
            $this->cancelEdit();
            $this->dispatchBrowserEvent('hide-modal');
        }catch(\Exception $e){
            session()->flash('error', 'Something went wrong!!');
        }

    }

    public function editState($id){
    
        $this->editID = $id;
        $decrypted_id = Crypt::decrypt($id);

        $medicine = Medicine::where('id', $decrypted_id)->first();

        $this->general_description = $medicine->general_description;
        $this->unit_of_measure = $medicine->unit_of_measure;
        $this->how_to_use = $medicine->how_to_use;
        $this->warning = $medicine->warning;
        $this->side_effect = $medicine->side_effect;
        $this->direction = $medicine->direction;
        
    }

    public function cancelEdit(){

        $this->resetFields();
    }

    public function changeQuantity(){
      return  $this->isAdd == true ? $this->isAdd = false:$this->isAdd = true;
    }

    public function saveQuantity(){
        $this->validate([
            'quantity' => 'required'
        ]);
        
        $decrypted_id = Crypt::decrypt($this->editID);
        $medicine = Medicine::where('id', $decrypted_id)->first(['quantity', 'general_description']);

        try{
            switch ($this->isAdd){
                case true:
                        $medicine->quantity += $this->quantity;

                        $log_values = [
                            'activity' => 'Added a quantity to '.$medicine->general_description,
                            'log_time' => Carbon::now('Asia/Manila')
                        ];
            
                        Log::create($log_values);

                        Medicine::where('id', $decrypted_id)->update(['quantity' => $medicine->quantity]);
                        Activity::create(['medicine_id' => $decrypted_id, 'quantity' => $this->quantity, 'log_time' => Carbon::now('Asia/Manila'), 'type' => 1, 'general_description' => $medicine->general_description]);
                        session()->flash('success', 'Quantity Added!');
                        $this->dispatchBrowserEvent('hide-modal');
                        $this->resetFields();
                    break;
            
                case false:
                    if($medicine->quantity >= $this->quantity){
                        $medicine->quantity -= $this->quantity;

                        $log_values = [
                            'activity' => 'Deducted a quantity from '.$medicine->general_description,
                            'log_time' => Carbon::now('Asia/Manila')
                        ];
            
                        Log::create($log_values);

                        Medicine::where('id', $decrypted_id)->update(['quantity' => $medicine->quantity]);
                        Activity::create(['medicine_id' => $decrypted_id, 'quantity' => $this->quantity, 'log_time' => Carbon::now('Asia/Manila'), 'type' => 0, 'general_description' => $medicine->general_description]);
                        session()->flash('success', 'Quantity Deducted!');
                        $this->dispatchBrowserEvent('hide-modal');
                        $this->resetFields();
                    }else{
                        session()->flash('unable', 'Unable to minus quantity');
                    }
                    break;
            }
        }catch(\Exception $e){
            session()->flash('error', 'Something went wrong!');
        }
    }

    public function getRowId($id){
        $this->editID = $id;
        $decrypted_id = Crypt::decrypt($this->editID);

        $medicine = Medicine::where('id', $decrypted_id)->first(['quantity']);
    
        $this->total = $medicine->quantity;
    }

    public function clickAddUnit(){
        return $this->isAddUnit == false ? $this->isAddUnit = true: $this->isAddUnit = false;
    }

    public function addUnit(){
        $this->validate([ 'new_unit' => 'required|unique:units,unit_of_measurement,'.$this->new_unit ]);

        try{
            Unit::create(['unit_of_measurement' => strtolower($this->new_unit)]);
            $this->new_unit = '';
            session()->flash('added_unit', 'New Unit of Measurement Added!');
        }catch(\Exception $e){
            session()->flash('error', 'Something went wrong!');
        }
    }

    public function deleteUnit($id){

        $decrypted_id = Crypt::decrypt($id);
        
        try{
            Unit::where('id', $decrypted_id)->delete();
        }catch(\Exception $e){
            session()->flash('error', 'Something went wrong!!');
        }
    }
}
