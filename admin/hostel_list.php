<?php include("../adminsession.php");
$pagename = "hostel_list.php";
$module = "HOSTEL LIST";
$submodule = "HOSTEL LIST";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_class";
$tblpkey = "class_id";
// if(isset($_GET['class_id']))
//   $keyvalue = $_GET['class_id'];
// else
//   $keyvalue = 0;
if(isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";

?>
<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include("inc/top_files.php"); ?>
</head>
<body>
  <div class="mainwrapper">

    <!-- START OF LEFT PANEL -->
    <?php include("inc/left_menu.php"); ?>
    
    <!--mainleft-->
    <!-- END OF LEFT PANEL -->
    
    <!-- START OF RIGHT PANEL -->
    
    <div class="rightpanel">
    	<?php include("inc/header.php"); ?>

      <div class="maincontent">
       <div class="contentinner">
        <?php include("../include/alerts.php"); ?>
        <!--widgetcontent-->        
        <div class="widgetcontent  shadowed nopadding">

        </div>

        <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_hostel_record.php" class="btn btn-info" target="_blank">
          <span style="#000; color:#FFF">Print PDF</span></a>


          <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button> 
        </p>


        <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
        <table class="table table-bordered" id="tblData">
          <colgroup>
            <col class="con0" style="align: center; width: 4%" />
            <col class="con1" />
            <col class="con0" />
            <col class="con1" />
            <col class="con0" />
            <col class="con1" />
          </colgroup>
          <thead>
            <tr>
              <th class="head0 nosort">Sno.</th>
              <th class="head0">Stu_Name</th>
              <th class="head0">Biometric_code</th>
              <th class="head0">FatherName</th> 
              <th class="head0">MotherName</th>
              <th class="head0">Mobile</th>
              <th class="head0">Adm_Year</th>
              <th class="head0">Hostel</th> 
              <th class="head0">D.O.B.</th>
              <th class="head0">Par_Mobile</th>
            </tr>
          </thead>
          <tbody>
          </span>
          <?php
          $slno=1;
           
          $res = $obj->executequery("select A.room_id, B.* from transfer_hostel as A left join m_student_reg B on A.m_student_reg_id = B.m_student_reg_id where A.sessionid ='$sessionid'");
          foreach($res as $row_get)
          {
           $m_student_reg_id = $row_get['m_student_reg_id'];
           $transferid = $obj->getvalfield("class_transfer","transferid","m_student_reg_id='$m_student_reg_id'");
           $stu_name  = $row_get['stu_name'];
           $biometric_code = $row_get['biometric_code'];
           $father_name = $row_get['father_name'];

           $room_id = $row_get['room_id'];
           $room_no = $obj->getvalfield("m_room","room_no","room_id='$room_id'");

           $hostel_id = $obj->getvalfield("m_room","hostel_id","room_id='$room_id'");
           $floor_id = $obj->getvalfield("m_room","floor_id","room_id='$room_id'");
           $hostel_name=$obj->getvalfield("m_hostel","hostel_name","hostel_id='$hostel_id'");
           $floor_name=$obj->getvalfield("m_floor","floor_name","floor_id='$floor_id'");

           $mobile = $row_get['mobile'];
           $admission_year = $row_get['admission_year'];
           $dob = $row_get['dob'];
           $mother_name = $row_get['mother_name'];
           $parent_mobile = $row_get['parent_mobile'];

                 //echo "<pre>";
                 //print_r($studentinfo);
                 //die;
                 // $stu_name = $row_get['stu_name'];
                 // $father_name = $row_get['father_name'];
                 // $mobile = $row_get['mobile'];
                 // $admission_year = $row_get['admission_year'];

           ?>   
           <tr>
            <td><?php echo $slno++; ?></td> 
            <td><a class="btn btn-success" onClick="getid('<?php echo $transferid; ?>','<?php echo $stu_name; ?>');" >
            <?php echo $stu_name; ?></a>
            </td>
            <td><?php echo $biometric_code; ?></td>
            <td><?php echo $father_name; ?></td>
            <td><?php echo $mother_name; ?></td>
            <td><?php echo $mobile; ?></td>
            <td><?php echo $admission_year; ?></td>
            <td><?php echo $room_no." / ".$floor_name." / ".$hostel_name; ?></td>
            <td><?php echo $dob; ?></td>
            <td><?php echo $parent_mobile; ?></td>
          </tr>

          <?php
        }
        ?>     
      </tbody>
    </table>


  </div><!--contentinner-->
</div><!--maincontent-->

</div>
<!--mainright-->
<!-- END OF RIGHT PANEL -->

<div class="clearfix"></div>
<?php include("inc/footer.php"); ?>
<!--footer-->


</div><!--mainwrapper-->

   <!-- modal open -->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" class="modal hide fade in" id="hostelfee_model">
            <div class="modal-header alert-info">
              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
             
              <h3 id="stu_name"></h3>
            </div>
            <div class="modal-body">
            <span style="color:#F00;" id="suppler_model_error"></span>
            <table class="table table-condensed table-bordered alert-info">
              <!-- <div id="showhostfee"></div>  -->
              <thead class="bg-info">
                <tr>
                  <th>SNo.</th>
                  <th>Date</th>
                  <th style="text-align: right;">Fee</th>
                </tr>
              </thead>
              <tbody id="showhostfee">
                
              </tbody> 
            </table>
            </div>
           
    </div>
<script>
	function funDel(id)
	{  //alert(id);   
		tblname = '<?php echo $tblname; ?>';
		tblpkey = '<?php echo $tblpkey; ?>';
		pagename = '<?php echo $pagename; ?>';
		submodule = '<?php echo $submodule; ?>';
		module = '<?php echo $module; ?>';
		 //alert(module); 
     if(confirm("Are you sure! You want to delete this record."))
     {
       jQuery.ajax({
         type: 'POST',
         url: 'ajax/delete_master.php',
         data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
         dataType: 'html',
         success: function(data){
				 // alert(data);
        location='<?php echo $pagename."?action=3" ; ?>';
      }

			  });//ajax close
		}//confirm close
	} //fun close

function getid(transferid,stu_name)
{
  //alert(transferid);
  jQuery('#hostelfee_model').modal('show');
  
  jQuery.ajax({
        type: 'POST',
        url: 'ajax_show_hostelfee_details.php',
        data: 'transferid='+transferid,
        dataType: 'html',
        success: function(data){
        //alert(data);
      jQuery('#stu_name').html(stu_name);
      jQuery('#showhostfee').html(data);
      }
    });//ajax close
}

function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
</script>
</body>
</html>
