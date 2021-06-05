<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>
<section style="padding-top:60px;">
<div class="container">
<div class="row">
<div class="col-md-6 offset-md-3">
<div class="card">
<div class="card-header">
Contact Us
</div>
<div class="card-body">

 <!--alret -->
@if(Session::has('message_sent'))
<div class="alert alert-success" role="alert">
{{Session::get('message_sent')}}
</div>
@endif

<form method="POST" action="{{route('contact.send')}}" enctype="multipart/form-data">
@csrf

<div class="form-group">
<label for="name">Name</label>
<input type="text" name="name" class="form-control"/>
</div>

<div class="form-group">
<label for="email">Email</label>
<input type="text" name="email" class="form-control"/>
</div>

<div class="form-group">
<label for="phone">Phone</label>
<input type="text" name="phone" class="form-control"/>
</div>

<div class="form-group">
<label for="msg">Message</label>
<textarea name="msg" class="form-control"></textarea>
</div>
<br>
<button type="submit" class="btn btn-primary" style="float: right;">Submit</button>

</form>

</div>
</div>
</div>
</div>
</div>
</section>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>
