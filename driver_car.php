<?php 

 # Logic 
 require '../helpers/dbConnection.php';
 require '../helpers/functions.php';

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

    header("Location: driver_car.php");
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



//// Validation not working ......

  if($_SERVER['REQUEST_METHOD'] == "POST"){

    $car_model     = Clean($_POST['car_model']);
    $car_color     = Clean($_POST['car_color']);
    $car_number    = Clean($_POST['car_number']);
    $licence       = Clean($_POST['licence']);
    $city          = Clean($_POST['city']);
    // echo mysqli_error($con);
    // exit;

    $errors = [];
   
    # Car Model Validation ... 
    if(!validate($car_model,1)){
        $errors['Car Model'] = "Field Required";
    }

   
   # Car Color Validation 
   if(!validate($car_color,1)){
    $errors['Car Color'] = "Field Required";
   }elseif(!validate($car_color,6)){
     $errors['Car Color'] = "Must be a Srting";
  }



  # Car Number Validate 
  if(!validate($car_number,1)){
    $errors['Car Number'] = "Field Required";
   }



  # Driver ID Validation .... 
  if(!validate($licence,1)){
    $errors['Licence Number'] = "Field Required";
   }elseif(!validate($licence,5,14)){
     $errors['Licence Number'] = "Invalid Licence Number";
  }


  # City Validation ... 
  if(!validate($city,1)){
    $errors['City'] = "Field Required";
}


    if(count($errors) > 0){
        $_SESSION['Message'] = $errors;
    }else{ 
       
         $sql = "insert into driver_car (car_model,car_number,car_color,licence,city,user_id) values ('$car_model','$car_number','$car_color','$licence','$city','$user_id')";
         $insert_op  = mysqli_query($con,$sql);

         
        //  echo mysqli_error($con);
        //  exit;
         if($insert_op){
             $message = ['Raw Inserted'];
         }else{
             $message = ['Error Try Again'];
         }

 
      }

      $_SESSION['Message'] = $message;
      header("Location: driver_car_index.php");
      exit();
   

    }

  // end form Logic ..... 

 require '../layouts/header.php';
 require '../layouts/nav.php';
 require '../layouts/sidNav.php'; 

?>


<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">

                <?php 
               
               if(isset($_SESSION['Message'])){
                   foreach($_SESSION['Message'] as $key => $val){
                      
                    echo '* '.$key.' : '.$val.'<br>';

                   }
                   unset($_SESSION['Message']);
               }else{  ?>

                <li class="breadcrumb-item active">Driver more Info</li>

                <?php   }   ?>




            </ol>




            <div class="container">

                <form action="driver_car.php?id=<?php echo $data['id'];?>" method="post"  enctype="multipart/form-data">



                    <div class="form-group">
                        <label for="exampleInputName">Car Model</label>
                        <input type="text" class="form-control" name="car_model" id="exampleInputName" aria-describedby=""
                            placeholder="Enter Car Model">
                    </div>



                    <div class="form-group">
                        <label for="exampleInputPassword">Car Color</label>
                        <input type="text" class="form-control" name="car_color" id="exampleInputName" aria-describedby=""
                            placeholder="Enter Car Color">
                    </div>



                    <div class="form-group">
                        <label for="exampleInputPassword">Car Number</label>
                        <input type="text" class="form-control" name="car_number" id="exampleInputPassword1"
                            placeholder="Car Number">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputPassword">Licence Number</label>
                        <input type="number" class="form-control" name="licence" id="exampleInputPassword1"
                            placeholder="Car Number">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputPassword">City</label>
                        <select class="form-control" name="city" id="exampleInputPassword1">
                        <?php 
                         while($data = mysqli_fetch_assoc($op)){
                    ?>
                            <option value="<?php echo $data['id'];?>"> <?php echo $data['city'];?></option>
                            <?php } ?>
                        </select>
                    </div>


                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>





        </div>
    </main>


    <?php 

 require '../layouts/footer.php';

?>
