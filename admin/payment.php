<?php include("../adminsession.php");
$pagename = "fee_payment.php";
$module = "Fee Payment";
$submodule = "FEE PAYMENT";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "fee_payment";
$tblpkey = "fee_payid";
//$imgpath = "uploaded/product/";
if(isset($_GET['fee_payid']))
{
  $keyvalue = $_GET['fee_payid'];
}
else
{
  $keyvalue = 0;
  //echo $sessionid;die; 
  $reciept_no = $obj->getcode($tblname,$tblpkey,"sessionid='$sessionid'");
}

if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";

// if(isset($_GET['transferid']))
// $transferid = $_GET['transferid'];
// else
// $transferid = 0;

$status = "";
$transferid = "";
$prev_bal = "";
$pay_date = "";
$paid_amt = "";
$bal_amt = "";
$payment_type = "";

if(isset($_POST['submit']))
{
	//print_r($_POST);die;
	$transferid = $_POST['transferid'];
	$pay_date = $obj->dateformatusa($_POST['pay_date']);
	$paid_amt  = $_POST['paid_amt'];
	$reciept_no = $_POST['reciept_no'];
	$payment_type = $_POST['payment_type'];
	
		
				if($keyvalue == 0)
			  {    
				$form_data = array('transferid'=>$transferid,'pay_date'=>$pay_date,'paid_amt'=>$paid_amt,'reciept_no'=>$reciept_no,'payment_type'=>$payment_type,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'sessionid'=>$sessionid);
        $obj->insert_record($tblname,$form_data);
				$action=1;
				$process = "insert";
				echo "<script>location='$pagename?action=$action'</script>";
			  }
				else
				{
					//update
					$form_data = array('transferid'=>$transferid,'pay_date'=>$pay_date,'paid_amt'=>$paid_amt,'reciept_no'=>$reciept_no,'payment_type'=>$payment_type,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate);
					$where = array($tblpkey=>$keyvalue);
					 $obj->update_record($tblname,$where,$form_data);
					$action=2;
					$process = "updated";
				}
				echo "<script>location='$pagename?action=$action'</script>";

}
if(isset($_GET[$tblpkey]))
{ 

  $btn_name = "Update";
  $where = array($tblpkey=>$keyvalue);
  $sqledit = $obj->select_record($tblname,$where);
  $transferid =  $sqledit['transferid'];
  $pay_date =  $obj->dateformatindia($sqledit['pay_date']);
  $paid_amt =  $sqledit['paid_amt'];
  $reciept_no =  $sqledit['reciept_no'];
  $payment_type =  $sqledit['payment_type'];
}
else
{
		$pay_date = date('d-m-Y');
}
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
                    <form class="stdform stdform2" method="post" action="">
                    
                       <div class="w3-row">
                       <!-- <div class="w3-col s6" align="left"> -->
                        <div class="w3-col s6" align="left">
                        <table class="table table-bordered" align="left" style="width: 50%;padding-right:10px;height: 50vh;"> 
                       <tr> 
                        <th>Select Student<span style="color:#F00;">*</span></th>
                        <td> <select name="transferid" id="transferid"  class="chzn-select" style="width:283px;" onchange="getdetails(this.value);">
                        <option value="">-select-</option>
                        <?php
                        
                        $res = $obj->fetch_record("m_student_reg");
                        foreach($res as $row)
                        {
                        ?> 
                        <option value="<?php echo $row['m_student_reg_id']; ?>"><?php echo $row['fname']." ".$row['lname']; ?></option>
                        <?php
                        }
                        ?>
                        </select>
                        <script>document.getElementById('transferid').value = '<?php echo $transferid; ?>' ;</script></td></tr> 

                        <tr><th>Payment Date<span style="color:#F00;"></span></th>
                        <td><input type="text" name="pay_date" id="pay_date" class="input-xlarge"  value="<?php echo $pay_date; ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask/></td></tr>
                       
                       

                      <tr><th>Reciept No.<span style="color:#F00;">*</span></th>
                      <td> <input type="text" class="input-xlarge" name="reciept_no" id="reciept_no"  value="<?php echo $reciept_no; ?>" data-inputmask="'alias':"placeholder="Reciept Number"/>
                      </td></tr>  

                      <tr>
                       <th>Paid Amount<span style="color:#F00;"></span></th>
                       <td> <input type="text" name="paid_amt" id="paid_amt" value="<?php echo $paid_amt; ?>" class="input-xlarge" placeholder="Paid Amount"/></td></tr>

                        <tr>
                        <th>Payment Type<span style="color:#F00;">*</span></th>
                        <td>
                        <select  class="chzn-select" style="width:283px;" name="payment_type" id="payment_type">
                        <option value="">-select-</option>
                        <option value="cash">Cash</option>
                        <option value="checque">Checque</option>
                        <option value="google_pay">Google Pay</option>
                        <option value="phone_pay">PhonePay</option>
                        </select>
                        <script>document.getElementById('payment_type').value = '<?php echo $payment_type ; ?>' ;</script>
                        </td> 
                        </tr>
                        <tr>
                            <td colspan="2">
                            <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('transferid,pay_date,reciept_no,paid_amt,payment_type');">
                            <?php echo $btn_name; ?></button>

                            <a href="fee_payment.php"  name="reset" id="reset" class="btn btn-success">Reset</a></td>
                        </tr>
                       </table>
                        </form>
                    </div>
                  </div>

                        <div id="showrecord"  >
                        
                        </div>
                    
               <!-- <h4 class="widgettitle"><?php //echo $submodule; ?> List</h4> -->
               <table class="table table-bordered"> 
                    <thead>
                        <tr>
                            <th class="head0 nosort">Sno.</th>
                            <th class="head0">Receipt No</th>
							              <th class="head0">Payment Date</th>
                            <th class="head0">Student Name</th>
                            <th class="head0">Paid Amount</th>
                            <th class="head0">Print</th>
                            <th width="4%" class="head0">Edit</th>
                            <th width="5%" class="head0">Delete</th> 
                         </tr>
                    </thead>
                    <tbody>
                           </span>
			<?php
						//echo "select * from fee_payment order by fee_payid desc";die;
           $slno = 1;
            $res = $obj->executequery("select * from fee_payment order by fee_payid desc");
						foreach($res as $row_get)
                {

                  $fee_payid = $row_get['fee_payid'];
                  $m_student_reg_id = $row_get['transferid'];
                   //$m_student_reg_id = $row_get['m_student_reg_id'];
                   $fname = $obj->getvalfield("m_student_reg","fname","m_student_reg_id=$m_student_reg_id");
                    $lname = $obj->getvalfield("m_student_reg","lname","m_student_reg_id=$m_student_reg_id");
                         
                ?>   
                   <tr>
                        <td><?php echo $slno++; ?></td>
					            	<td><?php echo $row_get['reciept_no']; ?></td>
                        <td><?php echo $obj->dateformatindia($row_get['pay_date']); ?></td>
                        <td><?php echo $fname." ".$lname; ?></td>
                        <td><?php echo number_format($row_get['paid_amt'],2); ?></td>
                        <td><a class="btn btn-danger" href="pdf_fee_slip.php?fee_payid=<?php echo $fee_payid; ?>" target="_blank">Print</a></td>
                       <td><a class='icon-edit' title="Edit" href='fee_payment.php?fee_payid=<?php echo $fee_payid; ?>'></a></td>
                        <td>
                        <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $fee_payid; ?>);' style='cursor:pointer'></a>
                        </td>
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
				 //alert(data);
				   location='<?php echo $pagename."?action=3" ; ?>';
				}
				
			  });//ajax close
		}//confirm close
	} //fun close


jQuery('#pay_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#pay_date').focus();

function getdetails(transferid)
{
  if(transferid !='' || !isNaN(transferid))
  {
  jQuery.ajax({
        type: 'POST',
        url: 'getpaymentdetail.php',
        data: 'transferid='+transferid,
        dataType: 'html',
        success: function(data){
        //alert(data);
        
        jQuery('#showrecord').html(data);
        }
      
        });//ajax close
  }
}
</script>
</body>
</html>
