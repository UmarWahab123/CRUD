<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Ajax CRUD</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
      <!-- jquary cdn is the below one-->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   </head>
   <body>
      <section style="padding-top:60px">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-header">
                       <a class="btn btn-info float-right" style="float: right;" href="#"data-bs-toggle="modal" data-bs-target="#teacherModal">Add New Teacher</a>
                       <h3>Teachers</h3>
                     </div>
                     <div class="card-body">
                        <table id="teacherTable" class="table">
                           <thead>
                              <tr>
                                 <th>First Name</th>
                                 <th>Last Name</th>
                                 <th>Email</th>
                                 <th>Phone</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($teachers as $teacher)
                              <tr>
                                 <td>{{$teacher->firstname}}</td>
                                 <td>{{$teacher->lastname}}</td>
                                 <td>{{$teacher->email}}</td>
                                 <td>{{$teacher->phone}}</td>
                                 <td>
                                 <a href="javascript:void(0)" class="btn btn-info">Edit</a>
                                 <a href="javascript:void(0)" class="btn btn-danger">Delete</a>
                                 </td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
<!-- Modal -->
<div class="modal fade" id="teacherModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Teacher</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form id="teacherForm">
      @csrf
      <div class="form-group">
      <label for="firstname">First Name</label>
      <input type="text" name="name" class="form-control" id="firstname" required/>
      </div>

      <div class="form-group">
      <label for="lastname">Last Name</label>
      <input type="text" name="name" class="form-control" id="lastname" required/>
      </div>

      <div class="form-group">
      <label for="email">Email</label>
      <input type="text" name="email" class="form-control" id="email" required/>
      </div>

      <div class="form-group">
      <label for="phone">Phone</label>
      <input type="text" name="phone" class="form-control" id="phone" required/>
      </div>
       <br>
      <button type="submit" class="btn btn-primary">Submit</button>
      </form>
      </div>
    </div>
  </div>
</div>
            <!--Ajax code -->
        <script>
        $("#teacherForm").submit(function(e){
           e.preventDefault();
           let firstname = $("#firstname").val();
           let lastname = $("#lastname").val();
           let email = $("#email").val();
           let phone = $("#phone").val();
           let _token = $("input[name=_token]").val();

           $.ajax({
              url:"{{route('teacher.add')}}",
              type:"POST",
              data:{
                 firstname:firstname,
                 lastname:lastname,
                 email:email,
                 phone:phone,
                 _token:_token,
              },
              success:function(responce){
              if(responce)
              {
                 $("#teacherTable tbody").prepend('<tr><td>'+responce.firstname+'</td><td>'+responce.lastname+'</td><td>'+responce.email+'</td><td>'+responce.phone+'</td></tr>');
                 $("#teacherForm")[0].reset();
                 $("#teacherModal").modal('hide');
              }
            },
           });
        });

        </script>

   </body>
</html>
