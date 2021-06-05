<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Tiny MCE html editor</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
   </head>
   <body>
      <section style="padding-top: 60px;">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-header">
                        Tiny MCE html editor
                     </div>
                     <div class="card-body">
                        <form method="POST">
                           @csrf
                           <textarea id="mytextarea" name="mytextarea"></textarea>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
      <!--for tinymce html add the below script-->
      <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
      <!--let's configure the above textarea to tiny mce write the below code-->
      <script>
         tinymce.init({
           selector: '#mytextarea'
         });
      </script>
   </body>
</html>
