@extends('dashboard.layout')
@section('title','Jobs')
@section('content')
<style>
  .verticle-bottom {
    vertical-align: bottom !important;
  }
  .verticle-middle {
    vertical-align: middle !important;
  }
</style>
<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Jobs</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-4">
                <table class="table align-items-center mb-0" id="job_table">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Job Type</th>
                      <th class="text text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Address</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Post Code</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Requested Date</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Clerk</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Scheduled Date</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
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
@endsection
@section('js')
<script>
  var user_table = $('#job_table').DataTable({
      "destroy": true,
      "processing": false,
      "serverSide": true,
      "autoWidth": false,
      "ajax": {
        url:"{{route('dashboard.job-list')}}",
        type: "POST",
        "data": {
        }
      },
      columns: [
        {data: 'user', name:'user'},
        {data: 'name', name: 'name'},
        {data: 'address', name: 'address'},
        {data: 'postal_code', name: 'postal_code'},
        {data: 'date', name: 'date'},
        {data: 'clerk', name: 'clerk'},
        {data: 'status', name: 'status'},
        {data: 'appointment_date', name: 'appointment_date'},
        {data: 'delete', name: 'delete'},
      ],
      "order": [],
      "columnDefs": [
        {"className": "verticle-middle", "targets":[2]},
        {"className": "text-center", "targets": [3,4,5,6, 7,8]},
        {"className": "text-right", "targets": []}
      ],
      language: {
            paginate: {
            next: '<i class="fa fa-fw fa-long-arrow-right"></i>',
            previous: '<i class="fa fa-fw fa-long-arrow-left"></i>'  
            }
        }

  });
  function deleteJob(id) {
  swal({
      title: "Are you sure?",
      text: "You want to delete this job?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((yes) => {
      if (yes) {
        $.post("{{route('dashboard.job-delete')}}", {
          job_id: id
        }).done( (res) => {
          swal("Job has been deleted", { icon: "success",});
          user_table.ajax.reload();
        }).fail( (data) => {
          const {message} = data.responseJSON
          swal("Oh noes!", message, "error");
        });;
      }
    });
}
</script>
@endsection