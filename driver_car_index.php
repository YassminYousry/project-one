<?php 
 
 require '../helpers/dbConnection.php';
 require '../helpers/functions.php';
 
//   $sql = "select driver_car.*, city.id from driver_car inner join city on driver_car.city_one = city.id ";
 $sql = "select * from driver_car ";
 $op  = mysqli_query($con,$sql);

//  echo mysqli_error($con);
//           exit;



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
                $text = "Display Users";
               printMessage($text);
                ?>
            </li> 
            

                        </ol>
                       

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                List Roles
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Car Model</th>
                                                <th>Car Color</th>
                                                <th>Car Number</th>
                                                <th>Licence Number</th>
                                                <th>City</th>
                                                <th>User_id</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Car Model</th>
                                                <th>Car Color</th>
                                                <th>Car Number</th>
                                                <th>Licence Number</th>
                                                <th>City</th>
                                                <th>User_id</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                          
                                        
                             <?php  
                             
                                while($data = mysqli_fetch_assoc($op)){
                             
                             ?>           
                                            <tr>
                                                <td><?php echo $data['id'];?></td>
                                                <td><?php echo $data['car_model'];?></td>
                                                <td><?php echo $data['car_color']?></td>
                                                <td><?php echo $data['car_number']?></td>
                                                <td><?php echo $data['licence']?></td>
                                                <td><?php echo $data['city']?></td>
                                                <td><?php echo $data['user_id']?></td>

                                                <td>
                                                <a href='edit.php?id=<?php echo $data['id'];?>' class='btn btn-primary m-r-1em'>Edit</a>      
                                               </td>
                                            </tr>
                            <?php } ?>             

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
              

<?php 

 require '../layouts/footer.php';

?>