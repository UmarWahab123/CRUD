<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Add Student</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   </head>
   <body>
      <section style="padding-top: 60px;">
         <div class="container">
            <div class="row">
               <div class="col-md-6 offset-md-3">
                  <div class="card">

                     <div class="card-header">
                       <h3>Add New Student</h3>
                        <a class="btn btn-info float-right mb-0" style="float: right;" href="{{url('all-student')}}">Go Back</a>
                     </div>
                     <div class="card-body">
                        <!--success alret -->
                        @if(Session::has('student_added'))
                        <div class="alert alert-success" role="alert">
                           {{Session::get('student_added')}}
                        </div>
                        @endif
                        <form method="POST" action="{{route('student.store')}}" enctype="multipart/form-data">
                           @csrf
                           <div class="form-group">
                              <label for="name">Name</label>
                              <input type="text" name="name" class="form-control"/>
                              <!-- @error('name')
                              <span class="text-danger">{{$message}}</span>
                              @enderror -->
                           </div>
                           <!--Code for profile Image -->
                           <div class="form-group">
                              <label for="file">Choose Profile Image</label>
                              <input type="file" name="file" class="form-control" onchange="loadFile(event)"/>
                              <img id="output" alt="profile image" style="max-width: 120px;margin-top:10px;"/>

                           </div>
                           <br>
                           <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <!--this is a function for file(image) preview -->
      <!-- <script>
         function previewFile(input){
         var File = $("input[type=file]").get(0).files[0];
          if(file){
            var reader = new FileReader()
            reader.onload = function(){
              $('#previewImg').attr("src",reader.result);
            }
            reader.readAsDataURL(file);
          }
         }
         </script> -->
      <!--this is also a function for file(image) preview -->
      <script>
         var loadFile = function(event) {
           var reader = new FileReader();
           reader.onload = function(){
             var output = document.getElementById('output');
             output.src = reader.result;
           };
           reader.readAsDataURL(event.target.files[0]);
         };
      </script>
      <!--add this code for toastr notification -->
      @if(Session::has('student_added'))
             <script>
             toastr.success("{!! Session::get('student_added') !!}");
             </script>
      @endif

<!--this code is for sweet alert -->
  @if(Session::has('student_added'))
             <script>
             swal("Great Job!","{!! Session::get('student_added') !!}","success",{
                button:"OK",
             });
             </script>
      @endif


   </body>
</html>
