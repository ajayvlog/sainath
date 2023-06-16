<?php include("../adminsession.php");
$pagename = "head_wise_fee_report.php";
$module = "Head Wise Fee Report";
$submodule = "HEAD WISE FEE REPORT";
$btn_name = "Update";
$keyvalue = 0;
$tblname = "course_fee_setting";
$tblpkey = "course_fee_set_id";

if(isset($_GET['class_id']))
$class_id = $_GET['class_id'];
else
$class_id = 0;

if(isset($_GET['sem_id']))
$sem_id = $_GET['sem_id'];
else
$sem_id = 0;


// if(isset($_GET['paper_set_id']))
// $keyvalue = $_GET['paper_set_id'];
// else
// $keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$status = "";
$dup = "";
// $choosed=0;





?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
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
                    <form class="stdform stdform2" method="get" action="">
                     <h4 class="widgettitle">Year / Semester Wise Fee Setting</h4>
                            <table class="table table-bordered">
                              <tr>
                                <th>Course Name <span class="text-error">*</span></th>
                                <td>
                                  <select name="class_id" id="class_id" class="chzn-select" >
                                <option value=""> Select</option>
                                <?php
                                $slno=1;
                                $res = $obj->executequery("select * from m_class");
                                foreach($res as $row_get)
                                {   
                                ?>
                                <option value="<?php echo $row_get['class_id'];  ?>"><?php echo $row_get['class_name']; ?></option>
                                <?php } ?>
                                </select>
                                <script>  document.getElementById('class_id').value='<?php echo $class_id; ?>'; </script>
                                </td>
                                <th>Year / Semester<span class="text-error">*</span></th>
                                <td>
                                  <select name="sem_id" id="sem_id" class="chzn-select" >
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
                                <td><input type="submit" name="search" value="Get Details" class="btn btn-primary" onclick="return checkinputmaster('class_id,sem_id');"></td>
                              </tr>
                            </table>
                        </form>
                        
                            <hr>
                            <?php
                           
                            if($class_id > 0 && $sem_id > 0)
                            { ?>
                        <p>     <p align="right" style="margin-top:7px; margin-right:10px;"><a href="pdf_headwise_fee_report.php?&class_id=<?php echo $class_id; ?>&sem_id=<?php echo $sem_id; ?>" class="btn btn-info" target="_blank">
                        <span style="#000; color:#FFF">Print PDF</span></a>

                            </p>
                                <form class="stdform stdform2" method="post" action="">
                                <table class="table table-bordered" >
                                    <tr >
                                        <th>Slno</th>
                                        <th>Course Name</th>
                                        <th style="text-align: right;">Total Fee</th>
                                        <th style="text-align: right;">Pay Fee</th>
                                        <th style="text-align: right;">Balance</th>
                                    </tr> 
                                    <tr>
                                        <?php
                                        $res = $obj->executequery("select * from m_fee_head");
                                        $slno = 1;
                                        $total_pay_all = 0;
                                        $total_fee_all = 0;
                                        $total_balance = 0;
                                        foreach($res as $row_get)
                                        {   
                                            $fee_head_id = $row_get['fee_head_id'];
                                           $sql_head_fee = "select sum(total_fee) as totfee from hostel_fee_setting as A left join class_transfer as B on A.transferid = B.transferid left join m_student_reg as C on C.m_student_reg_id = B.m_student_reg_id  where A.fee_head_id='$fee_head_id' and class_id='$class_id' and sem_id='$sem_id' and B.sessionid = '$sessionid'";
                                          $row_head_fee = $obj->executequery($sql_head_fee);
                                          $totfee = $row_head_fee[0]['totfee'];


                                           $sql_head_pay = "select sum(paid_amt) as totfee from fee_payment as A left join class_transfer as B on A.transferid = B.transferid left join m_student_reg as C on C.m_student_reg_id = B.m_student_reg_id  where A.fee_head_id='$fee_head_id' and class_id='$class_id' and sem_id='$sem_id' and B.sessionid = '$sessionid'"; 
                                          $row_head_pay = $obj->executequery($sql_head_pay);
                                          $totpay = $row_head_pay[0]['totfee'];
                                          
                                          $balance = $totfee - $totpay;
                                          $total_pay_all += $totpay;
                                          $total_fee_all += $totfee;
                                          $total_balance += $balance;
                                        ?>
                                            <tr>
                                                <td><?php echo $slno++; ?></td>
                                                <td><?php echo strtoupper($row_get['fee_head_name']); ?>
                                                </td>

                                                <td style="text-align: right;">
                                                 <?php echo number_format($totfee,2); ?>
                                                </td>
                                                <td style="text-align: right;"><?php echo number_format($totpay,2); ?></td>
                                                <td style="text-align: right;"><?php echo number_format($balance,2); ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                    <tr class="alert-danger">
                                      <td colspan="2"><b>TOTAL</b></td>
                                      <td style="text-align: right;"><b><?php echo number_format($total_fee_all,2); ?></b></td>
                                      <td style="text-align: right;"><b><?php echo number_format($total_pay_all,2); ?></b></td>
                                      <td style="text-align: right;"><b><?php echo number_format($total_balance,2); ?></b></td>
                                    </tr>
                                </table>
                             
                            </p>

                           

                            <?php } ?>
                        </form>
                    </div>
                     </tbody>
                </table>
            </div><!-- contentinner -->
 
       </div> <!--maincontent-->
        
  </div> <!--rightpanel-->
    
    <!-- END OF RIGHT PANEL -->
    <!--footer-->
       
    <!--   footer -->
    <div class="clearfix"></div>
    <?php include("inc/footer.php"); ?>
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
                 // alert(data);
                   location='<?php echo $pagename."?action=3" ; ?>';
                }
                
              });//ajax close
        }//confirm close
    } //fun close
function getid(class_id)
 {
    //var customer_id = document.getElementById('customer_id').value;
    location = 'coursefeesetting.php?class_id='+class_id;
 }
  </script>
</body>
</html>
