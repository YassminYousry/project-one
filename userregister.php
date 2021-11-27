
<?php 

# Logic 
require './helpers/dbConnection.php';
require './helpers/functions.php';

 # Select Roles ..... 
$sql = "select * from roles order by id desc";
$op  = mysqli_query($con,$sql);






 if($_SERVER['REQUEST_METHOD'] == "POST"){

   $name     = Clean($_POST['name']);
   $phone    = Clean($_POST['phone']);
   $password = Clean($_POST['password']);
   //$role_id  = Clean($_POST['role_id']);


   # Image File Data  .... 
   $file_tmp  =  $_FILES['image']['tmp_name'];
   $file_name =  $_FILES['image']['name'];  
   $file_size =  $_FILES['image']['size'];
   $file_type =  $_FILES['image']['type'];   

   $file_ex   = explode('.',$file_name);
   $updated_ex = strtolower(end($file_ex));
 


   $errors = [];

   # Name Validation ... 
   if(!validate($name,1)){
       $errors['Name'] = "Field Required";
   }elseif(!validate($name,6)){
       $errors['Name'] = "Invalid String";
   }


  
  # Phone Validation 
  if(!validate($phone,1)){
   $errors['phone'] = "Field Required";
  }elseif(!validate($phone,7)){
    $errors['phone'] = "Invalid Phone Number";
 }



 # Password Validate 
 if(!validate($password,1)){
   $errors['Password'] = "Field Required";
  }elseif(!validate($password,4)){
    $errors['Password'] = "Invalid Length , Length Must Be >= 6 ch";
 }



//  # Role Validation .... 
//  if(!validate($role_id,1)){
//    $errors['Role'] = "Field Required";
//   }elseif(!validate($role_id,5)){
//     $errors['Role'] = "Invalid Role";
//  }


 # Image Validate ..... 
 if(!validate($file_name,1)){
     $errors['Image'] = "Field Required";
 }elseif(!validate($updated_ex,8)){
     $errors['Image'] = "Invalid Extension";
 }



   if(count($errors) > 0){
       $_SESSION['Message'] = $errors;
   }else{

     # Upload Image ..... 
       $finalName = rand().time().'.'.$updated_ex;

       $disPath = '../Admin/users/uploads/'.$finalName;

     if(move_uploaded_file($file_tmp,$disPath)){
        // DB Code .... 
        $password = md5($password);
        $sql = "insert into users (name,phone,password,image,role_id) values ('$name','$phone','$password','$finalName',2)";
        // echo mysqli_error($con);
        // exit();

        $insert_op  = mysqli_query($con,$sql);
if($insert_op){
       $message = ['Raw Inserted'];
   }else{
       $message = ['Error Try Again'];
   }
   
   }else{
   
   $message = ["Error In Upload Image Try Again"];
   }
   $_SESSION['Message'] = $message;
   header("Location: index.php");
   exit();
   }
   } // end form Logic ..... 
   


?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="icon" href="./img/logo.jpg">
        <title>TAXI DRIVER</title>
        <link href="css/style.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-secondary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container ">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                    <?php 
               
               if(isset($_SESSION['Message'])){
                   foreach($_SESSION['Message'] as $key => $val){
                      
                    echo '* '.$key.' : '.$val.'<br>';

                   }
                   unset($_SESSION['Message']);
               }else{  ?>

                <h3 class="text-center font-weight-light my-4">Add New User</h3>

                <?php   }   ?>
                                    </div> 
                                    <div class="card-body">
                                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post"  enctype="multipart/form-data">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputFirstName"> Name</label>
                                                        <input class="form-control py-4" id="inputFirstName" type="text" name="name" placeholder="Enter first name" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Phone</label>
                                                <input class="form-control py-4" name="phone" id="inputEmailAddress" type="number"  placeholder="Enter phone number" />
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName">Image</label> <br>
                                                <input type="file" name="image">
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputPassword">Password</label>
                                                        <input class="form-control py-4" name="password"  id="inputPassword" type="password" placeholder="Enter password" />
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <button type="submit" class="btn btn-primary">Create New Account</button>
                                            <!-- <div class="form-group mt-4 mb-0"><a class="btn btn-primary btn-block" type="submit">Create Account</a></div> -->
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="login.html">Have an account? Go to login</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
