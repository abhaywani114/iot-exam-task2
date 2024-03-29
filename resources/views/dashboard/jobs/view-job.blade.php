@extends('dashboard.layout')
@section('title', 'Job Information')
@section('content')
<style>
    .input-group.input-group-outline.is-focused .form-label+.form-control, .input-group.input-group-outline.is-filled .form-label+.form-control {
        border-color: #eee !important;
        border-top-color: transparent !important;
        box-shadow: inset 1px 0 #eee, inset -1px 0 #eee, inset 0 -1px #eee, inset -1px 0 #eee;
    }
        
    .input-group.input-group-outline.is-focused .form-label:before,
        .input-group.input-group-outline.is-focused .form-label:after,
        .input-group.input-group-outline.is-filled .form-label:before,
        .input-group.input-group-outline.is-filled .form-label:after {
            border-top-color: #eee;
            box-shadow: inset 0 1px #eee;
        }
        .input-group.input-group-dynamic .form-control[disabled], .input-group.input-group-static .form-control[disabled] {
            background-image: linear-gradient(0deg, #1A73E8 2px, rgba(156, 39, 176, 0) 0), linear-gradient(0deg, #d2d2d2 1px, rgba(209, 209, 209, 0) 0) !important;
        }
        .input-group.input-group-outline.is-focused .form-label, .input-group.input-group-outline.is-filled .form-label {
            color: #7b809a;
            font-weight: 600;
        }
</style>
<div class="container-fluid py-4">
@if($errors->any() || session('success'))
    <div class="col-md-12 mt-0 h-100w mb-5">
        <div class="">
            <div class="card mb-4 px-3">
                @if($errors->any())
                    <div class="alert alert-danger my-3">
                        <ul style="margin:3px;">
                            @foreach($errors->all() as $error)
                                <li style="margin: 5px;" class="text-white">{!! $error !!}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success text-white my-3">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif
    @if(Auth::user()->type == 'admin')
    <div class="row">
        <div class="col-4">
            <div class="card mb-2 mt-2 mb-3">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Status</h6>
                    </div>
                </div>
                <div class="card-body p-3 pt-0">
                    <p class="text-sm mb-0 pt-4">
                        <i class="fa fa-balance-scale text-info" aria-hidden="true"></i> Status:
                        <strong>{{ ucfirst($job->status) }}</strong>
                        @if($job->clerk_id)
                            | <i class="fa fa-user text-info" aria-hidden="true"></i> Assigned Clerk: <span
                                class="font-weight-bold">{{ $job->clerk->first_name }}
                                {{ $job->clerk->last_name }},
                                <small>{{ $job->clerk->email }}</small></span>
                        @endif
                    </p>
                    <form method="POST" action="{{ route('dashboard.job-update') }}"
                        enctype="multipart/form-data">
                        @if(Auth::user()->type == 'admin')
                            <div class="input-group input-group-outline focused is-focused my-3">
                                <select id="clerk" name="clerk_id" class="form-control">
                                    <option value="">Select Clerk</option>
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}"
                                            {{ $u->id == $job->clerk_id ? 'selected':'' }}>
                                            {{ $u->first_name }} {{ $u->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-group input-group-outline focused is-focused my-3">
                                <select id="status" name="status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="pending"
                                        {{ $job->status == 'pending' ? 'selected':'' }}>
                                        Pending</option>
                                    <option value="processing"
                                        {{ $job->status == 'processing' ? 'selected':'' }}>
                                        Processing</option>
                                    <option value="scheduled"
                                        {{ $job->status == 'scheduled' ? 'selected':'' }}>
                                        Scheduled</option>
                                    <option value="complete"
                                        {{ $job->status == 'complete' ? 'selected':'' }}>
                                        Complete</option>
                                    <option value="on-hold"
                                        {{ $job->status == 'on-hold' ? 'selected':'' }}>
                                        On Hold</option>
                                    <option value="cancelled"
                                        {{ $job->status == 'Cancelled' ? 'selected':'' }}>
                                        Cancelled</option>
                                </select>
                            </div>
                        @endif
                        @csrf
                        <input type="hidden" name="job_id" value="{{ $job->id }}" />
                        <button type="submit" class="btn bg-gradient-info ">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-4"> 
            <div class="card mb-2 mt-2 mb-3" style="height: calc(100% -  1.5rem);">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Appoinment Date Update</h6>
                    </div>
                </div>
                <div class="card-body p-3 pt-0">
                    <br/>
                    <form method="POST" action="{{ route('dashboard.job-update') }}"
                        enctype="multipart/form-data">
                        <div class="input-group input-group-static mb-4">
                                <label for="propertytype_select" class="ms-0">Appoinment Date</label>
                                <input type="date" name="appointment_date" class="form-control " value="{{ $job->appointment_date }}" >
                            </div>
                        @csrf
                        <input type="hidden" name="job_id" value="{{ $job->id }}" />
                        <button type="submit" class="btn bg-gradient-info ">Update Date</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-4"> 
            <div class="card mb-2 mt-2 mb-3" style="height: calc(100% -  1.5rem);">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Upload Report</h6>
                    </div>
                </div>
                <div class="card-body p-3 pt-0">
                    <br/>
                    <form method="POST" action="{{ route('dashboard.job-update') }}"
                        enctype="multipart/form-data">
                        <div class="col-md-6 py-4" style="align-items: center;display: flex;">
                            <input type="file" id="file" name="file">
                        </div>
                        @csrf
                        <input type="hidden" name="job_id" value="{{ $job->id }}" />
                        <button type="submit" class="btn bg-gradient-info ">Upload Report</button>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <div class="col-md-12 mt-0 h-100w mb-3">
        <div class="">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Jobs Information - {{ $job->job_type }}</h6>
                    </div>
                </div>
                <div class="card-body pt-4 p-3">
                    <ul class="list-group">
                        <li class="list-group-item border-0  p-4 mb-2 bg-gray-100 border-radius-lg">
                            <div class="d-flex flex-column">
                        <div>
                            <h4 class="lead mt-3">Please provide your information</h4>
                            <div class="input-group input-group-sm input-group-outline focused is-focused my-3">
                                <input type="text" name="agentname" class="form-control"
                                    placeholder="Agent/Business Name" value="{{ $job->user->agentname }}"
                                    readonly>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm input-group-outline focused is-focused mb-3 mt-2">
                                        <input type="text" name="firstname" class="form-control"
                                            placeholder="First Name" value="{{ $job->user->first_name }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm input-group-outline focused is-focused mb-3 mt-2">
                                        <input type="text" name="lastname" class="form-control" placeholder="Last Name"
                                            value="{{ $job->user->last_name }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm input-group-outline focused is-focused mb-3 mt-2">
                                        <input type="email" name="agentemail" class="form-control "
                                            placeholder="Your Email" value="{{ $job->user->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm input-group-outline focused is-focused mb-3 mt-2">
                                        <input type="text" name="telephone" class="form-control" placeholder="Telephone"
                                            value="{{ $job->user->phone }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($job->job_type!= 'Fire Safety Asset Check/Block Inspection')
                        <div>
                            <h4 class="lead mt-3">Please provide property details</h4>
                            <div class="input-group input-group-static mb-4">
                                <label for="propertytype_select" class="ms-0">Type of property?</label>
                                <select class="form-control" name="propertytype" id="propertytype_select" disabled>
                                    <option value="">{{$job->metaBySlug('propertytype')->value ?? ''}}</option>
                                </select>
                            </div>
                            @if($job->job_type!= 'LPA- Visit/Lock Change Notice/Occupancy Check')
                            <div class="input-group input-group-static mb-4">
                                <label for="propertysize_select" class="ms-0">How many bedrooms?</label>
                                <select class="form-control" name="propertysize" id="propertysize_select" disabled>
                                    <option value="">{{$job->metaBySlug('propertysize')->value ?? ''}}</option>
                                </select>
                            </div>
                            <div class="input-group input-group-static mb-4">
                                <label for="propertyfurnishing_select" class="ms-0">Furnished or unfurnished?</label>
                                <select class="form-control" name="propertyfurnishing" id="propertyfurnishing_select"
                                    disabled>
                                    <option value="">{{$job->metaBySlug('propertyfurnishing')->value ?? ''}}</option>
                                </select>
                            </div>
                            @endif
                            @if($job->job_type== '360 Virtual Tour') 
                            <div class="input-group input-group-static mb-4">
                                <label for="propertyfurnishing_select" class="ms-0">Is the property empty?</label>
                                <select class="form-control" name="is_property_empty" 
                                    disabled>
                                    <option value="">{{$job->metaBySlug('is_property_empty')->value ?? ''}}</option>
                                </select>
                            </div>
                            @endif
                            <div class="input-group input-group-static mb-1">
                                <label class="ms-0">Address</label>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label>Street Name and House Number</label>
                                        <input type="text" name="firstline" class="form-control" value="{{$job->metaBySlug('firstline')->value ?? ''}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                       <label>Area</label>
                                        <input type="text" name="area" class="form-control"  value="{{$job->metaBySlug('area')->value ?? ''}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                       <label>Town or City</label>
                                        <input type="text" name="towncity" class="form-control" value="{{$job->metaBySlug('towncity')->value ?? ''}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                       <label>Post Code</label>
                                        <input type="text" name="postcode" class="form-control zip" value="{{$job->metaBySlug('postcode')->value ?? ''}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($job->job_type!= '30 minute viewing' && $job->job_type!= 'Fire Safety Asset Check/Block Inspection' && $job->job_type!= 'Abandonment Notice' && $job->job_type!= 'LPA- Visit/Lock Change Notice/Occupancy Check')
                        <div>
                        <h4 class="lead mt-3">Please provide the tenants details @if($job->job_type!='360 Virtual Tour') if required @endif</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-1 ">
                                        <label class="ms-0">Tenant 1</label>
                                    </div>
                                    <div class="input-group input-group-static mb-4">
                                       <label>Tenant One Name</label>
                                        <input type="text" name="tt1name" class="form-control" value="{{$job->metaBySlug('tt1name')->value ?? ''}}" readonly>
                                    </div>
                                    <div class="input-group input-group-static mb-4 mt-3">
                                       <label>Tenant One Phone Number</label>
                                        <input type="phone" name="tt1phone" class="form-control" value="{{$job->metaBySlug('tt1phone')->value ?? ''}}" readonly>
                                    </div>
                                    <div class="input-group input-group-static mb-4 mt-3">
                                       <label>Tenant One Email</label>
                                        <input type="email" name="tt1email" class="form-control" value="{{$job->metaBySlug('tt1email')->value ?? ''}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-1">
                                        <label class="ms-0">Tenant 2</label>
                                    </div>
                                    <div class="input-group input-group-static mb-4">
                                       <label>Tenant Two Name</label>
                                        <input type="text" name="tt2name" class="form-control" value="{{$job->metaBySlug('tt2name')->value ?? ''}}" readonly>
                                    </div>
                                    <div class="input-group input-group-static mb-4 mt-3 mt-3">
                                       <label>Tenant Two Phone Number</label>
                                        <input type="phone" name="tt2phone" class="form-control"  value="{{$job->metaBySlug('tt2phone')->value ?? ''}}" readonly>
                                    </div>
                                    <div class="input-group input-group-static mb-4 mt-3 mt-3">
                                       <label>Tenant Two Email</label>
                                        <input type="email" name="tt2email" class="form-control" value="{{$job->metaBySlug('tt2email')->value ?? ''}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($job->job_type== '30 minute viewing')
                        <div>
                        <h4 class="lead mt-3">Please provide the viewer details</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-1">
                                        <label class="ms-0">Viewer 1</label>
                                    </div>
                                    <div class="input-group input-group-static mb-4 mt-3">
                                       <label>Viewer One Name</label>
                                        <input type="text" name="vv1name" class="form-control" required  value="{{$job->metaBySlug('vv1name')->value ?? ''}}" readonly>
                                    </div>
                                    <div class="input-group input-group-static mb-4 mt-3 mt-3">
                                       <label>Viewer One Phone Number</label>
                                        <input type="phone" name="vv1phone" class="form-control" value="{{$job->metaBySlug('vv1phone')->value ?? ''}}" readonly>
                                    </div>
                                    <div class="input-group input-group-static mb-4 mt-3 mt-3">
                                       <label>Viewer One Email</label>
                                        <input type="email" name="vv1email" class="form-control" value="{{$job->metaBySlug('vv1email')->value ?? ''}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-1">
                                        <label class="ms-0">Viewer 2</label>
                                    </div>
                                    <div class="input-group input-group-static mb-4 mt-3 ">
                                       <label>Viewer Two Name</label>
                                        <input type="text" name="vv2name" class="form-control" value="{{$job->metaBySlug('vv2name')->value ?? ''}}" readonly>
                                    </div>
                                    <div class="input-group input-group-static mb-4 mt-3 mt-3">
                                       <label>Viewer Two Phone Number</label>
                                        <input type="text" name="vv2phone" class="form-control" value="{{$job->metaBySlug('vv2phone')->value ?? ''}}" readonly >
                                    </div>
                                    <div class="input-group input-group-static mb-4 mt-3 mt-3">
                                       <label>Viewer Two Email</label>
                                        <input type="email" name="vv2email" class="form-control" value="{{$job->metaBySlug('vv2email')->value ?? ''}}" readonly >
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($job->job_type== 'LPA- Visit/Lock Change Notice/Occupancy Check')
                        <div>
                        <h4 class="lead mt-3">Do you know the occupants details?</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-1">
                                        <label class="ms-0">Occupant 1</label>
                                    </div>
                                    <div class="input-group input-group-static mb-4 mt-3">
                                       <label>Occupant One Name</label>
                                        <input type="text" name="oo1name" class="form-control" value="{{$job->metaBySlug('oo1name')->value ?? ''}}" readonly>
                                    </div>
                                    <div class="input-group input-group-static mb-4 mt-3">
                                       <label>Occupant One Phone Number</label>
                                        <input type="phone" name="oo1phone" class="form-control" value="{{$job->metaBySlug('oo1phone')->value ?? ''}}" readonly>
                                    </div>
                                    <div class="input-group input-group-static mb-4 mt-3">
                                       <label>Occupant One Email</label>
                                        <input type="email" name="oo1email" class="form-control" value="{{$job->metaBySlug('oo1email')->value ?? ''}}" readonly>
                                    </div> 
                                </div> 
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-1">
                                        <label class="ms-0">Occupant 2</label>
                                    </div>
                                    <div class="input-group input-group-static mb-4 mt-3">
                                       <label>Occupant Two Name</label>
                                        <input type="text" name="oo2name" class="form-control" value="{{$job->metaBySlug('oo2name')->value ?? ''}}" readonly>
                                    </div>
                                    <div class="input-group input-group-static mb-4 mt-3">
                                       <label>Occupant Two Phone Number</label>
                                        <input type="phone" name="oo2phone" class="form-control"  value="{{$job->metaBySlug('oo2phone')->value ?? ''}}" readonly>
                                    </div>
                                    <div class="input-group input-group-static mb-4 mt-3">
                                       <label>Occupant Two Email</label>
                                        <input type="email" name="oo2email" class="form-control" value="{{$job->metaBySlug('oo2email')->value ?? ''}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ($job->job_type!= 'Mid-Term Property Visit' && $job->job_type!= 'Smoke and CO Inspection/Installation' && $job->job_type!= '30 minute viewing' && $job->job_type!='360 Virtual Tour' && $job->job_type!= 'Fire Safety Asset Check/Block Inspection' && $job->job_type!= 'Abandonment Notice' && $job->job_type!=  "LPA- Visit/Lock Change Notice/Occupancy Check" && $job->job_type!= 'Marketing Photography')
                            <div>
                                <h4 class="lead mt-3">Tenancy</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="tenancytype_select" class="ms-0">What type of tenancy is to be assigned?</label>
                                            <select class="form-control"  name="tenancytype" id="tenancytype_select" disabled>
                                                <option>{{$job->metaBySlug('tenancytype')->value ?? ''}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="managementcategory_select" class="ms-0">Management Category</label>
                                            <select class="form-control" name="managementcategory" id="managementcategory_select" disabled>
                                                <option>{{$job->metaBySlug('managementcategory')->value ?? ''}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    @if ($job->job_type!= 'Check Out')
                                    <div class="col-md-6">
                                       <div class="input-group input-group-static mb-4">
                                            <label for="tenancytype_select" class="ms-0">Is the tenant moving in the same day?</label>
                                            <select class="form-control"name="movingsameday" id="movingsameday_select" disabled>
                                                <option>{{$job->metaBySlug('movingsameday')->value ?? ''}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="tenancytype_select" class="ms-0">Tenancy start date</label>
                                            <input type="text" class="form-control" name="tend_datepicker" value="{{$job->metaBySlug('tend_datepicker')->value ?? ''}}" readonly>
                                        </div>
                                    </div>
                                    @if ($job->job_type== 'Check Out')
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="tenancytype_select" class="ms-0">Tenancy end date</label>
                                            <input type="text" class="form-control" name="tenancy_end_date" value="{{$job->metaBySlug('tenancy_end_date')->value ?? ''}}" readonly>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                        @if($job->job_type==  "LPA- Visit/Lock Change Notice/Occupancy Check")
                        <div>
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="tenancytype_select" class="ms-0">When did the tenancy start? (If known)</label>
                                    <input type="text" class="form-control" name="tend_datepicker"  value="{{$job->metaBySlug('tend_datepicker')->value ?? ''}}" readonly>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div>
                            <h4 class="lead mty-3">Further information</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="tenancytype_select" class="ms-0">When would you like the instruction to take place?</label>
                                        <input type="text" class="form-control" name="datepicker" value="{{$job->metaBySlug('datepicker')->value ?? ''}}" readonly>
                                    </div>
                                    @if ($job->job_type!= 'Mid-Term Property Visit' && $job->job_type!= 'Abandonment Notice' && $job->job_type!= 'Attend an Eviction')
                                    <div class="input-group input-group-static mb-4">
                                        <label for="tenancytype_select" class="ms-0">Key Return Location</label>
                                        <input type="text" name="keyreturn" class="form-control" value="{{$job->metaBySlug('keyreturn')->value ?? ''}}" readonly>
                                    </div>
                                    @endif
                                    @if ($job->job_type== 'Attend an Eviction')
                                    <div class="input-group input-group-static mb-4">
                                        <label for="tenancytype_select" class="ms-0">What would you like us to do with the keys (If applicable)? </label>
                                        <input type="text" name="do_keys" class="form-control" value="{{$job->metaBySlug('do_keys')->value ?? ''}}" readonly >
                                    </div>
                                    @endif
                                    @if ($job->job_type== 'Fire Safety Asset Check/Block Inspection')
                                    <div class="input-group input-group-static mb-4">
                                        <label for="tenancytype_select" class="ms-0">Which assets should we test and/or inspect?</label>
                                        <input type="text" name="test_inspect" class="form-control" value="{{$job->metaBySlug('test_inspect')->value ?? ''}}" readonly  >
                                    </div>
                                    @endif
                                </div>
                                @if ($job->job_type!= 'Mid-Term Property Visit' && $job->job_type!= 'Abandonment Notice' && $job->job_type!=  "LPA- Visit/Lock Change Notice/Occupancy Check" && $job->job_type!= 'Attend an Eviction')
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="tenancytype_select" class="ms-0">Please provide key collection arrangements.</label>
                                        <input type="text" name="keycollection" class="form-control" value="{{$job->metaBySlug('keycollection')->value ?? ''}}" readonly >
                                    </div>
                                    @if ($job->job_type!= 'Fire Safety Asset Check/Block Inspection')
                                    <div class="input-group input-group-static mb-4">
                                        <label for="tenancytype_select" class="ms-0">Internal Property Keys Reference(Optional)</label>
                                        <input type="text" name="tend_internallkeyref" class="form-control" value="{{$job->metaBySlug('tend_internallkeyref')->value ?? ''}}" readonly >
                                    </div>
                                    @endif
                                    @if ($job->job_type== 'Fire Safety Asset Check/Block Inspection')
                                    <div class="input-group input-group-static mb-4">
                                        <label for="tenancytype_select" class="ms-0">Door access code(s)</label>
                                        <input type="text" name="door_access_code" class="form-control" value="{{$job->metaBySlug('door_access_code')->value ?? ''}}" readonly  >
                                    </div>
                                    <div class="input-group input-group-static mb-4">
                                        <label for="propertysize_select" class="ms-0">Is there a concierge on site?</label>
                                        <select class="form-control" name="concierge_site" id="" required="">
                                        <option>{{$job->metaBySlug('concierge_site')->value ?? ''}}</option>
                                        </select>
                                    </div>
                                    @endif
                                </div>
                                @endif
                                @if ($job->job_type== 'Attend an Eviction')
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="tenancytype_select" class="ms-0">What time are the bailiffs scheduled to arrive?</label>
                                        <input type="text" name="bailiffs_scheduled" class="form-control"  value="{{$job->metaBySlug('bailiffs_scheduled')->value ?? ''}}" readonly   >
                                    </div>
                                    <div class="input-group input-group-static mb-4">
                                        <label for="propertysize_select" class="ms-0">Will a locksmith be in attendance?</label>
                                        <select class="form-control" name="locksmith_attendance" disabled>
                                        <option>{{$job->metaBySlug('locksmith_attendance')->value ?? ''}}</option>
                                        </select>
                                    </div>
                                </div>
                                @endif
                                @if ($job->job_type== 'Abandonment Notice' || $job->job_type==  "LPA- Visit/Lock Change Notice/Occupancy Check")
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="tenancytype_select" class="ms-0">Access code(s)</label>
                                        <input type="text" name="door_access_code" class="form-control" value="{{$job->metaBySlug('door_access_code')->value ?? ''}}" readonly   >
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @if ($job->job_type== 'Smoke and CO Inspection/Installation' )
                        <div>
                            <h4 class="lead mt-3">Authorisation</h4>
                              <div class="input-group input-group-static mb-4">
                                <label for="propertysize_select" class="ms-0">Provide PRMS with prior authorisation to replace and/or install new detectors as required?</label>
                                <select class="form-control" name="authorisation" id="" required="">
                                        <option>{{$job->metaBySlug('authorisation')->value ?? ''}}</option>
                                </select>
                            </div>
                        </div>
                        @endif
                        @if ($job->job_type== 'Attend an Eviction')
                        <div>
                            <h4 class="lead mt-3">Is there anything we need to know about the tenants character?</h4>
                            <div class="input-group input-group-static mb-4">
                                <label for="tenancytype_select" class="ms-0"></label>
                                <label for="tenancytype_select" class="ms-0"><strong>This is for the safety of our clerks. Please provide any relevant information in regard to the tenant(s)</strong></label>
                                <textarea name="furtherinfo_tenat" class="form-control" placeholder="Information..." readonly>{{$job->metaBySlug('furtherinfo_tenat')->value ?? ''}}</textarea>
                            </div>
                        </div>
                        @endif
                        <div>
                            <h4 class="lead mt-3">Is there anything else we need to know?</h4>
                            <div class="input-group input-group-static mb-4">
                                <label for="tenancytype_select" class="ms-0">Please provide any additional information below.</label>
                                <textarea name="furtherinfo" class="form-control" placeholder="Information..." readonly>{{$job->metaBySlug('furtherinfo')->value ?? ''}}</textarea>
                            </div>
                        </div>
                       
                        </div>

                                @if($job->clerk_id)
                                    <span class="mb-2 text-sm">Assigned Clerk: <span
                                            class="text-dark ms-md-1 font-weight-bold">{{ $job->clerk->first_name }}
                                            {{ $job->clerk->last_name }},
                                            <small>{{ $job->clerk->email }}</small></span></span>
                                @endif
                                @if($job->appointment_date)
                                    <span class="mb-2 text-sm">Appointment Date: <span
                                            class="text-dark ms-md-1 font-weight-bold">{{ date("Y/m/d", strtotime($job->appointment_date))  }}</span></span>
                                @endif
                                @if($job->uploadedFile)
                                    <p class="mb-2 text-sm">File attached: <a class="text-dark ms-sm-2 font-weight-bold"
                                            href="{{ $job->uploadedFile }}">View Uploaded File</a></p>
                                @endif
                                @if($job->uploadedFiles->count() > 0)
                                    @foreach($job->uploadedFiles as $file )
                                    <h4 class="lead mt-2">Report File(s):</h4>
                                    <div>
                                    <a href="{{ $file->file_name }}" target="_blank">
                                        <h3>
                                            <i class="fa fa-download text-info" aria-hidden="true"></i>
                                            <span class="text-dark text-md ms-md-1 font-weight-bold">{{ $file->comment }}</span>
                                        </h3>
                                    </a>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-2 mt-2 mb-5">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Comment</h6>
            </div>
        </div>
        <div class="card-body p-3 pt-0">
            <div class="timeline timeline-one-side mt-4">
                @foreach($job->comments as $comment )
                    <div class="timeline-block mb-3">
                        <span class="timeline-step">
                            <i class="material-icons text-info text-gradient">email</i>
                        </span>
                        <div class="timeline-content">
                            <h6 class="text-dark text-sm font-weight-bold mb-0">{{ $comment->comment }}</h6>
                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                {{ $comment->author->first_name }} {{ $comment->author->last_name }},
                                {{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <form method="POST" action="{{ route('dashboard.job-update') }}"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="input-group input-group-outline focused is-focused mb-3">
                        <textarea id="comment" name="comment" class="form-control" placeholder="Comment"
                            rows="7"></textarea>
                    </div>
                </div>
        @csrf
        <input type="hidden" name="job_id" value="{{ $job->id }}" />
        <button type="submit" class="btn bg-gradient-info ">Comment</button>
        </form>
        </div>

    </div>
</div>
</div>
@endsection
