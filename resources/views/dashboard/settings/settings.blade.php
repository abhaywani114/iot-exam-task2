@extends('dashboard.layout')
@section('title', 'Settings')
@section('content')
<main class="main-content  mt-0 mb-5">
    <div class="container-fluid px-2 px-md-4">
        <div class="page-header min-height-300 border-radius-xl mt-4"
            style="background-image: url('{{asset('img/setting-header.jpg')}}');">
        </div>
        <div class="card card-body mx-3 mx-md-4 mt-n6">
            <div class="row gx-4 mb-2">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="{{Auth::user()->image ?? asset('img/user.png')}}" alt="profile_image"
                            class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                          {{Auth::user()->first_name}} {{Auth::user()->last_name}}
                        </h5>
                        <p class="mb-0 font-weight-normal text-sm">
                          {{Auth::user()->email}}
                        </p>
                    </div>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin:3px;">
                        @foreach ($errors->all() as $error)
                            <li style="margin: 5px;" class="text-white">{!! $error !!}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form  class="text-start"  method="POST" action="{{route('usermanagement.settings.handle')}}" enctype="multipart/form-data">
            <div class="row">
                <div class="row">
                    <div class="col-12 col-xl-6">
                        <div class="card card-plain h-100">
                            <div class="card-header pb-0 p-3">
                                <h6 class="mb-0">Change Information</h6>
                            </div>
                            <div class="card-body p-3">
                            <div class="input-group input-group-outline mb-3">
                              <input type="text" class="form-control" placeholder="First name"  name="first_name" value="{{Auth::user()->first_name}}" >
                            </div>
                            <div class="input-group input-group-outline mb-3">
                              <input type="text" class="form-control" placeholder="Last name"  name="last_name" value="{{Auth::user()->last_name}}" >
                            </div>
                            <div class="input-group input-group-outline mb-3">
                              <input type="text" class="form-control" placeholder="Agent name"  name="agentname" value="{{Auth::user()->agentname}}" >
                            </div>
                            <div class="input-group input-group-outline mb-3">
                              <input type="email" class="form-control" placeholder="Email address"  name="email" value="{{Auth::user()->email}}" >
                            </div>
                            <div class="input-group input-group-outline mb-3">
                              <input type="text" class="form-control" placeholder="Business address"  name=" business_address" value="{{Auth::user()->business_address}}" >
                            </div>
                            <div class="input-group input-group-outline mb-3">
                              <input type="text" class="form-control" placeholder="Phone"  name="phone" value="{{Auth::user()->phone}}" >
                            </div>
                            <div class="input-group input-group-outline mb-3">
                              <label class="d-flex w-100"> Profile Image</label>
                              <input type="file"  name="image" />
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="card card-plain h-100">
                            <div class="card-header pb-0 p-3">
                                <div class="row">
                                    <div class="col-md-8 d-flex align-items-center">
                                        <h6 class="mb-0">Change Password</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3">
                            <div class="input-group input-group-outline mb-3">
                              <label class="form-label">Old Password</label>
                              <input type="password" class="form-control"  name="oldpassword" autocomplete="off" >
                            </div>
                            <div class="input-group input-group-outline mb-3">
                              <label class="form-label">Password</label>
                              <input type="password" class="form-control"  name="password" autocomplete="off" >
                            </div>
                            <div class="input-group input-group-outline mb-3">
                              <label class="form-label">Confirm Password</label>
                              <input type="password" class="form-control"  name="confirmation_password" autocomplete="off" >
                            </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="text-right">
              @csrf
              <button class="btn bg-gradient-info w-25  mb-2">Update</button>
            </div>
            </form>
        </div>
    </div>
</main>
@endsection
