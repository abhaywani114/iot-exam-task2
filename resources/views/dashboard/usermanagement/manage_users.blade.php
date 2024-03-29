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
                <h6 class="text-white text-capitalize ps-3">Users Management</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
            <div class="w-100 px-3">
              <a class="btn bg-gradient-info mb-4 mb-2" style="margin-left: auto;width: 165px;display: block;" href="javascript:newUser();" type="button">Create New User</a>
            </div>
              <div class="table-responsive p-4">
                <table class="table align-items-center mb-0"   id="admin_table">
                  <thead>
                    <tr>
                        <th  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width:30px;">No</th>
                        <th  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="wdith:400px;">Name</th>
                        <th  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width:250px;">Email</th>
                        <th  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width:100px;">Type</th>
                        <th  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width:100px;">Status</th>
                        <th  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width:100px;">Ban</th>
                        <th  class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width:100px;">Edit</th>
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
<div class="modal" tabindex="-1" role="dialog" id="user_edit">
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
  var user_table = $('#admin_table').DataTable({
      "destroy": true,
      "processing": false,
      "serverSide": true,
      "autoWidth": false,
      "ajax": {
        url:"{{route('dashboard.user-management.data')}}",
        type: "POST",
        "data": {
        }
      },
      columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'type', name: 'type'},
        {data: 'status', name: 'status'},
        {data: 'ban', name: 'ban'},
        {data: 'edit', name: 'edit'},
        {data: 'delete', name: 'delete'}
      ],
      "order": [],
      "columnDefs": [
        {"className": "text-center", "targets": [0,3,4,5,6,7,]},
        {"className": "text-right", "targets": []}
      ],
      language: {
            paginate: {
            next: '<i class="fa fa-fw fa-long-arrow-right"></i>',
            previous: '<i class="fa fa-fw fa-long-arrow-left"></i>'  
            }
        },
        dom: 'Bfrtip',
                buttons: [
                    'pdfHtml5'
                ]
  });

function ban(id) {
    $.post("{{route('dashboard.user-management.ban')}}", {
      user_id: id
    }).done( (res) => {
      swal("User has been updated", { icon: "success",});
      user_table.ajax.reload();
    }).fail( (data) => {
      console.error(data)
      swal("Oh noes!", `${data.responseJSON.error}`, "error");
    });;
}

function deleteUser(id) {
  swal({
      title: "Are you sure?",
      text: "You want to delete this user?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((yes) => {
      if (yes) {
        $.post("{{route('dashboard.user-management.delete')}}", {
          user_id: id
        }).done( (res) => {
          swal("User has been deleted", { icon: "success",});
          user_table.ajax.reload();
        }).fail( (data) => {
          const {error} = data.responseJSON
          swal("Oh noes!", error, "error");
        });;
      }
    });
}
function updateUserModal(id, name, email, phone, role) {
  var modal = document.getElementById('user_edit');
  var modalTitle = modal.querySelector('.modal-title');
  var modalBody = modal.querySelector('.modal-body');
  if (name != '')
    modalTitle.innerText = 'Edit User: ' + name;
  else
    modalTitle.innerText = 'New User';
  modalBody.innerHTML = `
    <form id="user_form" method="POST" action="{{route('dashboard.user-management.update-or-add')}}">
      <div class="input-group input-group-outline mb-3 mt-1">
        <input type="hidden" class="form-control" id="user_id" value="${id}" readonly name="id" >
      </div>
      <div class="input-group input-group-outline mb-3 mt-1">
        <input type="text" class="form-control" id="user_name" value="${name}" name="name" placeholder="User's name">
      </div>
      <div class="input-group input-group-outline mb-3 mt-1">
        <input type="email" class="form-control" id="user_email" value="${email}" name="email" placeholder="User's email">
      </div>
      <div class="input-group input-group-outline mb-3 mt-1">
        <input type="email" class="form-control" id="user_phone" value="${phone}" name="phone" placeholder="User's phone">
      </div>
      <div class="input-group input-group-outline mb-3 mt-1">
        <select class="form-control" id="user_role" name="role">
          <option value="admin" ${role === 'admin' ? 'selected' : ''}>Admin</option>
          <option value="viewer" ${role === 'viewer' ? 'selected' : ''}>Viewer</option>
          <option value="supervisor" ${role === 'supervisor' ? 'selected' : ''}>Supervisor</option>
          <option value="engineer" ${role === 'engineer' ? 'selected' : ''}>Engineer</option>
          <option value="manager" ${role === 'manager' ? 'selected' : ''}>Manager</option>
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

function newUser() {
  updateUserModal('', '', '', '', 'user')
}

function closeUpdateModal() {
  var modal = document.getElementById('user_edit');
  $(modal).modal('hide');
}


</script>
@endsection
