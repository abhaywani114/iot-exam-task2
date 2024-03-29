@extends('dashboard.layout')
@section('title', 'User Management')
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
                <h6 class="text-white text-capitalize ps-3">Services Management</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
            <div class="w-100 px-3">
              <a class="btn bg-gradient-info mb-4 mb-2" style="margin-left: auto;width: 165px;display: block;" href="javascript:addServices();" type="button">Create New Service</a>
            </div>
              <div class="table-responsive p-4">
                <table class="table align-items-center mb-0"   id="service">
                  <thead>
                    <tr>
                        <th  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width:30px;">No</th>
                        <th  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="wdith:400px;">Name</th>
                        <th  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width:100px;">Delete</th>
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
<div class="modal" tabindex="-1" role="dialog" id="service_add">
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
<script>
  var service_table = $('#service').DataTable({
      "destroy": true,
      "processing": false,
      "serverSide": true,
      "autoWidth": false,
      "ajax": {
        url:"{{route('dashboard.services.data')}}",
        type: "POST",
        "data": {
        }
      },
      columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        {data: 'name', name: 'name'},
        {data: 'delete', name: 'delete'}
      ],
      "order": [],
      "columnDefs": [
        {"className": "text-center", "targets": [0,2]},
        {"className": "text-right", "targets": []}
      ],
      language: {
            paginate: {
            next: '<i class="fa fa-fw fa-long-arrow-right"></i>',
            previous: '<i class="fa fa-fw fa-long-arrow-left"></i>'  
            }
        }
  });

function deleteService(id) {
  swal({
      title: "Are you sure?",
      text: "You want to delete this service?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((yes) => {
      if (yes) {
        $.post("{{route('dashboard.services.delete', 'ID')}}".replace('ID',id), {
          service_id: id
        }).done( (res) => {
          swal("Service has been deleted", { icon: "success",});
          service_table.ajax.reload();
        }).fail( (data) => {
          const {error} = data.responseJSON
          swal("Oh noes!", error, "error");
        });;
      }
    });
}
function addServices() {
  var modal = document.getElementById('service_add');
  var modalTitle = modal.querySelector('.modal-title');
  var modalBody = modal.querySelector('.modal-body');

    modalTitle.innerText = 'Add Service';
  modalBody.innerHTML = `
    <form id="user_form" method="POST" action="{{route('dashboard.services.store')}}">
      <div class="input-group input-group-outline mb-3 mt-1">
        <input type="text" class="form-control" id="user_name" value="" name="name" placeholder="Service name">
      </div>
        </select>
      </div>
      @csrf
    </form>
  `;
    // Get the save button
    var saveButton = modal.querySelector('.save-btn');
    saveButton.addEventListener('click', function(event) {
      event.preventDefault();
      document.getElementById('user_form').submit();
    });
 
    $(modal).modal('show');
}


function closeUpdateModal() {
  var modal = document.getElementById('service_add');
  $(modal).modal('hide');
}


</script>
@endsection
