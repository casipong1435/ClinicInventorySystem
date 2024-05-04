<div>
    <main>
        <div class="page-header">
            <h1>Inventory</h1>
            <small>Home / Inventory</small>
        </div>
        
        <div class="page-content">
            @if (session()->has('success'))
            <div class="col-md-12 mb-2">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{session()->get('success')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            @endif
            
            <div class="records table-responsive">

                <div class="record-header">
                    <div class="add">
                        <span>Entries</span>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addMedicine">Add record</button>
                    </div>

                    <div class="browse">
                        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addUnit">Units</button>
                       <input type="search" wire:model.live="search_input" placeholder="Search" class="record-search" style="width: 25rem">
                    </div>
                </div>

                <div>
                    <table width="100%">
                        <thead>
                            <tr>
                                <th>ITEM #</th>
                                <th><span class="las la-sort"></span> GENERAL DESCRIPTION</th>
                                <th><span class="las la-sort"></span> QUANTITY</th>
                                <th><span class="las la-sort"></span> UNIT OF MEASURE</th>
                                <th><span class="las la-sort"></span> STATUS</th>
                                <th><span class="las la-sort"></span> ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp

                            @if (count($medicines) > 0)
                                @foreach ($medicines as $medicine)
                                    <tr data-bs-toggle="modal" data-bs-target="#changeQuantity" class="row-data" wire:click.prevent="getRowId('{{Crypt::encrypt($medicine->id)}}')">
                                        <td>{{ $i++ }}</td>
                                        <td>{{$medicine->general_description}}</td>
                                        <td>{{$medicine->quantity}}</td>
                                        <td>{{$medicine->unit_of_measurement}}</td>
                                        <td>
                                            <span class="p-2 opacity-80 text-white {{ $medicine->quantity != 0 ? 'in-stock': 'out-of-stock'}}">{{ $medicine->quantity != 0 ? 'In Stock': 'Out of Stock'}}</span>
                                        </td>
                                        <td>
                                            <div class="actions">
                                                <button type="button" class="bg-transparent border-0 mx-1" data-bs-toggle="modal" data-bs-target="#editMedicine" wire:click.prevent="editState('{{Crypt::encrypt($medicine->id)}}')"><i class="las la-edit fs-2 text-warning"></i></button>
                                                <button type="button" class="bg-transparent border-0 mx-1" data-bs-toggle="modal" data-bs-target="#deleteModal" wire:click.prevent="getDeleteID('{{Crypt::encrypt($medicine->id)}}')"><i class="las la-trash fs-2 text-danger"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">No Items Added Yet!</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        
        </div>

        @include('credit')
        
    </main>

    <!-- Add Medicine Modal -->
    <div wire:ignore.self class="modal fade" id="addMedicine" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Item</h1>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit.prevent="addMedicine">
                <div class="modal-body">
                    <div class="row mb-2 d-flex justify-content-center">
                        @if (session()->has('added'))
                        <div class="col-md-12 mb-2">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{session()->get('added')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                        @endif
                        @if (session()->has('error'))
                        <div class="col-md-12 mb-2">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{session()->get('error')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                        @endif
                
                        <div class="col-md-12 p-3">
                            <div class="form-group mb-2">
                                <input type="text" wire:model="general_description" id="general_description" class="p-2 w-100">
                                <label for="general_description">General Description</label>
                                @error('general_description')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <select id="unit_of_measure" wire:model="unit_of_measure" class="p-2 w-100">
                                    @if (count($units) > 0)
                                        <option disabled value="">Select</option>
                                        @foreach ($units as $unit)
                                            <option value="{{$unit->id}}">{{$unit->unit_of_measurement}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="unit_of_measure">Unit of Measure</label>
                                @error('unit_of_measure')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mx-1 shadow-sm rounded-0 close-modal" data-bs-dismiss="modal" wire:click.prevent="cancelEdit">Close</button>
                    <button type="submit" class="btn mx-1 text-white shadow-sm rounded-0" style="background: #fc4e4e" wire:loading.remove wire:target="addMedicine">Add</button>
                    <button type="button" class="btn mx-1 text-white shadow-sm rounded-0" style="background: #fc4e4e" wire:loading wire:target="addMedicine" wire:loading.attr="disabled">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        Adding
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Medicine -->
    <div wire:ignore.self class="modal fade" id="editMedicine" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Item</h1>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit.prevent="editMedicine">
                <div class="modal-body">
                    <div class="row mb-2 d-flex justify-content-center">
                        @if (session()->has('success'))
                        <div class="col-md-12 mb-2">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{session()->get('success')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                        @endif
                        @if (session()->has('error'))
                        <div class="col-md-12 mb-2">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{session()->get('error')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                        @endif
                
                        <div class="col-md-12 p-3">
                            <div class="form-group mb-2">
                                <input type="text" wire:model="general_description" id="general_description" class="p-2 w-100" required>
                                <label for="general_description">General Description</label>
                                @error('general_description')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <select id="unit_of_measure" wire:model="unit_of_measure" class="p-2 w-100" required>
                                    @if (count($units) > 0)
                                        <option disabled value="">Select</option>
                                        @foreach ($units as $unit)
                                            <option value="{{$unit->id}}">{{$unit->unit_of_measurement}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="unit_of_measure">Unit of Measure</label>
                                @error('unit_of_measure')
                                <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <hr>
                            <div class="form-group mb-2">
                                <label for="how_to_use">Uses</label>
                                <textarea type="text" wire:model="how_to_use" id="how_to_use" class="p-2 w-100"></textarea>
                            </div>
                            <div class="form-group mb-2">
                                <label for="warning">Warnings</label>
                                <textarea type="text" wire:model="warning" id="warning" class="p-2 w-100"></textarea>
                            </div>
                            <div class="form-group mb-2">
                                <label for="side_effect">Side Effects </label>
                                <textarea type="text" wire:model="side_effect" id="side_effect" class="p-2 w-100"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="direction">Directions </label>
                                <textarea type="text" wire:model="direction" id="direction" class="p-2 w-100"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mx-1 shadow-sm rounded-0 close-modal" data-bs-dismiss="modal" wire:click.prevent="cancelEdit">Close</button>
                    <button type="submit" class="btn mx-1 text-white shadow-sm rounded-0" wire:loading.remove wire:target="editMedicine" style="background: #fc4e4e">Save</button>
                    <button type="submit" class="btn mx-1 text-white shadow-sm rounded-0" wire:loading wire:target="editMedicine" wire:loading.attr="disabled" style="background: #fc4e4e">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        Saving
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>



    <!--Add Quantity Modal -->
    <div wire:ignore.self class="modal fade" id="changeQuantity" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{$isAdd ? 'Add Quantity':'Minus Quantity'}}</h1>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit.prevent="saveQuantity">
                <div class="modal-body">
                    <div class="row mb-2 d-flex justify-content-center">

                        @if (session()->has('error'))
                        <div class="col-md-12 mb-2">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{session()->get('error')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                        @endif
            
                        <div class="col-md-12 p-3">
                            <div class="form-group mb-3 d-flex justify-content-end px-3">
                                <button type="button" class="btn mx-1 {{!$isAdd ? 'btn-primary':'disabled'}}" wire:click.prevent="changeQuantity">+ Add</button>
                                <button type="button" class="btn mx-1 {{$isAdd ? 'btn-primary':'disabled'}}" wire:click.prevent="changeQuantity">- Minus</button>
                            </div>
                            <div class="form-group px-3">
                                <input type="number" wire:model="quantity" id="quantity" min="1" {{!$isAdd ? "max=$total":''}} class="p-2 w-100" {{!$isAdd ? $total <= 0 ? 'disabled':'':''}}>
                                <label for="quantity">Quantity (Onhand = {{$total}})</label>
                                @error('quantity')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                                @if (session()->has('unable'))
                                    <div class="text-danger mt-1">Unable to minus the quantity!</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mx-1 shadow-sm rounded-0 close-modal" data-bs-dismiss="modal" wire:click.prevent="resetFields">Close</button>
                    <button type="submit" class="btn mx-1 text-white shadow-sm rounded-0" wire:loading.remove wire:target="saveQuantity" style="background: #fc4e4e">Save</button>
                    <button type="submit" class="btn mx-1 text-white shadow-sm rounded-0" wire:loading wire:target="saveQuantity" wire:loading.attr="disabled" style="background: #fc4e4e">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        Saving
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!--Add Unit of Measure Modal -->
    <div wire:ignore.self class="modal fade" id="addUnit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Unit of Measurement</h1>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit.prevent="addUnit">
                <div class="modal-body">
                    <div class="row mb-2 d-flex justify-content-center">

                        @if (session()->has('added_unit'))
                        <div class="col-md-12 mb-1">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{session()->get('added_unit')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                        @endif

                        @if (session()->has('error'))
                        <div class="col-md-12 mb-1">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{session()->get('error')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                        @endif
            
                        <div class="col-md-12 py-1 px-3">
                            @if (count($units) > 0)
                                @foreach ($units as $unit)
                                <div class="d-flex justify-content-between border p-1 mb-1">
                                    <li class="p-1">{{$unit->unit_of_measurement}}</li>
                                    <button type="button" class="bg-transparent border-0 mx-1" wire:click.prevent="deleteUnit('{{Crypt::encrypt($unit->id)}}')"><i class="las la-trash fs-2 text-danger"></i></button>
                                </div>
                                @endforeach
                            @else
                                <div class="mb-1">No unit added yet!</div>
                            @endif
                            <div class="form-group mb-2 d-flex">
                                <button type="button" class="btn bg-transparent fw-bold border me-2" wire:loading.attr="disabled" wire:click.prevent="clickAddUnit">+</button>
                                <input type="text" wire:model="new_unit" class="w-100 p-2  {{$isAddUnit == false ? 'd-none':''}}">
                                
                                <div wire:loading wire:target="clickAddUnit" class="text-center w-100">
                                    <div class="spinner-border" role="status">
                                      <span class="visually-hidden">Loading...</span>
                                    </div>
                                  </div>
                            </div>
                            @error('new_unit')
                                <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mx-1 shadow-sm rounded-0 close-modal" data-bs-dismiss="modal" wire:click.prevent="resetFields">Close</button>
                    <button type="submit" class="btn mx-1 text-white shadow-sm rounded-0 {{$isAddUnit == false ? 'd-none':''}}" wire:loading.remove wire:target="addUnit" style="background: #82c779">Add Unit</button>
                    <button type="button" class="btn mx-1 text-white shadow-sm rounded-0" style="background: #82c779" wire:loading wire:target="addUnit" wire:loading.attr="disabled">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        Adding
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-center flex-column p-2 text-center">
                        <div style="font-size: 5rem; font-weight:bold">
                            <i class="las la-exclamation-circle text-danger"></i>
                        </div>
                        <div class="fs-4">Are you sure you want to delete this item?</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mx-1 shadow-sm rounded-0 close-modal" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger mx-1 shadow-sm rounded-0" wire:click.prevent="deleteMedicine">Confirm</button>
                    <button type="button" class="btn btn-danger mx-1 shadow-sm rounded-0" wire:loading wire:target="deleteMedicine" wire:loading.attr="disabled"></button>
                </div>
            </div>
        </div>
    </div>

    

    <script>
        window.addEventListener('hide-modal', function(){
            $('button.close-modal').click();
        });
    </script>

</div>