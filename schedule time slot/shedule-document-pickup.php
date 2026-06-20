<?php
@session_start();
require'../dbconnection.php'; 
if(!isset($_SESSION['name'])){header('location:../login.php?msg=Please Log In');}else{
$u_name=$_SESSION['name'];
$u_mail=$_SESSION['email'];
$user=$_SESSION['id'];

    if(isset($_GET['id'])){ 
        $trid= $_GET['id'];
        $q="SELECT * FROM `tracks` WHERE `track`='$trid'  ";
        $result=mysqli_query($con,$q);
        $row=mysqli_fetch_assoc($result);
        $sts=$row['status'];
        // if($sts=='Pick Up Scheduled'){
        //    include '../mail.php';
        //      email($tid,'Documents will be collected within  48 hours. Pls Keep your documents ready.   Visit  https://itzeazy.in/profile/my-order.php?id='.$tid);

        //     include '../message.php';
        //     $msg="Hi ".$_SESSION['name'].", Documents will be collected within  48 hours. Pls Keep your documents ready.   Visit ".$tid;
        //     sendsms($msg);
        //   header('location:current-status.php?id='.$row['track']);
        // }
        $id=$row['id'];
        $tid=$row['track'];
    ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require 'assets/include-meta.php'; ?>
    <title>Schedule Documents pickup</title>
    <script>
        //schedule ajax
$(document).ready(function(){
    $(".scheduleForm").on('submit', function (e) { 
       e.preventDefault(); 
        var formData = new FormData(this);

       $.ajax({  
            url:"ajax/aj-schedule-now.php",  
            type: 'POST', 
            data: formData,
            contentType: false,
            processData: false,
              
        success:function(data){           
              if(data == 1){
                sweetAlert("Congratulations !","Schedule Pick Details Updated! Documents will be collected within  48 hours. Pls Keep your documents ready.","success");
                setTimeout(function() {
                    // swal.close()
                   // window.location.reload(1);
                   window.location = "current-status.php?id=<?php echo $tid; ?>";
                }, 1000);
              } 
              else if(data == 0){

                sweetAlert("Error !","PLease Enter Input","error");
                setTimeout(function() {
                    swal.close()
                }, 2000);
              } 
              else if(data == 2){

                sweetAlert("Error !","PLease Select Address Or Fill New address","error");
                setTimeout(function() {
                    swal.close()
                }, 2000);
              }
              else if(data == 3){

                sweetAlert("Error !","All the fields are mandatory PLease fill all fields","error");
                setTimeout(function() {
                    swal.close()
                }, 2000);
              }
              else if(data == 4){

                sweetAlert("Error !","PLease Select Pickup Schedule time","error");
                setTimeout(function() {
                    swal.close()
                }, 2000);
              }
            }  
       });
    });
});


    </script>
  </head>
  <body>
    <div id="main-container">
      <!--------Header start---------->
    <!----sidebar-------> 
  <?php require 'assets/sidebar.php'; ?>
      <!--------Header end---------->
      <div class="main-box-payment">
        <div class="container">
   <?php require 'assets/mobile-menu.php'; ?>
          <div class="welcome_top mobile_doc">
            <div class="logo_mobile-doc">
              <!-- <img src="assets/Images/image 8.png"> -->
            </div>
      <?php require 'assets/nav-mobile.php'; ?>
            <div class="message_box">
              <p>Welcome, <?php echo $u_name; ?>!</p>
            </div>
            <a href="<?php echo $url; ?>">
              <div class="box_right-doc">
                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                  <rect x="0.5" width="24" height="24" fill="url(#pattern0)" />
                  <defs>
                    <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                      <use xlink:href="#image0_492_1731" transform="scale(0.0111111)" />
                    </pattern>
                    <image id="image0_492_1731" width="90" height="90" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABaCAYAAAA4qEECAAAABmJLR0QA/wD/AP+gvaeTAAAFg0lEQVR4nO2dW4hWVRTHf8tLGlpO4YNOEmqkL5GlQQ9pkfYaaBftor2VFIJIpK+9CyFSUI8RlJUGEWRoVnaBIK2mekhJrciy1NQu5Jgz/x72p5R96j5n73P2+c7sH3wMfJy99jp/zqyzZ+2110Amk8lkMplMJpPJNBRL7cC5SBoNzAWuB2YDs4CZwATgis5PgD+BY52f+4E9wF5gAPjMzIbq9fzCNEJoSdOAe4BFwK3A5YEmTwDvAzuAzWZ2MNBe7yLpUkkrJG2XNKTqOC1pm6Tlksanvu/akDRR0mpJBysU93z8IulJSZNS61AZksZKekLS0QQCn8tRSY9LGptal6hIWiDpy7TaduVrSXek1icYSeMlPSNpOK2eF2RY0kZJ46rUorJVh6TpwCbg5qrmiMynwDIz+6YK45UILffruIXwZVrdnADuMrN3YhseFdugpCXAG/SeyACTgK2SlsU2HFVoSY8Am4FeXq9eArwo6eGYRqOFDkmLcSKPjmUzMcPA/Wb2SgxjUYSWtBB4E6j0zZ2AU8CdZrYt1FCw0JKuBXbRmzHZhxPAPDPbF2IkKEZ31p6baK/I4F6QL4eus0Nfhk/hUpptZx6wPsRA6dAhaQGwM8RGjyHgdjPbWWZwKZEkjQF245LzI4mvgLlm9nfRgWVDxxrqF/kUsBbo73zWdb6rk+uAVbXMJOkypUl1ru3iy7oEfhyWNLGobmWe6MeAK0uMC+WFLt89X7sXMBlYWXRQoRgttxW0H5hadKJQzKyrr5JUty/AIWCmmf3lO6DoE72UBCI3kCnAkiIDigq9ouD1baaQFt6hQ9JVwHckSho1LHSASzpd7VvKUOSJvpf2ZOZiMIoC4aOI0IuK+9J6Fvpe6BU65Mq0jgB9ZT0KpYGhA+A4MNmn/Mz3iZ5LQpEbTB9wg8+FvkLPKe9L6/FKRfgKPSvAkbbjpY2v0LMDHGk7Xtr4Cj09wJG2M8PnIl+hY21VnU11WkHOZ7CEndgp1niVqZKOREox/i/VmQrFS7Ee9pnPdx09iCssCaXfzH6KYCcYSVOAGL4MmtlFC4ail4RdhCbtL9aaTvAV+vdI8zUp+xfLl1jagKQDkeLZoFxs7I/mXPF76e/4MBjpnvb7zOsbowdIvOPd0FwHwOdmduPFLvINHd8GOtNmDvhc5Cv0ngBH2o6XNlnocKIK/UWAI23HS5uc+A8jbuK/Y+iDUK9ayLu+h/uL/GW4o6QzbcZbkyLlBv3A9+RygzMMAdPM7JDPxd5PtJn9CEQ/f9fDbPcVGYonlboVGo5UCmlRpshxHy55XisNCx3VFjma2UlgQ1GvYtAtESVXppaC9UVEhnL56GeBX0uMC6VbWjNF2vUI8FwtM8k1FambsylWxU91FmF1Gc1CDgvtYuQV1tR7WMjMTuMOzaTOBdeJgFVlRIaAPUMz+xB4uuz4HmRj2TOGELhZKnds9yPcydI28wkw38xK14LEOHR/De5wZ1tbnB3HxWWvnZTzEVxuYO7U/2LgZKitBnIKWBoqMkSq6zCz94D7cImWtjAMLDez7TGMRSugMbPXgUdxDvY6Q8BKM3s1lsHolUNyLX9eonf7Kg0CD1mkFj9nqKod20LgNXrvBXkcWNIJhVGppPbOXN+4OcDHVdiviN3ATVWIXDmSxsm1o2x6y8wNkmJUy6ZF0nxJA2n17MqApFtS6xMVSWMkrZHrd5Gaw3I9rMek1qUyJE3o3OQPCQT+Wa5Rd5u7mv0XuZbHD0p6S649fFWclrRV0gNK2Hq+ERX4kqYCd+POm9+G++8UIRzDdTB7G9hSZLe6Khoh9L+RKz+bgzv6O6vzmYE7GdYHnOln9Adu3fsbrnR2L67gcAAY8K0gymQymUwmk8lkMpkRzz//IPVlsYOmegAAAABJRU5ErkJggg==" />
                  </defs>
                </svg>
                <span>Book Service</span>
              </div>
            </a>
          </div>
          <div class="myo_heading_head">
            <div class="row ">
              <div class="col-8">
                <h3>Welcome, <?php echo $u_name; ?>!</h3>
              </div>
              <div class="col-4 pt-3">
                <a href="<?php echo $url; ?>">
                  <div class="myorderw">
                    <h4>
                      <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.5 0C4.977 0 0.5 4.477 0.5 10C0.5 15.523 4.977 20 10.5 20C16.023 20 20.5 15.523 20.5 10C20.5 4.477 16.023 0 10.5 0ZM14.5 11H11.5V14C11.5 14.552 11.052 15 10.5 15C9.948 15 9.5 14.552 9.5 14V11H6.5C5.948 11 5.5 10.552 5.5 10C5.5 9.448 5.948 9 6.5 9H9.5V6C9.5 5.448 9.948 5 10.5 5C11.052 5 11.5 5.448 11.5 6V9H14.5C15.052 9 15.5 9.448 15.5 10C15.5 10.552 15.052 11 14.5 11Z" fill="white" />
                      </svg> Book Services
                    </h4>
                  </div>
                </a>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="head_pay_sub head_pay_sub-doc">
                <h3>Schedule Documents pickup</h3>
              </div>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-12 col-6 col-lg-12">
              <div class="bc_box">
                <div class="bc_head">
                  <div class="row">
                    <div class="col-sm-1 col-cus1">
                      <svg width="46" height="32" viewBox="0 0 46 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M41.2419 0.640137H4.76187C2.64313 0.640137 0.921875 2.36139 0.921875 4.48014V27.5201C0.921875 29.6389 2.64313 31.3601 4.76187 31.3601H41.2419C43.3606 31.3601 45.0819 29.6389 45.0819 27.5201V4.48014C45.0819 2.36139 43.3606 0.640137 41.2419 0.640137ZM6.68187 24.6401C6.91438 20.7739 11.8869 21.3364 12.6331 19.3339C12.6931 18.6476 12.6331 18.1676 12.6331 17.5414C12.3219 17.3764 11.4519 16.4951 11.3169 15.5126C11.3169 15.5126 10.6156 15.1789 10.5781 14.1214C10.5556 13.5626 10.9494 13.1651 10.9494 13.1651C10.2181 10.3489 10.5331 7.42764 14.3019 7.36014C15.2431 7.36014 15.9519 7.81389 16.2331 8.31264C18.8544 8.31264 18.1756 11.9689 17.7781 13.1651C17.9244 13.3114 18.1044 13.7164 18.1044 14.2639C18.1044 15.0476 17.3619 15.5126 17.3619 15.5126C17.2231 16.5101 16.5181 17.3351 16.0906 17.5414C16.0906 18.1676 16.0269 18.6476 16.0906 19.3339C16.8369 21.3364 21.8094 20.7739 22.0419 24.6401H6.68187ZM38.3619 21.7601H26.8419C26.3094 21.7601 25.8819 21.3326 25.8819 20.8001C25.8819 20.2676 26.3094 19.8401 26.8419 19.8401H38.3619C38.8944 19.8401 39.3219 20.2676 39.3219 20.8001C39.3219 21.3326 38.8944 21.7601 38.3619 21.7601ZM38.3619 16.9601H26.8419C26.3094 16.9601 25.8819 16.5289 25.8819 16.0001C25.8819 15.4714 26.3094 15.0401 26.8419 15.0401H38.3619C38.8944 15.0401 39.3219 15.4714 39.3219 16.0001C39.3219 16.5289 38.8944 16.9601 38.3619 16.9601ZM38.3619 12.1601H26.8419C26.3094 12.1601 25.8819 11.7289 25.8819 11.2001C25.8819 10.6714 26.3094 10.2401 26.8419 10.2401H38.3619C38.8944 10.2401 39.3219 10.6714 39.3219 11.2001C39.3219 11.7289 38.8944 12.1601 38.3619 12.1601Z" fill="white" />
                      </svg>
                    </div>
                    <div class="col-sm-6 col-cus6">
                      <h5><?php echo ucwords($row['service']);?></h5>
                    </div>
                    <div class="col-sm-5 col-cus5">
                      <div class="doc_oid">
                        <p>Order ID : <strong><?php echo $row['track'];?></strong>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="head_or_timeline" style="">
                  <div class="row">
                    <div class=" col-6 mb-2 mt-2">
                      <span>Status :</span>
                      <strong> <?php echo $row['status'];?></strong>
                    </div>
                    <div class="col-6 mb-2 mt-2">
                      <center>
                        <span>Order Date : </span>
                        <strong><?php echo date('d M, Y h:i:s', strtotime($row['creation_time'])); ?></strong>
                      </center>
                    </div>
                  </div>
                </div>
                <form class="scheduleForm" method="POST"  enctype="multipart/form-data">
                  <input type="hidden" name="tid" value="<?php echo $trid; ?>"/>
                  <input type="hidden" name="pid" value="<?php echo $id; ?>"/>
                  <input type="hidden" name="sales_p" value="<?php echo $row['sales person']; ?>"/>
                  <div class="row cus_trac_add mbl_shww_trc">
                    <div class="col-6">
                      <div class="clndr">
                        <label>Schedule Date</label>
                        <input type="date" class="form-control" name="date" id="date1" format="DD/MM/YYYY" placeholder="DD/MM/YYYY" required />
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="clndr">
                        <label>Schedule Time</label>
                        <div class="custom-select shedule_pick_time showdivtime2">
      
                          <!-- Primary time select (showdivtime2) changes start here -->
<select name="time" class="">
    <option selected disabled>Choose Time</option>
    <option value="9 AM to 10 AM">9 AM to 10 AM</option>
    <option value="10 AM to 11 AM">10 AM to 11 AM</option>
    <option value="11 AM to 12 PM">11 AM to 12 PM</option>
    <option value="12 PM to 1 PM">12 PM to 1 PM</option>
    <option value="1 PM to 2 PM">1 PM to 2 PM</option>
    <option value="2 PM to 3 PM">2 PM to 3 PM</option>
    <option value="3 PM to 4 PM">3 PM to 4 PM</option>
    <option value="4 PM to 5 PM">4 PM to 5 PM</option>
</select>
                        </div>

                        <div class="custom-select shedule_pick_time showdivtime" style="display:none;">
  <select name="time" class="">
    <option selected disabled>Choose Time</option>
    <option value="9 AM to 10 AM">9 AM to 10 AM</option>
    <option value="10 AM to 11 AM">10 AM to 11 AM</option>
    <option value="11 AM to 12 PM">11 AM to 12 PM</option>
  </select>
</div>

<!-- Secondary time select (showdivtime) changes end here -->
                      </div>
                    </div>
                  </div>
                  <div class="row cus_trac_add mbl_shww_trc">
                    <div class="col-12 m-2 mb-3">
                      <strong>Select Delivery Address</strong>
                    </div>
    <?php 
             if(isset($user)){         
                $q="SELECT * FROM `user_address` WHERE `uid`='$user' AND `default_set`=1 ";
                $result=mysqli_query($con,$q);
                $row_count1=mysqli_num_rows($result);
                $row1=mysqli_fetch_assoc($result); 

                if($row_count1>0){

        ?>    
                    <div class="col-6">
                      <input type="radio" name="sel" value="<?php echo $row1['id']; ?>">
                        <div class="box_address mb-3">
                          <ul class="list-unstyled">
                            <li>
                              <strong><?php echo $row1['user_name']; ?></strong>
                            </li>
                            <li><?php echo $row1['address'].' - '.$row1['city'].' , '.$row1['pin_code']; ?></li>
                            <li>Phone Number : <?php echo $row1['mobile']; ?></li>
                          </ul>
                        </div>
                    </div>
            <?php } ?>
                  
    <?php 
    $q2="SELECT * FROM `user_address` WHERE `uid`='$user' AND `default_set`=0 ORDER BY `id` DESC";
        $result2=mysqli_query($con,$q2);
        $row_count2=mysqli_num_rows($result2);
        if($row_count2>0){
            while($row2=mysqli_fetch_assoc($result2)){
     ?>
                    <div class="col-6">
                      <input type="radio" name="sel" value="<?php echo $row2['id']; ?>">
                        <div class="box_address mb-3">
                          <ul class="list-unstyled">
                            <li>
                              <strong><?php echo $row2['user_name']; ?></strong>
                            </li>
                            <li><?php echo $row2['address'].' - '.$row2['city'].' , '.$row2['pin_code']; ?></li>
                            <li>Phone Number : <?php echo $row2['mobile']; ?></li>
                          </ul>
                        </div>
                    </div>
                  <?php }  } ?>
                  </div>              
                  <div class="row">
                    <div class="col-12 hrr">
                      <hr class="hr1">
                      <h1 class="orr">or</h1>
                    </div>
                  </div>
              <?php } ?>
                  <div class="row cus_trac_add mbl_shww_trc">
                    <div class="col-6">
                      <div class="f_t_pckuu">
                        <p>
                          <strong>Name</strong>
                        </p>
                        <input type="text" class="form-control" name="pers" placeholder="Name" />
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="f_t_pckuu">
                        <p>
                          <strong>City</strong>
                        </p>
                        <div class="custom-select shedule_pick">
                          <select class="" name="city">
                            <option selected disabled>Choose City</option>
                            <option value="Delhi">Delhi</option>
                            <option value="Bangalore">Bangalore</option>
                            <option value="Chennai">Chennai</option>
                            <option value="Faridabad">Faridabad</option>
                            <option value="Ghaziabad">Ghaziabad</option>
                            <option value="Gurgaon">Gurgaon</option>
                            <option value="Hyderabad">Hyderabad</option>
                            <option value="Jamshedpur">Jamshedpur</option>
                            <option value="Mumbai">Mumbai</option>
                            <option value="Noida">Noida</option>
                            <option value="Pune">Pune</option>
                            <option value="Ranchi">Ranchi</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="f_t_pckuu">
                        <p>
                          <strong>Phone</strong>
                        </p>
                        <input type="text" class="form-control" name="persmob" placeholder="Enter Phone Number" />
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="f_t_pckuu">
                        <p>
                          <strong>Pin&nbsp;Code</strong>
                          <br>
                        </p>
                        <input type="text" name="pincode" class="form-control" placeholder="Enter Pincode" />
                      </div>
                    </div>
                    <!-- <div class="col-6">
                      <div class="f_t_pckuu">
                        <p>
                          <strong>Address Type</strong>
                        </p>
                        <div class="custom-select">
                          <select class="" name="adr_type">
                            <option selected disabled>Choose address Type</option>
                            <option value="Home">Home</option>
                            <option value="Office">Office</option>                            
                          </select>
                        </div>
                      </div>
                    </div> -->
                    <div class="col-12">
                      <div class="f_t_pckuu">
                        <p>
                          <strong>Address</strong>
                          <br>
                        </p>
                        <!-- <textarea class="form-control" name="addr"> 
                        </textarea> -->
                        <textarea class="form-control" name="addr" placeholder="Enter Address"></textarea>
                      </div>
                    </div>
                    <div class="col-12 mt-3">
                      <div class="form-check">
                        <input class="form-check-input green" type="checkbox" name="save_addr" value="1" id="flexCheckChecked" >
                        <label class="form-check-label" for="flexCheckChecked"> Save Address for future orders </label>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="mb-4 mt-4 t_pckuu">
                        <center>
                          <input type="submit" name="submit" class="cou_dow" value="Schedule">
                        </center>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        <?php //include 'assets/pay-call-appoint.php'; ?>
        </div>
      </div>
    </div>
    </div>
    </div>
    <!------footer--------> 
    <?php include 'assets/footer.php'; ?> 
    <script>
      var x, i, j, l, ll, selElmnt, a, b, c;
      /*look for any elements with the class "custom-select":*/
      x = document.getElementsByClassName("custom-select");
      l = x.length;
      for (i = 0; i < l; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        ll = selElmnt.length;
        /*for each element, create a new DIV that will act as the selected item:*/
        a = document.createElement("DIV");
        a.setAttribute("class", "select-selected");
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x[i].appendChild(a);
        /*for each element, create a new DIV that will contain the option list:*/
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 1; j < ll; j++) {
          /*for each option in the original select element,
          create a new DIV that will act as an option item:*/
          c = document.createElement("DIV");
          c.innerHTML = selElmnt.options[j].innerHTML;
          c.addEventListener("click", function(e) {
            /*when an item is clicked, update the original select box,
            and the selected item:*/
            var y, i, k, s, h, sl, yl;
            s = this.parentNode.parentNode.getElementsByTagName("select")[0];
            sl = s.length;
            h = this.parentNode.previousSibling;
            for (i = 0; i < sl; i++) {
              if (s.options[i].innerHTML == this.innerHTML) {
                s.selectedIndex = i;
                h.innerHTML = this.innerHTML;
                y = this.parentNode.getElementsByClassName("same-as-selected");
                yl = y.length;
                for (k = 0; k < yl; k++) {
                  y[k].removeAttribute("class");
                }
                this.setAttribute("class", "same-as-selected");
                break;
              }
            }
            h.click();
          });
          b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function(e) {
          /*when the select box is clicked, close any other select boxes,
          and open/close the current select box:*/
          e.stopPropagation();
          closeAllSelect(this);
          this.nextSibling.classList.toggle("select-hide");
          this.classList.toggle("select-arrow-active");
        });
      }

      function closeAllSelect(elmnt) {
        /*a function that will close all select boxes in the document,
        except the current select box:*/
        var x, y, i, xl, yl, arrNo = [];
        x = document.getElementsByClassName("select-items");
        y = document.getElementsByClassName("select-selected");
        xl = x.length;
        yl = y.length;
        for (i = 0; i < yl; i++) {
          if (elmnt == y[i]) {
            arrNo.push(i)
          } else {
            y[i].classList.remove("select-arrow-active");
          }
        }
        for (i = 0; i < xl; i++) {
          if (arrNo.indexOf(i)) {
            x[i].classList.add("select-hide");
          }
        }
      }
      /*if the user clicks anywhere outside the select box,
      then close all select boxes:*/
      document.addEventListener("click", closeAllSelect);
    </script>
    <script type="text/javascript">
      const reel = document.querySelector('.tab_reel');
      const tab1 = document.querySelector('.tab1');
      const tab2 = document.querySelector('.tab2');
      const panel1 = document.querySelector('.tab_panel1');
      const panel2 = document.querySelector('.tab_panel2');

      function slideLeft(e) {
        tab2.classList.remove('active');
        this.classList.add('active');
        reel.style.transform = "translateX(0%)"
      }

      function slideRight(e) {
        tab1.classList.remove('active');
        this.classList.add('active');
        reel.style.transform = "translateX(-50%)"
      }
      tab1.addEventListener('click', slideLeft);
      tab2.addEventListener('click', slideRight);
    </script>
    <script>
      $("#filess").change(function() {
        filename = this.files[0].name;
        console.log(filename);
      });
    </script>

<!-----------date Validations scripts-------------->

<!-----------script changes start here-------------->
<script>
  const hour = new Date().getHours();
  var today = new Date();

  // After 5 PM, skip to day after tomorrow
  if (hour >= 17) {
    var dd = today.getDate() + 2;
  } else {
    var dd = today.getDate() + 1;
  }

  // Handle month overflow
  var tempDate = new Date(today.getFullYear(), today.getMonth(), dd);
  var yyyy = tempDate.getFullYear();
  var mm   = String(tempDate.getMonth() + 1).padStart(2, '0');
  var ddStr = String(tempDate.getDate()).padStart(2, '0');

  var minDate = yyyy + '-' + mm + '-' + ddStr;
  document.getElementById("date1").setAttribute("min", minDate);

  // Get all 2nd and 4th Saturdays of a given month/year
  function getAltSaturdays(year, month) {
    let saturdays = [];
    let date = new Date(year, month, 1);
    while (date.getMonth() === month) {
      if (date.getDay() === 6) {
        saturdays.push(new Date(date)); // store full date object
      }
      date.setDate(date.getDate() + 1);
    }
    // Return only 2nd (index 1) and 4th (index 3) Saturdays
    return saturdays.filter((_, index) => index === 1 || index === 3);
  }

  // Check if a given date string (YYYY-MM-DD) is a 2nd or 4th Saturday
  function isAltSaturday(dateStr) {
    var d = new Date(dateStr + 'T00:00:00'); // avoid timezone issues
    var year  = d.getFullYear();
    var month = d.getMonth();
    var altSats = getAltSaturdays(year, month);
    return altSats.some(s => s.getDate() === d.getDate());
  }

  // Block Sunday + 2nd & 4th Saturday on calendar input
  const picker = document.getElementById('date1');
  picker.addEventListener('input', function (e) {
    var day = new Date(this.value + 'T00:00:00').getDay();

    if (day === 0) {
      e.preventDefault();
      this.value = '';
      alert('Sunday ko pickup schedule nahi ho sakti. Kripya doosri date chunein.');
      return;
    }

    if (isAltSaturday(this.value)) {
      e.preventDefault();
      this.value = '';
      alert('2nd aur 4th Saturday ko pickup schedule nahi ho sakti. Kripya doosri date chunein.');
      return;
    }
  });

  // Bangalore time restriction on 2nd/4th Saturday (if today is one)
  var tdy = new Date();
  if (isAltSaturday(tdy.toISOString().split('T')[0])) {
    $(document).on('change', 'select[name="city"]', function () {
      if ($(this).val() === "Bangalore") {
        $(".showdivtime2").hide();
        $(".showdivtime").show();
      } else {
        $(".showdivtime").hide();
        $(".showdivtime2").show();
      }
    });
  }
</script>

<!-----------script changes end here-------------->


  </body>
</html>


<?php } } ?>