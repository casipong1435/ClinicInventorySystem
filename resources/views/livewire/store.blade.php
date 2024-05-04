<div>
    <main>
        <div class="page-header">
            <h1>Activity</h1>
            <small>In / Out</small>
        </div>
        
        <div class="page-content">

            <div class="records table-responsive">

                <div class="record-header">
                    <div class="add">
                        <span class="me-1">History</span>
                        <button type="button" class="text-danger border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#reportBtn"><i class="las la-file fs-1"></i></button>
                    </div>

                    <div class="browse">
                        <label for="type" class="me-2">Transaction Type: </label>
                        <select wire:model.change="type" class="p-2" id="type">
                            <option value="0,1">All</option>
                            <option value="0">Released</option>
                            <option value="1">Added</option>
                        </select>
                       <input type="search" wire:model.live="search_input" placeholder="Search" class="record-search" style="width: 25rem">
                    </div>
                </div>

                <div>
                    <table width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><span class="las la-sort"></span> ITEM NAME</th>
                                <th><span class="las la-sort"></span> TRANSACTION LOG</th>
                                <th><span class="las la-sort"></span> QUANTITY</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($transactions) > 0)
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($transactions as $transaction)
                                <tr class="{{$transaction->type == 1 ? 'plus':'minus'}}">
                                    <td>{{$i++}}</td>
                                    <td>{{$transaction->general_description}}</td>
                                    <td>{{Carbon\Carbon::parse($transaction->log_time)->format('d F Y g:i a')}}</td>
                                    <td>{{$transaction->type == 0 ? '- '.$transaction->quantity:'+ '.$transaction->quantity}}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center" colspan="4">No Activity Yet!</td>
                                </tr>
                            @endif
                            
                        </tbody>
                    </table>
                    
                </div>
                <div class="d-flex justify-content-end m-2">
                    {{$transactions->links() }}
                </div>
            </div>
        
        </div>

        @include('credit')
        
    </main>

    <div wire:ignore.self class="modal fade" id="reportBtn" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="h3 border-bottom mb-2">Generate Report</div>
                    <div class="form-group mb-2">
                        <label for="from" class="mb-1">Date From:</label>
                        <input type="date" class="w-100 p-2" id="from" wire:model="date_from">
                        @error('date_from')
                            <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="to" class="mb-1">Date To:</label>
                        <input type="date" class="w-100 p-2" id="to" wire:model="date_to">
                        @error('date_to')
                            <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>

                    @if (session()->has('found'))
                    <div class="col-md-12 mb-2">
                        <div class="alert alert-success p-3 alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                            <div><strong>Found! </strong>{{session()->get('found')}}</div>
                            <a href="{{ route('report', ['date_from' => Crypt::encrypt($date_from), 'date_to' => Crypt::encrypt($date_to)]) }}" target="_blank" class="text-decoration none text-danger fw-bold"><i class="las la-print fs-1"></i></a>
                        </div>
                    </div>
                    @endif

                    @if (session()->has('not_found'))
                    <div class="col-md-12 mb-2">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Found!</strong> {{session()->get('not_found')}}
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mx-1 shadow-sm rounded-0 close-modal" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger mx-1 shadow-sm rounded-0" wire:loading.remove wire:click="generateReport">Generate</button>
                    <button type="button" class="btn btn-danger mx-1 shadow-sm rounded-0" wire:loading wire:target="generateReport" wire:loading.attr="disabled" wire:click="generateReport">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        Generating
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>