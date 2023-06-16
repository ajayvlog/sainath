<?php include("../adminsession.php");

//print_r($_SESSION);die;

$pagename = "income_report.php";

$module = "Income Report ";

$submodule = "Income Report";

$btn_name = "Save";

$keyvalue = 0;

$tblname = "expanse";

$tblpkey = "expanse_id";





if (isset($_GET['from_date']) && isset($_GET['to_date'])) {

   $from_date = $obj->dateformatusa($_GET['from_date']);

   $to_date  =  $obj->dateformatusa($_GET['to_date']);
} else {

   $to_date = date('Y-m-d');

   $from_date = date('Y-m-d');
}



$crit = " where type = 'income' and exp_date between '$from_date' and '$to_date'";



if (isset($_GET['ex_group_id'])) {

   $ex_group_id = $_GET['ex_group_id'];

   if ($ex_group_id != '') {

      $crit .= " and ex_group_id = '$ex_group_id' and type='income'";
   }
}



?>

<!DOCTYPE html>

<head>

   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

   <meta name="viewport" content="width=device-width, initial-scale=1.0" />

   <?php include("inc/top_files.php"); ?>

   <script type="text/javascript">
      function exportTableToExcel(tableID, filename = '') {

         var downloadLink;

         var dataType = 'application/vnd.ms-excel';

         var tableSelect = document.getElementById(tableID);

         var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');



         // Specify file name

         filename = filename ? filename + '.xls' : 'excel_data.xls';



         // Create download link element

         downloadLink = document.createElement("a");



         document.body.appendChild(downloadLink);



         if (navigator.msSaveOrOpenBlob) {

            var blob = new Blob(['\ufeff', tableHTML], {

               type: dataType

            });

            navigator.msSaveOrOpenBlob(blob, filename);

         } else {

            // Create a link to the file

            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;



            // Setting the file name

            downloadLink.download = filename;



            //triggering the function

            downloadLink.click();

         }

      }
   </script>

</head>

