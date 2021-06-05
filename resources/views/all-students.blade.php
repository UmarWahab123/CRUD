<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>All Students</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   </head>
   <body>
      <section style="padding-top: 60px;">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-header">
                        All Students <a href="/add-student" class="btn btn-success">Add New</a>
                     </div>
                     <div class="card-body">
                      <!--alret -->
                        @if(Session::has('student_deleted'))
                        <div class="alert alert-success" role="alert">
                           {{Session::get('student_deleted')}}
                        </div>
                        @endif

                        <table class="table table-striped">
                           <thead>
                              <tr>
                                 <th>Name</th>
                                 <th>Profile Image</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($student as $std)
                              <tr>
                                 <td>{{$std->name}}</td>
                                 <td><img src="{{asset('images')}}/{{$std->profileimage}}" style="max-width: 60px;"/></td>
                                 <td>
                                    <a href="/edit-student/{{$std->id}}" class="btn btn-info">Edit</a>
                                    <a href="/delete-student/{{$std->id}}" class="btn btn-danger">Delete</a>
                                 </td>
                                 @endforeach
                              </tr>
                           </tbody>
                        </table>
                        {!! $student->links() !!}
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

       <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

   <!--add this code for toastr notification -->
      @if(Session::has('student_deleted'))
             <script>
             toastr.success("{!! Session::get('student_deleted') !!}");
             </script>
      @endif

<!--this code is for sweet alert -->
  @if(Session::has('student_deleted'))
             <script>
             swal("Great Job!","{!! Session::get('student_deleted') !!}","success",{
                button:"OK",
               });
             </script>
      @endif

   </body>
</html>
