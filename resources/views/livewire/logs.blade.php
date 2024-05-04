<div>
    <main>
        <div class="page-header">
            <h1>Logs</h1>
            <small>In / Out</small>
        </div>
        
        <div class="page-content">

            <div class="records table-responsive">

                <div class="record-header">
                    <div class="add">
                        <span class="me-1">Logs</span>
                    </div>

                    <div class="browse">
                       <input type="search" wire:model.live="search_input" placeholder="Search" class="record-search" style="width: 25rem">
                    </div>
                </div>

                <div>
                    <table width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><span class="las la-sort"></span> Activity</th>
                                <th><span class="las la-sort"></span> LOG TIME</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($logs) > 0)
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($logs as $log)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$log->activity}}</td>
                                    <td>{{Carbon\Carbon::parse($log->log_time)->format('d F Y g:i a')}}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center" colspan="4">No Logs Yet!</td>
                                </tr>
                            @endif
                            
                        </tbody>
                    </table>
                    
                </div>
                <div class="d-flex justify-content-end m-2">
                    {{$logs->links() }}
                </div>
            </div>
        
        </div>

        @include('credit')
        
    </main>


</div>