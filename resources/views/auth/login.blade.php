@extends('layouts.app')

@section('page-title', 'Login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 mt-4">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-12 ">
                                <div class="d-flex flex-row">
                                    <div class="fs-2 me-2">
                                        <i class="las la-user"></i>
                                    </div>
                                    <input id="username" type="text" class="form-control shadow-sm bg-light @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Username" required autocomplete="username" autofocus>
                                    @error('username')
                                        <span role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="d-flex flex-row">
                                    <div class="me-2 fs-2">
                                        <i class="las la-lock"></i>
                                    </div>
                                    <div class="position-relative w-100">
                                        <input id="password" type="password" class="p-2 form-control shadow-sm bg-light @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
                                        <label for="check-eye" id="show-password" class="position-absolute fs-5" style="top: 6px; right: 10px; cursor: pointer"><i class="las la-eye-slash"></i></label>
                                        <input type="checkbox" id="check-eye" class="d-none">
                                    </div>
                                    @error('password')
                                        <span role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary w-100">
                                    {{ __('Login') }}
                                </button>

                                @if (session('error'))
                                    <div class="w-100 mt-2 text-danger alert alert-danger" role="alert">
                                        <strong>Error!</strong>
                                        <span>{{ session('error') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        let password = $('#password').attr('type');
        let label_eye = $('#show-password i').attr('class');

        $('#show-password').on('click',function(){

            if ($('#check-eye').is(':checked')){
                $('#password').attr('type', 'text');
                $('#show-password i').attr('class', 'las la-eye');
            }else{
                $('#password').attr('type', 'password');
                $('#show-password i').attr('class', 'las la-eye-slash');
            }
        });
    });
</script>
@endsection
