<div>
    
    <main>
        <div class="page-header">
            <h1>Account</h1>
            <small>Password Management</small>
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


            <div class="col-md-12">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-md-3  p-2">
                        <div class="container  d-flex justify-content-center flex-column align-items-center shadow rounded">
                            <div class="form-group text-center m-2 border-bottom py-2">
                               <h3>Change Password</h3>
                            </div>
                            <form wire:submit.prevent="changePassword">
                                @csrf
                                <div class="form-group mb-2">
                                    <label for="new-password" class="mb-1">New Password</label>
                                    <input type="password" class="p-2 w-100" wire:model="new_password" id="new_password">
                                </div>
                                @error('new_password')
                                    <div class="text-danger">{{$message}}</div>
                                @enderror
                                <div class="form-group mb-2">
                                    <label for="confirm-password" class="mb-1">Confirm Password</label>
                                    <input type="password" class="p-2 w-100" wire:model="confirm_password" id="confirm_password">
                                </div>
                                @error('confirm_password')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                                <div class="form-group mb-2 d-flex align-items-center">
                                    <input type="checkbox" class="me-2" id="password-checkbox">
                                    <label for="password-checkbox" id="show-checkbox">Show Password</label>
                                </div>
                                <div class="form-group mb-2 w-100">
                                    <button type="submit" class="btn btn-primary w-100">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
        
        </div>

        @include('credit')
        
    </main>

    <script>
        $(document).ready(function(){
            
            $('#password-checkbox').on('click',function(){

                if ($('#password-checkbox').is(':checked')){
                    $('#new_password').attr('type', 'text');
                    $('#confirm_password').attr('type', 'text');
                    
                }else{
                    $('#new_password').attr('type', 'password');
                    $('#confirm_password').attr('type', 'password');
                    
                }
            });
        });
    </script>

</div>