<body onLoad="getrecord('<?php echo $keyvalue; ?>');">



   <div class="mainwrapper">



      <!-- START OF LEFT PANEL -->

      <?php include("inc/left_menu.php"); ?>

      <!--mainleft-->

      <!-- END OF LEFT PANEL -->

      <!-- START OF RIGHT PANEL -->

      <div class="rightpanel">

         <?php include("inc/header.php"); ?>





         <div class="maincontent">

            <div class="contentinner content-dashboard">

               <form method="get" action="">

                  <table class="table table-bordered table-condensed">

                     <tr>

                        <!-- <th>Vendor</th>

                <th>Party Name</th> -->

                        <th>Income Group:</th>

                        <th>From Date:</th>

                        <th>To Date:</th>

                        <th>&nbsp</th>



                     </tr>

                     <tr>



                        <td><select name="ex_group_id" id="ex_group_id" style="width:285px;" class="chzn-select input-xlarge">

                              <option value="">---Select---</option>

                              <?php

                              $slno = 1;

                              $res = $obj->executequery("select * from m_expanse_group where type='income' order by ex_group_id desc");

                              foreach ($res as $row_get) {

                              ?>

                                 <option value="<?php echo $row_get['ex_group_id']; ?>"> <?php echo ucfirst($row_get['group_name']); ?></option>

                              <?php } ?>

                           </select>

                           <script>
                              document.getElementById('ex_group_id').value = '<?php echo $ex_group_id; ?>';
                           </script>

                        </td>

                        <td><input type="text" name="from_date" id="from_date" class="input-medium" placeholder='dd-mm-yyyy' value="<?php echo $obj->dateformatindia($from_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>



                        <td><input type="text" name="to_date" id="to_date" class="input-medium" placeholder='dd-mm-yyyy' value="<?php echo $obj->dateformatindia($to_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>

                        <td><input type="submit" name="search" class="btn btn-success" value="Search"></td>

                        <td><a href="expanse_report.php" class="btn btn-success">Reset</a></td>

                     </tr>

                  </table>

                  <div>

               </form>

               <br>

               <p align="right" style="margin-top:7px; margin-right:10px;">

                  <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button>

               </p>



               <hr>

               <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>



               <table class="table table-bordered" id="tblData">

                  <thead>

                     <tr>

                        <th>S.No.</th>

                        <th style="text-align: center;">Income Group Name</th>

                        <th style="text-align: center;">Income Name</th>



                        <th style="text-align: center;">Date</th>

                        <th style="text-align: right;">Amount</th>

                        <th style="text-align: center;">Mode</th>





                     </tr>

                  </thead>

                  <tbody id="record">



                     <?php

                     $slno = 1;

                     $totalamt = 0;



                     $sql = "select * from expanse $crit and type='income'";

                     $res = $obj->executequery($sql);

                     foreach ($res as $row_get) {

                        $expanse_id = $row_get['expanse_id'];

                        $ex_group_id = $row_get['ex_group_id'];



                        $gup_name = $obj->getvalfield("m_expanse_group", "group_name", "ex_group_id=$ex_group_id");



                     ?>

                        <tr>



                           <td><?php echo $slno++; ?></td>

                           <td style="text-align: center;"><?php echo $gup_name; ?></td>

                           <td style="text-align: center;"><?php echo $row_get['exp_name']; ?></td>

                           <td style="text-align: center;"><?php echo $obj->dateformatindia($row_get['exp_date']); ?></td>

                           <td style="text-align: right;"><?php echo number_format($row_get['exp_amount'], 2); ?></td>

                           <td style="text-align: center;"><?php echo $row_get['mode']; ?></td>







                        </tr>

                     <?php

                        $totalamt += $row_get['exp_amount'];
                     }

                     ?>

                  </tbody>

                  <tr>

                     <td style="text-align: right;" colspan="6">
                        <h3 class="text-info text-right">Total Amount: <?php echo number_format($totalamt, 2); ?></h3>
                     </td>

                  </tr>

               </table>

               <!-- <div class="well well-sm text"><h3 class="text-info text-right">Total Amount: <?php echo number_format($totalamt, 2); ?></h3></div>  -->

            </div>

         </div>
         <!--contentinner-->

      </div>
      <!--maincontent-->

   </div>

   <!--mainright-->

   <!-- END OF RIGHT PANEL -->



   <div class="clearfix"></div>

   <?php include("inc/footer.php"); ?>

   <!--footer-->



   </div>
   <!--mainwrapper-->



   <script>
      function funDel(id)

      { //alert(id);   

         tblname = '<?php echo $tblname; ?>';

         tblpkey = '<?php echo $tblpkey; ?>';

         pagename = '<?php echo $pagename; ?>';

         submodule = '<?php echo $submodule; ?>';

         module = '<?php echo $module; ?>';

         //alert(module); 

         if (confirm("Are you sure! You want to delete this record."))

         {

            jQuery.ajax({

               type: 'POST',

               url: 'ajax/delete_master.php',

               data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&submodule=' + submodule + '&pagename=' + pagename + '&module=' + module,

               dataType: 'html',

               success: function(data) {

                  // alert(data);

                  location = '<?php echo $pagename . "?action=3"; ?>';

               }



            }); //ajax close

         } //confirm close

      } //fun close



      jQuery('#from_date').mask('99-99-9999', {
         placeholder: "dd-mm-yyyy"
      });

      jQuery('#to_date').mask('99-99-9999', {
         placeholder: "dd-mm-yyyy"
      });

      jQuery('#from_date').focus();



      function deleterecord(saledetail_id)

      {

         tblname = 'saleentry_details';

         tblpkey = 'saledetail_id';

         pagename = '<?php echo $pagename; ?>';

         submodule = '<?php echo $submodule; ?>';

         module = '<?php echo $module; ?>';

         if (confirm("Are you sure! You want to delete this record."))

         {

            jQuery.ajax({

               type: 'POST',

               url: 'ajax/delete_master.php',

               data: 'id=' + saledetail_id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&submodule=' + submodule + '&pagename=' + pagename + '&module=' + module,

               dataType: 'html',

               success: function(data) {

                  // alert(data);

                  getrecord('<?php echo $keyvalue; ?>');

                  setTotalrate();

               }



            }); //ajax close

         } //confirm close



      }













      jQuery('#sale_date').mask('99-99-9999', {
         placeholder: "dd-mm-yyyy"
      });

      jQuery('#vdate').mask('99-99-9999', {
         placeholder: "dd-mm-yyyy"
      });

      jQuery('#sale_date').focus();
   </script>

</body>

</html>