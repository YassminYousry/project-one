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

    header("Location: create.php");
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

    //    echo mysqli_error($con);
    //    exit;

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

 require '../layouts/header.php';
 require '../layouts/nav.php';
 require '../layouts/sidNav.php'; 

?>


<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">

               
            <li class="breadcrumb-item active">
                    <?php
                $text = "ADD NEW ORDER";
               printMessage($text);
                ?>
                </li>

            </ol>


            <div class="container">

                <form action="create.php?id=<?php echo $data['id'];?>" method="post"  enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputName">Pick Up Point</label>
                        <input type="text" class="form-control" name="pick_up_point" id="exampleInputName" aria-describedby=""
                            placeholder="Enter Name">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword">Drop Point</label>
                        <input type="text" class="form-control" name="drop_point" >
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


                    <div class="form-group">
                        <label for="exampleInputName">date</label>
                        <input type="date" class="form-control" name="date" id="exampleInputName" >
                    </div>


                    <div class="form-group">
                        <label for="exampleInputName">Price</label>
                        <input type="text" class="form-control" name="price" id="exampleInputName" >
                    </div>


                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>





        </div>
    </main>


    <?php 

 require '../layouts/footer.php';

?>



