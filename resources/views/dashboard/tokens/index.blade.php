@extends('dashboard.layout')
@section('title', 'Token Management')
@section('content')
<style>
    .fa-ban {
      font-size: 20px;
      cursor:pointer;
    }
    .unban, .ban:hover {
      color: #ff0000;
    }
    .admin:hover, .allowed:hover {
      color: green !important;
    }
    </style>
<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Token Management</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
            <div class="w-100 px-3">
              <a class="btn bg-gradient-info mb-4 mb-2" style="margin-left: auto;width: 165px;display: block;" href="javascript:addTokens();" type="button">Create New Token</a>
            </div>
              <div class="table-responsive p-4">
                <table class="table align-items-center mb-0"   id="token">
                   <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width:30px;">No</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width:100px;">Token No</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width:100px;">Job No</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width:100px;">Vehicle No</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width:100px;">Vehicle Type</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width:70px;">User</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width:70px;">Service</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width:70px;">Status</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width:70px;">Timer</th>
                        </tr>
                    </thead>

                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="token_add">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick=" closeUpdateModal()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary save-btn">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<style>
  input[readonly=true] {
    background: #ccc;
  }
  </style>
<script>
  var token_table = $('#token').DataTable({
      "destroy": true,
      "processing": false,
      "serverSide": true,
      "autoWidth": false,
      "ajax": {
        url:"{{route('dashboard.token.data')}}",
        type: "POST",
        "data": {
        }
      },
      columns: [
          { data: 'DT_RowIndex', name: 'DT_RowIndex' },
          { data: 'token_no', name: 'token_no' },
          { data: 'job_no', name: 'job_no' },
          { data: 'vehicle_no', name: 'vehicle_no' },
          { data: 'vehicle_type', name: 'vehicle_type' },
          { data: 'user', name: 'user' },
          { data: 'service', name: 'service' },
          { data: 'status', name: 'status' },
          { data: 'timer', name: 'timer' },
        ],
        "order": [],
        "columnDefs": [
            { "className": "text-center", "targets": [0,1,2,3,4,5,6,7, 8] }, // Adjust the targets as needed
            { "className": "text-right", "targets": [] } // Adjust the targets as needed
        ],
      language: {
            paginate: {
            next: '<i class="fa fa-fw fa-long-arrow-right"></i>',
            previous: '<i class="fa fa-fw fa-long-arrow-left"></i>'  
            }
        },
        @if(Auth::user()->role == 'admin')
        dom: 'Bfrtip',
        buttons: [
            'pdfHtml5'
        ]
        @endif
  });

  function addTokens() {
    var modal = document.getElementById('token_add');
    var modalTitle = modal.querySelector('.modal-title');
    var modalBody = modal.querySelector('.modal-body');

    modalTitle.innerText = 'Add token';
    modalBody.innerHTML = `
        <form id="token_form" method="POST" action="{{ route('dashboard.token.store') }}">
            <div class="input-group input-group-outline mb-3 mt-1">
                <input type="text" class="form-control" id="phone_number" name="user_mobile_email" placeholder="User's Phone Number">
            </div>
            <div class="input-group input-group-outline mb-3">
                <input type="text" class="form-control w-100" id="user_name" name="user_name" placeholder="User's Name" style="background:#f1f1f1;" readonly>
                <small class="text-muted" id="name_message" style="display:none;">Please fill in the name</small>
            </div>
            <div class="input-group input-group-outline mb-3">
                <input type="email" class="form-control w-100" id="user_email" name="user_email" placeholder="User's Email" style="background:#f1f1f1;" readonly>
                <small class="text-muted" id="email_message" style="display:none;">Please fill in the email</small>
            </div>
            <div class="input-group input-group-outline mb-3">
                <input type="text" class="form-control" id="vehicle_no" name="vehicle_no" placeholder="Vehicle No">
            </div>
            <div class="input-group input-group-outline mb-3">
                <input type="text" class="form-control" id="vehicle_type" name="vehicle_type" placeholder="Vehicle Type">
            </div>
            <div class="input-group input-group-outline mb-3">
                <select class="form-select" id="service_id" name="service_id">
                    <option value="" class="p-1">Select Service</option>
                    @foreach($services as $s)
                      <option value="{{$s->id}}" class="p-1">{{$s->name}}</option>
                    @endforeach
                </select>
            </div>
            @csrf
        </form>
    `;

    // Add event listener for phone number input
    var phoneNumberInput = modal.querySelector('#phone_number');
    phoneNumberInput.addEventListener('change', function() {
        var phoneNumber = this.value;
        if (phoneNumber) {
            // Make AJAX request to check if user exists
            // Replace 'check-user-exists' with your actual route
            $.ajax({
                url: "{{ route('dashboard.token.check-user-exists') }}",
                method: 'POST',
                data: { phone_number: phoneNumber },
                success: function(response) {
                    if (response.exists) {
                        // If user exists, fill in the name and email fields
                        document.getElementById('user_name').value = response.user.name;
                        document.getElementById('user_email').value = response.user.email;
                        // Hide the message elements
                        document.getElementById('name_message').style.display = 'none';
                        document.getElementById('email_message').style.display = 'none';

                        document.getElementById('user_name').readOnly = true;
                        document.getElementById('user_email').readOnly = true;
                    } else {
                        // If user does not exist, show the message elements
                        document.getElementById('user_name').readOnly = false;
                        document.getElementById('user_email').readOnly = false;
                        document.getElementById('user_name').style.background = '#fff';
                        document.getElementById('user_email').style.background = '#fff';
                
                        document.getElementById('name_message').style.display = 'block';
                        document.getElementById('email_message').style.display = 'block';
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });

    // Get the save button
    var saveButton = modal.querySelector('.save-btn');
    saveButton.addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('token_form').submit();
    });

    $(modal).modal('show');
}


function closeUpdateModal() {
  var modal = document.getElementById('token_add');
  $(modal).modal('hide');
}


</script>
@endsection
