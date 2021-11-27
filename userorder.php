<?php 
 # Logic 
 require 'helpers/dbConnection.php';
 require 'helpers/functions.php';



 # GET RAW Data .... 
 $user_id = $_GET['id'];
 $errors = [];

 # Start Validation .... 

if(!validate($user_id,1)){
    $errors['id'] = "Field Required";
}elseif(!validate($user_id,5)){

    $errors['id'] = "Invalid id";
}


if(count($errors) > 0){

    $Message = $errors;

    $_SESSION['Message'] = $Message;

    header("Location: userorder.php");
    exit();
    
  }else{
   # Select Data ..... 
 $sql = "select users.id from users where id = $user_id";
 $op  = mysqli_query($con,$sql);
 $data = mysqli_fetch_assoc($op);


}

# Select City ..... 
$sql = "select * from city order by id desc ";
$op  = mysqli_query($con,$sql);

 
  if($_SERVER['REQUEST_METHOD'] == "POST"){

    $pick_up_point     = Clean($_POST['pick_up_point']);
    $drop_point        = Clean($_POST['drop_point']);
    $price             = Clean($_POST['price']);
    $order_time        = Clean($_POST['date']);
    $city              = Clean($_POST['city']);


    $errors = [];

  # pick up point  Validation ... 
    if(!validate($pick_up_point,1)){
        $errors['Pick_up_point'] = "Field Required";
    }elseif(!validate($pick_up_point,6)){
        $errors['Pick_up_point'] = "Invalid String";
    }

   # drop point Validate 
   if(!validate($drop_point,1)){
    $errors['Drop_point'] = "Field Required";
  }elseif(!validate($drop_point,6)){
    $errors['Drop_point'] = "Invalid point";
  }

   # price Validation 
   if(!validate($price,1)){
    $errors['price'] = "Field Required";
   }elseif(!validate($price,5)){
     $errors['price'] = "Invalid point";
  }


  # order time Validation .... 
  if(!validate($order_time,1)){
    $errors['Order_time'] = "Field Required";
   }elseif(!validate($order_time,10)){
     $errors['Order_time'] = "Invalid time";
  }
 # user id Validation .... 
 if(!validate($user_id,1)){
    $errors['User_id'] = "Field Required";
   }elseif(!validate($user_id,5)){
     $errors['User_id'] = "Invalid time";
  }
    if(count($errors) > 0){
        $_SESSION['Message'] = $errors;
    }else{
        $date  = strtotime($order_time);

       # Db Operation ..... 
       $sql = "insert into orders (pick_up_point ,drop_point ,price,city,order_time,user_id) values ('$pick_up_point','$drop_point',$price,'$city','$date',$user_id)";
       $op  = mysqli_query($con,$sql);


       if($op){
           $message = ['Data Inserted'];
       }else{
           $message = ['Error Try Again'];
       }
       $_SESSION['Message'] = $message;
    
       header("Location: index.php");
       exit();

    }

      $_SESSION['Message'] = $message;
      header("Location: index.php");
      exit();
   

    }
  // end form Logic ..... 
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/css.css">
    <link rel="icon" href="./img/logo.jpg">
    <title>TAXI DRIVER</title>
</head>
<body>
    
</body>
</html>
<main class="container-fluid">
  
  <div class="modal modal-tour position-static d-block bg-secondary py-5" tabindex="-1" role="dialog" id="modalTour">
    <div class="modal-dialog" role="document">
      <div class="modal-content rounded-6 shadow">
        <div class="modal-body p-5">
          <h2 class="fw-bold mb-0 text-center">User Order</h2>
  
          <ul class="d-grid gap-4 my-5 list-unstyled">
            <li class="d-flex gap-4">
            <div class="embed-responsive embed-responsive-4by3">
              <div id="map-container" class="embed-responsive-item">
              <div id="map">
                  <iframe src=
                    "https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d13617.505513693457!2d31.685340449999998!3d31.4313037!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sar!2seg!4v1637810123322!5m2!1sar!2seg"
                          width="400"
                          height="300"
                          frameborder="0"
                          style="border:0;"
                          allowfullscreen=""
                          aria-hidden="false"
                          tabindex="0">
                  </iframe>
                 </div>
              </div> 
              </div>
              </li>
          <form action="userorder.php?id=<?php echo $data['id'];?>" method="post"  enctype="multipart/form-data">
            <li class="d-flex gap-4">
             <div>
                <h5 class="mb-0 text">Pick Up Point</h5>
                <br>
                <div class="form-group">
                <input type="text" class="form-control" name="pick_up_point" placeholder="Enter Your Pick up Point">

              </div>
            </li>
            
            <li class="d-flex gap-4">
             <div>
                <h5 class="mb-0">Drop Point</h5>
                <br>
                <div class="form-group">
                <input type="text" class="form-control" name="drop_point" placeholder="Enter Your Drop Point">
              </div> </div>
            </li>
            <li class="d-flex gap-4">
             <div>
                <h5 class="mb-0">price</h5>
              <br>
                <input class="form-control py-1" id="inputEmailAddress" type="text" placeholder="Enter price" />
              </div>
            </li>

            <li class="d-flex gap-4">
             <div>
                <h5 class="mb-0">Date</h5>
              <br>
                        <input type="date" class="form-control" name="date" id="exampleInputName" >
                    </div>
                    </li>


            <li class="d-flex gap-4">
            <div class="form-group">
                       <h5 class="mb-0">City</h5>
                        <br>
                        <select class="form-control" name="city" id="exampleInputPassword1">
                        <?php 
                         while($data = mysqli_fetch_assoc($op)){
                        ?>
                            <option value="<?php echo $data['id'];?>"> <?php echo $data['city'];?></option>
                            <?php } ?>
                        </select>
                    </div>

            </li>
          </ul>
          <button type="submit" class="btn btn-lg btn-primary mt-5 w-100" data-bs-dismiss="modal">Order</button>
          </form>
          </div>
       
      </div>
    </div>
  </div>
</main>
</body>

</html>