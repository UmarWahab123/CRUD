<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Edit Student</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
   </head>
   <body>
      <section style="padding-top: 60px;">
         <div class="container">
            <div class="row">
               <div class="col-md-6 offset-md-3">
                  <div class="card">
                     <div class="card-header">
                       <h3> Edit Student</h3>
                         <a class="btn btn-info float-right mb-0" style="float: right;" href="{{url('all-student')}}">Go Back</a>
                     </div>
                     <div class="card-body">
                        <!--success alret -->
                        @if(Session::has('student-updated'))
                        <div class="alert alert-success" role="alert">
                           {{Session::get('student-updated')}}
                        </div>
                        @endif
                        <form method="POST" action="{{route('student-update')}}" enctype="multipart/form-data">
                           @csrf
                           <input type="hidden" name="id" value="{{$student->id}}"/>
                           <div class="form-group">
                              <label for="name">Name</label>
                              <input type="text" name="name" value="{{$student->name}}" class="form-control"/>
                           </div>
                           <!--Code for profile Image -->
                           <div class="form-group">
                              <label for="file">Choose Profile Image</label>
                              <input type="file" name="file" class="form-control" onchange="loadFile(event)"/>
                              <img id="output" alt="profile image" src="{{asset('images')}}/{{$student->profileimage}}" style="max-width: 120px;margin-top:10px;"/>
                           </div>
                           <br>
                           <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
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
   </body>
</html>
