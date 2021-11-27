<?php

require './layouts/header.php';

?>
    <!-- about section start -->
    <div class="row about1">
        <div class="col aboutimg"> <img src="./img/bg.jpg" alt="" > </div>
        <div class="col abouttext">
            <h1>ABOUT US</h1>
            <p>welcome to our application , Our application is a simple application to order
                  a car to take you to the place you want with the price you want .
                YOU can easily order a trip by the order page , just put the pick up point 
                and the drop point , wish you nice trip .
            </p>
            <div class="">
            <button type="button" class="btn btn-lg  btn btn-outline-light px-4 py-2 mb-5
                w-25 mx-5 " ><a href="http://localhost/group8/taxi_driver/display/registerdriver.php" class="text-dark fs-4 fw-bold">Driver</a></button>
            <button type="button" class="btn btn-lg  btn btn-outline-light px-5 py-2 mb-5
                 w-25 mx-5 " ><a href="http://localhost/group8/taxi_driver/display/userregister.php"  class="text-dark fs-4 fw-bold ">User</a></button>

</div>
        </div>
    </div>

    <?php 

 require './layouts/footer.php';

?>