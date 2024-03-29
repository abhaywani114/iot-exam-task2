@extends('dashboard.layout')

@section('title', 'Login')

@section('content')
  <main class="main-content  mt-10">
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-info shadow-info border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Sign in - Verify OTP</h4>
                </div>
              </div>
              <div class="card-body">
                      @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin:3px;">
                            @foreach ($errors->all() as $error)
                                <li style="margin: 5px;" class="text-white">{!! $error !!}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form  class="text-start"  method="POST" action="{{route('login.verify-otp')}}">
                  <div class="input-group input-group-outline my-3">
                    <input type="email" class="form-control" name="email" placeholder="Email" value="{{ $email }}" readonly disabled >
                  </div>
                  <div class="input-group input-group-outline mb-3">
                    <input type="password" class="form-control"  name="otp" placeholder="OTP" >
                  </div>
                  <div class="text-center">
                    @csrf
                    <button class="btn bg-gradient-info w-100 my-4 mb-2">Verify OTP</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
@section('js')

@endsection
