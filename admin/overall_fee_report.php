<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "overall_fee_report.php";
$module = "Over All Fee Report ";
$submodule = "Over All Fee Report";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "fee_payment";
$tblpkey = "fee_payid";
$crit = " where class_transfer.sessionid='$sessionid'";

if(isset($_GET['class_id']) && $_GET['class_id']!="")
{
  $class_id = trim(addslashes($_GET['class_id']));  
  $crit .=" and m_student_reg.class_id='$class_id' "; 
}
else
{
  $class_id = "";
}

// if(isset($_GET['transferid']) && $_GET['transferid']!="")
// {
  
//   $transferid = trim(addslashes($_GET['transferid']));  
//   $crit .=" and class_transfer.transferid ='$transferid' "; 
// }
// else
// {
//   $transferid = "";
// }

if(isset($_GET['sem_id']) && $_GET['sem_id']!="")
{
  $sem_id = trim(addslashes($_GET['sem_id']));  
  $crit .=" and class_transfer.sem_id='$sem_id' "; 
}

else
{
  $sem_id = "";
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php include("inc/top_files.php"); ?>
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
                
                <th>Class Name:</th>
                <th>Sem/Year Name:</th>
              </tr>
              <tr>
                  
                 
                <td>
                        <select name="class_id" id="class_id"  class="chzn-select" style="width:283px;">
                        <option value="">Select</option>
                        <?php
                        
                        $res = $obj->fetch_record("m_class");
                        foreach($res as $row)
                        {
                        ?> 
                        <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
                        <?php
                        }
                        ?>
                        </select>
                        <script>document.getElementById('class_id').value = '<?php echo $class_id ; ?>' ;</script>
                        </td>  

                         <td>
                                  <select name="sem_id" id="sem_id" class="chzn-select" style="width:283px;">
                                <option value=""> Select</option>
                                <?php
                                $slno=1;
                                $res = $obj->executequery("select * from m_semester");
                                foreach($res as $row_get)
                                {   
                                ?>
                                <option value="<?php echo $row_get['sem_id'];  ?>"><?php echo $row_get['sem_name']; ?></option>
                                <?php } ?>
                                </select>
                                <script>  document.getElementById('sem_id').value='<?php echo $sem_id; ?>'; </script>
                                </td>
                  
                <td><input type="submit" name="search" class="btn btn-success" value="Search">
                 <a href="overall_fee_report.php" class="btn btn-success">Reset</a></td>
              </tr>
            </table>
            <div>
            </form>
            <br>
                <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_overall_fee_report.php?class_id=<?php echo $class_id; ?>&sem_id=<?php echo $sem_id; ?>" class="btn btn-info" target="_blank">
          <span style="#000; color:#FFF">Print PDF</span></a>
              </p>
                <hr>
                <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                
            	<table class="table table-bordered" id="dyntable">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th style="text-align: center;">Student_name</th>
                            <th style="text-align: center;">Biometric_Code</th>
                            <th style="text-align: center;">Class Name</th>
                            <th style="text-align: center;">Sem/Year</th>
                            <th style="text-align: right;">Total_amount</th>
                            <th style="text-align: right;">Paid_amount</th>
                            <th style="text-align: right;">Bal_amount</th>
                           
                            
                        </tr>
                    </thead>
                    <tbody id="record">
                           </span>
                  <?php
                  $slno = 1;
                  $totalfee = 0;
                  $totalpaid = 0;
                  $totalbal = 0;
                   $sql = "select *, stu_name from class_transfer left join m_student_reg on class_transfer.m_student_reg_id = m_student_reg.m_student_reg_id $crit";

                  $res = $obj->executequery($sql);
                  foreach($res as $row_get)
          				 {
                      $transferid = $row_get['transferid'];
                      $stu_name = $row_get['stu_name'];
                      $biometric_code = $row_get['biometric_code'];
                      $sem_id = $row_get['sem_id'];
                      $sem_name = $obj->getvalfield("m_semester","sem_name","sem_id=$sem_id");

                      $class_id = $row_get['class_id'];
                      $class_name=$obj->getvalfield("m_class","class_name","class_id=$class_id");

                      $total_fee = $obj->getvalfield("hostel_fee_setting","sum(total_fee)","transferid='$transferid' and sessionid='$sessionid'");

                      $paid_amt = $obj->getvalfield("fee_payment","sum(paid_amt)"," transferid='$transferid'");

                      $bal_amount = $total_fee - $paid_amt;

					           ?> 
                    <tr>

    <td><?php echo $slno++; ?></td> 
    <td style="text-align: center;"><?php echo $stu_name; ?></td>
    <td style="text-align: center;"><?php echo $biometric_code; ?></td>
    <td style="text-align: center;"><?php echo $class_name; ?></td>
    <td style="text-align: center;"><?php echo $sem_name; ?></td>
    <td style="text-align: right;"><?php echo number_format($total_fee,2); ?></td>
    <td style="text-align: right;"><?php echo number_format($paid_amt,2); ?></td>
    <td style="text-align: right;"><?php echo number_format($bal_amount,2); ?></td>
      
                    </tr>
                            <?php
                               $totalfee += $total_fee;
                               $totalpaid += $paid_amt;
                               $totalbal += $bal_amount;
                            }
                            ?>
                            </tbody>
                            </table>
                              <div class="well well-sm text"><h3 class="text-info text-right">Total Amount: <?php echo number_format($totalfee,2); ?></h3></div>  
                            
                            <div class="well well-sm text"><h3 class="text-info text-right">Total Paid Amt: <?php echo number_format($totalpaid,2); ?></h3></div>  
                            
                            <div class="well well-sm text"><h3 class="text-info text-right">Total Balance Amt: <?php echo number_format($totalbal,2); ?></h3></div>  
                            </div>
                  </div><!--contentinner-->
      			 	 </div><!--maincontent-->
    				</div>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>
     <?php include("inc/footer.php"); ?>
    <!--footer-->

</div><!--mainwrapper-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" class="modal hide fade in" id="myModal_party">
            <div class="modal-header alert-info">
              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
              <h3 id="myModalLabel">ADD New Party</h3>
            </div>
            <div class="modal-body">
            <span style="color:#F00;" id="suppler_model_error"></span>
            <table class="table table-condensed table-bordered">
            <tr> 
            <th>Party Name <span style="color:#F00;"> * </span> </th>
            <th>Party Type<span style="color:#F00;"> * </span> </th>
            </tr>
            <tr>
            <td>
              <input type="text" name="m_customer_name" id="m_customer_name" class="input-xxlarge"  style="width:80%;" autocomplete="off" autofocus/>    
           </td>   
          <td>
                <select name="m_customer_type" id="m_customer_type"  class="chzn-select" style="width:200px;" >
                <option value=""> Select</option>
                <option value="customer">Customer</option>
                <option value="supplier">Supplier</option>
                <option value="both">Both</option>
                </select>
        </td>
          </tr>
            <tr> 
            <th>Mobile No.</th> 
            <th>PAN No.</th>
            </tr>
            <tr>
            <td>
                <input type="text" name="m_mobile" id="m_mobile" maxlength="10" class="input-xxlarge"  style="width:80%;" autocomplete="off" autofocus/>
           </td>
            <td><input type="text" name="m_panno" id="m_panno" class="input-xxlarge"  style="width:80%;" autocomplete="off" autofocus/></td>
            </tr>
            <tr> 
            <th>GSTIN NO<span style="color:#F00;">*</span></th>
            <th>Opening Bal<span style="color:#F00;">*</span></th>
            </tr>
            <tr>
            <td> <input type="text" name="m_gsttinno" id="m_gsttinno" class="input-xxlarge" style="width:80%;" autocomplete="off" autofocus  /></td>
            <td>  
               <input type="text" name="m_openingbal" id="m_openingbal" class="input-xxlarge" style="width:80%;" autocomplete="off" autofocus  />
           </td>
            </tr>
            <tr> 
            <th>Balance Date<span style="color:#F00;">*</span></th>
            <th>Email Id<span style="color:#F00;">*</span></th>
            </tr>
            <tr>
            <td> <input type="text" name="m_open_bal_date" id="m_open_bal_date" class="input-xxlarge" style="width:80%;" autocomplete="off" autofocus  placeholder="dd-mm-yyyy"/></td>
            <td> <input type="email" name="m_email" id="m_email" class="input-xxlarge" style="width:80%;" autofocus autocomplete="off"/></td>
            </tr>
            <tr>
            <th>Address<span style="color:#F00;">*</span></th>
            <th>Term & Conditions<span style="color:#F00;">*</span></th>
            </tr>
            <tr>
            <td> <input type="text" name="m_address" id="m_address" class="input-xxlarge" style="width:80%;" autocomplete="off" autofocus /></td>
            <td><textarea type="text" name="m_term_cond" id="m_term_cond" class="input-xxlarge" autocomplete="off" autofocus style="width:80%;"></textarea></td>
            </tr>
           
            </table>
            </div>
            <div class="modal-footer">
               <button class="btn btn-primary" name="s_save" id="s_save" onClick="save_party_data();">Save</button>
               <button data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
    </div>
<div class="modal fade" id="myModal" role="dialog" aria-hidden="true" style="display:none;" >
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Add New Product</h4>
                    </div>
                        <div class="modal-body">
		<table class="table table-bordered table-condensed">
            <tr>
                <th width="18%">Product Name &nbsp;<span style="color:#F00;">*</span></th>
                <th width="18%">Unit &nbsp;<span style="color:#F00;">*</span></th>                                           
            </tr>
            <tr>
                <td>                                           
                <input class="form-control" name="mproduct_name" id="mproduct_name" value="" autofocus="" type="text" readonly style="z-index:-44;" >
                <input type="hidden" name="mproduct_id" id="mproduct_id"  readonly >                              
                </td>
                <td>                                           
                <input class="form-control" name="munit_name" id="munit_name"  value="" autocomplete="off" autofocus="" type="text" placeholder="Enter Unit" readonly >
                </td>
           </tr>
            <tr>
                  <th>Qty &nbsp;<span style="color:#F00;">*</span></th>
                  <th width="18%">Rate &nbsp;<span style="color:#F00;">*</span></th>
            </tr>
            <tr>  
                <td> 
                <input class="form-control" name="mqty" id="mqty"  value="" autocomplete="off" autofocus="" type="text"  placeholder="Enter Quantity" onChange="settotalupdate();"  > 
                </td>
                <td>                                           
                <input class="form-control" name="mrate" id="mrate"  value="" autocomplete="off" autofocus="" type="text" placeholder="Enter Rate">
                </td>
           </tr>
            <tr>
                <th>CGST &nbsp;<span style="color:#F00;">*</span></th>
                <th width="18%">SGST &nbsp;<span style="color:#F00;">*</span></th>
            </tr>
            <tr>                                                              
                <td> 
                <input class="form-control" name="mcgst" id="mcgst"  value="" autocomplete="off" autofocus="" type="text"  placeholder="Enter CGST" >                            
                </td>
                <td>                                           
                <input class="form-control" name="msgst" id="msgst"  value="" autocomplete="off" autofocus="" type="text" placeholder="Enter SGST">
                </td> 
           </tr>
            <tr>
                <th>IGST &nbsp;<span style="color:#F00;">*</span></th>
                <th width="18%">Total &nbsp;<span style="color:#F00;">*</span></th>
            </tr>
            <tr>                                                               
                <td> 
                <input class="form-control" name="migst" id="migst"  value="" autocomplete="off" autofocus="" type="text"  placeholder="Enter IGST" >                           
                </td>
                <td>                                           
                <input class="form-control" name="mtotal" id="mtotal"  value="" autocomplete="off" autofocus="" type="text" readonly >
                </td>
           </tr>
                        
     </table>
                        </div>
                        <div class="modal-footer clearfix">
                        <input type="hidden" id="m_saledetail_id" value="0" >
                         <input type="submit" class="btn btn-primary" name="submit" value="Add" onClick="updatelist();" id="saveitem" >
                           <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                        </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->

        </div>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" class="modal hide fade in" id="myModal_product">
            <div class="modal-header alert-info">
              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
              <h3 id="myModalLabel">ADD New Product</h3>
            </div>
            <div class="modal-body">
            <span style="color:#F00;" id="suppler_model_error"></span>
            <table class="table table-condensed table-bordered">
            <tr> 
            <th>Branch Name <span style="color:#F00;"> * </span> </th>
            <th>Product Name<span style="color:#F00;"> * </span> </th>
            </tr>
            <tr>
            <td>
                <select name="m_branch_id" id="m_branch_id"  class="chzn-select" style="width:200px;" >
                <option value="" >---Select---</option>
                <?php
                $slno=1;
                $res = $obj->fetch_record("branch_setting");
                foreach($res as $row_get)
                {
                ?> 
                <option value="<?php echo $row_get['branch_id']; ?>"> <?php echo $row_get['branch_name']; ?></option>						                <?php 
                }
                ?>
                </select>
                 <script>document.getElementById('m_branch_id').value = '<?php echo $m_branch_id ; ?>';</script>
           </td>   
          <td><input type="text" name="product_name" id="product_name" class="input-xxlarge"  style="width:80%;" autocomplete="off" autofocus/></td>
          </tr>
            <tr> 
            <th>UOM</th> 
            <th>Product Type</th>
            </tr>
            <tr>
            <td>
                <select  name="unit_name" class="chzn-select" id="unit_name" >
                <option value="">-Select-</option>
                <option value="pcs">PCS</option>
                <option value="ltr">LTR</option>
                </select>
                <script>document.getElementById('unit_name').value = '<?php echo $unit_name ; ?>';</script> 
           </td>
            <td><input type="text" name="product_type" id="product_type" class="input-xxlarge"  style="width:80%;" autocomplete="off" autofocus/></td>
            </tr>
            <tr> 
            <th>Rate Amt<span style="color:#F00;">*</span></th>
            <th>Rate Type<span style="color:#F00;">*</span></th>
            </tr>
            <tr>
            <td> <input type="text" name="rate_amt" id="rate_amt" class="input-xxlarge" style="width:80%;" autocomplete="off" autofocus  /></td>
            <td>  
                <select  name="rate_type" class="chzn-select" id="rate_type" >
                <option value="">-Select-</option>
                <option value="From Company">From Company</option>
                <option value="From Shop">From Shop</option>
                </select>
                <script>document.getElementById('rate_type').value = '<?php echo $rate_type ; ?>';</script>
           </td>
            </tr>
            <tr> 
            <th>Opening Stock<span style="color:#F00;">*</span></th>
            <th>Stock Date<span style="color:#F00;">*</span></th>
            </tr>
            <tr>
            <td> <input type="text" name="opening_stock" id="opening_stock" class="input-xxlarge" style="width:80%;" autocomplete="off" autofocus  /></td>
            <td> <input type="text" name="stock_date" id="stock_date" class="input-xxlarge" style="width:80%;" autofocus autocomplete="off"  placeholder="dd-mm-yyyy"/></td>
            </tr>
            <tr>
            <th>GST<span style="color:#F00;">*</span></th>
            <th>SGST<span style="color:#F00;">*</span></th>
            </tr>
            <tr>
            <td> <input type="text" name="cgst" id="cgst" class="input-xxlarge" style="width:80%;" autocomplete="off" autofocus /></td>
            <td><input type="text" name="sgst" id="sgst" class="input-xxlarge" autocomplete="off" autofocus style="width:80%;"/></td>
            </tr>
            <tr>
            <th colspan="2">IGST<span style="color:#F00;">*</span></th>
            </tr>
            <tr>
            <td><input type="text" name="igst" id="igst" class="input-xxlarge" autocomplete="off" autofocus style="width:80%;"  /></td>
              <td></td>
            </tr> 
            </table>
            </div>
            <div class="modal-footer">
               <button class="btn btn-primary" name="s_save" id="s_save" onClick="save_product_data();">Save</button>
               <button data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
    </div> 
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" class="modal hide fade in" id="voucherModal">
            <div class="modal-header alert-info">
              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
              <h3 id="myModalLabel">Voucher Entry</h3>
            </div>
            <div class="modal-body">
            <span style="color:#F00;" id="suppler_model_error"></span>
            <table class="table table-condensed table-bordered">
              <tr>
              <th colspan="2">Voucher No.<span style="color:#F00;">*</span></th>
              </tr>
              <tr>
                  <td colspan="2"> <input type="text" name="voucherno" id="voucherno" class="input-xxlarge" style="width:90%;" readonly autocomplete="off" autofocus  /></td>     
            </tr>
            <tr> 
            <th>Party Name <span style="color:#F00;"> * </span> </th>
            <th>Date<span style="color:#F00;"> * </span> </th>


            </tr>
            <tr>
            <td><input type="text" name="customer_name" id="customer_name" class="input-xxlarge"  style="width:80%;" autocomplete="off" autofocus/>
                 <input type="hidden" name="customer_id" id="bcustomer_id" />
                 <input type="hidden" name="saleid" id="saleid"/></td>
          <td><input type="text" name="vdate" id="vdate" placeholder="dd-mm-yyyy" class="input-xxlarge"  style="width:80%;" autocomplete="off" autofocus/></td>
          </tr>
            <tr> 
            <th>Payment Type<span style="color:#F00;">*</span></th> 
            <th>Payment Mode</th>
            </tr>
            <tr>
            <td>
                <select  name="paymt_id" class="chzn-select" id="paymt_id" onChange="getsubhead();">
                 <option value="" >---Select---</option>
                <?php
                $slno=1;
                $res = $obj->fetch_record("paymenttype_head");
                foreach($res as $row_get)
                {
                ?> 
                <option value="<?php echo $row_get['paymt_id']; ?>"> <?php echo $row_get['paymt_name']; ?></option>	
				<?php 
                }
                ?>
                </select>
                <script>document.getElementById('paymt_id').value = '<?php echo $paymt_id ; ?>';</script>
           </td>
            <td>
                <select  name="pay_subid" id="pay_subid" >
                <option value="" >---Select---</option>
                <?php
                $slno=1;
                $res = $obj->fetch_record("payment_subhead");
                foreach($res as $row_get)
                {
                ?> 
                <option value="<?php echo $row_get['pay_subid']; ?>"> <?php echo $row_get['pay_subname']; ?></option>			
     			<?php 
                }
                ?>
                </select>
                <script>document.getElementById('pay_subid').value = '<?php echo $pay_subid ; ?>';</script>
         </td>
            </tr>
            <th>Email ID</th>
            <th>Sub Payment Type<span style="color:#F00;">*</span></th>
            </tr>
            <tr>
            <td> <input type="email" name="email" id="email" placeholder="Enter Email" class="input-xxlarge" style="width:80%;" autocomplete="off" autofocus  /></td>
            <td>
                <select name="pay_mode" id="pay_mode" class="chzn-select">
                <option value=""> Select</option>
                <option value="cash">Cash</option>
                <option value="cheque">Cheque</option>
                <option value="neft">NEFT</option>
                <option value="rtgs">RTGS</option>
                <option value="paytm">PAYTM</option>
                </select>
                <script>document.getElementById('pay_mode').value='<?php echo $pay_mode;?>'; </script></span>
          </td>
            </tr>
             <tr> 
            <th>Amount<span style="color:#F00;">*</span></th>
             <th></th>
            </tr>
            <tr>
            <td> <input type="text" name="amount" id="amount" placeholder="Enter Amount" class="input-xxlarge" style="width:80%;" autocomplete="off" autofocus  /></td> 

            <td> </td>          
            </tr>
            </table>
            </div>
            <div class="modal-footer">
               <button class="btn btn-primary" name="s_save" id="s_save" onClick="save_voucher_data();">Save</button>
               <button data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
    </div>
    <?php //include("modal_voucher_entry.php"); ?>
 
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

jQuery('#from_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#to_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#from_date').focus();
	
 function deleterecord(saledetail_id)
  {
	 	tblname = 'saleentry_details';
		tblpkey = 'saledetail_id';
		pagename = '<?php echo $pagename; ?>';
		submodule = '<?php echo $submodule; ?>';
		module = '<?php echo $module; ?>';		
	if(confirm("Are you sure! You want to delete this record."))
		{
			jQuery.ajax({
			  type: 'POST',
			  url: 'ajax/delete_master.php',
			  data: 'id='+saledetail_id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
			  dataType: 'html',
			  success: function(data){
				 // alert(data);
				 getrecord('<?php echo $keyvalue; ?>');
				 setTotalrate();
				}
				
			  });//ajax close
		}//confirm close
	
  }
   
jQuery('#sale_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#vdate').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#sale_date').focus();
</script>
</body>
</html>
