@extends('layouts.app-logo')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('adminroute') }}{{ (request()->input('back') ? '?back=' . request()->input('back') : '') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="email">E-Mail Address</label>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}"  autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                              <label for="password">Password</label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" >

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                          <button type="submit" class="btn btn-primary btn-lg">
                            Log In
                          </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Copyright (c) hardiksolanki 2020. All Rights Reserved. -->
        </div>
    </div>
</div>
@endsection
