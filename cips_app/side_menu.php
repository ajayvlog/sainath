
  <link rel="stylesheet" type="text/css" href="inc/style.css">
  <link href="https://fonts.googleapis.com/css?family=Play&display=swap" rel="stylesheet">
<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;background-image:  url('img/bg3.jpg')" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="w3images/avatar2.png" class="w3-circle w3-margin-right" style="width:46px">
    </div>
    <div class="w3-col s8 w3-bar">
      <span style="color: white;" class="w3-large">Welcome <?php echo $obj->getvalfield("m_employee","emp_name","employee_id='$employee_id'"); ?><strong></strong></span><br>
      <a href="#" class="w3-bar-item w3-button" style="color: white;"><i class="fa fa-envelope"></i></a>
      <a href="#" class="w3-bar-item w3-button" style="color: white;"><i class="fa fa-user"></i></a>
      <a href="#" class="w3-bar-item w3-button" style="color: white;"><i class="fa fa-cog fa-spin"></i></a>
    </div>
  </div>

    <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black w3-round" onclick="w3_close()" style="margin-bottom: 5px" title="close menu"><i class="fa fa-remove fa-spin fa-fw"></i>  Close Menu</a>

    <a href="dashboard.php" class="w3-bar-item w3-button w3-padding w3-dark-grey w3-hover-black w3-round" style="margin-bottom: 5px"><i class="fa fa-users fa-fw"></i>  Dashboard</a>

    <a href="student_attendence_sub.php" class="w3-bar-item w3-button w3-padding w3-dark-grey w3-hover-black w3-round" style="margin-bottom: 5px"><i class="fa fa-bell fa-fw"></i>Student Attendence</a> 

    <!-- <a href="driver_master.php" class="w3-bar-item w3-button w3-padding w3-dark-grey w3-hover-black w3-round" style="margin-bottom: 5px"><i class="fa fa-diamond fa-fw"></i>Driver Master</a> 

    <a href="customer_master.php" class="w3-bar-item w3-button w3-padding w3-dark-grey w3-hover-black w3-round" style="margin-bottom: 5px"><i class="fa fa-users fa-fw"></i>  Customer Master</a>

    <a href="vehicle_outentry.php" class="w3-bar-item w3-button w3-padding w3-dark-grey w3-hover-black w3-round" style="margin-bottom: 5px"><i class="fa fa-bullseye fa-spin fa-fw "></i>  Vehicle Out Entry</a>

    <a href="vehicle_payment.php" class="w3-bar-item w3-button w3-padding w3-dark-grey w3-hover-black"><i class="fa fa-bullseye fa-fw "></i>  Vehicle Payment Entry</a>
    <a href="income_master.php" class="w3-bar-item w3-button w3-padding w3-dark-grey w3-hover-black w3-round" style="margin-bottom: 5px"><i class="fa fa-bullseye fa-spin fa-fw "></i>  Income Master</a>

    <a href="expanse_master.php" class="w3-bar-item w3-button w3-padding w3-dark-grey w3-hover-black w3-round" style="margin-bottom: 5px"><i class="fa fa-bullseye fa-spin fa-fw "></i> Expanse Master</a>

    <a href="search_customer.php" class="w3-bar-item w3-button w3-padding w3-dark-grey w3-hover-black w3-round" style="margin-bottom: 5px"><i class="fa fa-bullseye fa-spin fa-fw "></i>Customer Ledger</a>

    <a href="vehicle_inentry_view.php" class="w3-bar-item w3-button w3-padding w3-dark-grey w3-hover-black w3-round" style="margin-bottom: 5px"><i class="fa fa-bullseye fa-spin fa-fw "></i>Vehicle In Entry View</a> -->

    <!-- <a href="account_report.php" class="w3-bar-item w3-button w3-padding w3-dark-grey w3-hover-black w3-round" style="margin-bottom: 5px"><i class="fa fa-bullseye fa-spin fa-fw "></i> Account Report</a> -->
    
    <a href="index.php" class="w3-bar-item w3-button w3-padding w3-dark-grey w3-hover-black w3-round"><i class="fa fa-lock fa-fw"></i>LOGOUT</a>
    <br><br>
  </div>
</nav>

</body>
</html>