 <style>
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   color: white;
   text-align: center;

}

.grid-container {
  display: grid;
  grid-template-columns: auto auto auto auto auto auto;
  grid-gap: 3px;
  background-color: black;
  padding: 3px;
}

.grid-container > div {
  background-color: rgba(255, 255, 255, 0.8);
  text-align: center;
  padding: 5px 0;
  font-size: 25px;
}
</style>

 <footer class="w3-container w3-padding-4 w3-black footer" style="margin-top: 50px !important;"  >
  <div class="grid-container footer" >
  
  <div class="grid-item w3-black w3-round" style="border: 1px solid #FFFFF0;"><a href="dashboard.php"><center><i class="fa fa-tachometer w3-hover-opacity w3-xlarge" style="width: 17px;"></i></center></a></div>
  <div class="grid-item w3-black w3-round" style="border: 1px solid #FFFFF0;"><a href="expanse_master.php"><i class="fa fa-user w3-hover-opacity w3-xlarge"style="width: 17px;"></i></a></div>  
  <div class="grid-item w3-black w3-round" style="border: 1px solid #FFFFF0;"><a href="vehicle_outentry.php"><i class="fa fa-id-card-o w3-hover-opacity w3-xlarge"style="width: 17px;"></i></a></div>
  <div class="grid-item w3-black w3-round" style="border: 1px solid #FFFFF0;"><a href="customer_master.php"><i class="fa fa-user-o w3-hover-opacity w3-xlarge"style="width: 17px;"></i></a></div>
  <div class="grid-item w3-black w3-round" style="border: 1px solid #FFFFF0;"><a href="search_customer.php"><i class="fa fa-search w3-hover-opacity w3-xlarge"style="width: 17px;"></i></a></div>
  <div class="grid-item w3-black w3-round" style="border: 1px solid #FFFFF0;"><a href="income_master.php"><i class="fa fa-money  w3-hover-opacity w3-xlarge"style="width: 17px;"></i></a></div>

</div>
  </footer>
