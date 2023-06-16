<?php include("../adminsession.php");
$pagename = "app_user_privilage.php";
$module = "Master";
$submodule = "App User Privilage Master";
$btn_name = "Assign Previllege";
$keyvalue =0 ;
$tblname = "app_user_previlleg";
$tblpkey = "previd";

if(isset($_GET['userid']))
$userid = $_GET['userid'];
else
$userid ='';

if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";


$production = "";
$dispatch = "";
$dispatch_return = "";
$delivery = "";
$delivery_return = "";


if(isset($_POST['assign']))
{
  //print_r($_POST);die;
  $userid = $_POST['userid']; 
  if(isset($_POST['production']))
  $production = $_POST['production']; 

  if(isset($_POST['dispatch']))
  $dispatch = $_POST['dispatch']; 

  if(isset($_POST['dispatch_return']))
  $dispatch_return = $_POST['dispatch_return']; 

  if(isset($_POST['delivery']))
  $delivery = $_POST['delivery']; 

  if(isset($_POST['delivery_return']))
  $delivery_return = $_POST['delivery_return']; 

  if($userid != '')
  {
         
      $where = array('userid'=>$userid);
      $obj->delete_record($tblname,$where);

      $form_data = array('userid'=>$userid,'production'=>$production,'dispatch'=>$dispatch,'dispatch_return'=>$dispatch_return,'delivery'=>$delivery,'delivery_return'=>$delivery_return);
      $sql = $obj->insert_record($tblname,$form_data);
      $action=1;
      $process = "insert";
        
  }
  echo "<script>location='$pagename?userid=$userid&action=$action'</script>";
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
                      <p>      
                 
                     <label>Select User :<span class="text-error">*</span></label>
                                <span class="formwrapper">
                              <select data-placeholder="Select User Type" class="chzn-select" name="userid" id="userid" onChange="getusertype(this.value);">
                                  <option value="">-Select User Type-</option>
                                  <?php
                                  
                              $res = $obj->executequery("select * from user where logintype = 'appuser'");

                              foreach($res as $row_get)
                              {
                                $fullname = $row_get['fullname'];
                              ?>
                              <option value="<?php echo $row_get['userid']; ?>"><?php echo $row_get['fullname']; ?></option> 
                              <?php
                              }                 
                              ?>
                                </select>
                            </span>
                         <hr>
                          <script>document.getElementById('userid').value='<?php echo $userid; ?>'; </script> 
                             
                           </p>
                           <?php 
                           if($userid !="")
                           {
                         		$production = $obj->getvalfield("app_user_previlleg","production","userid=$userid");
                         		$dispatch = $obj->getvalfield("app_user_previlleg","dispatch","userid=$userid");
                         		$dispatch_return = $obj->getvalfield("app_user_previlleg","dispatch_return","userid=$userid");
                         		$delivery_return = $obj->getvalfield("app_user_previlleg","delivery_return","userid=$userid");
                         		$delivery = $obj->getvalfield("app_user_previlleg","delivery","userid=$userid");

                            ?>
                    <div class="span12" style="width:100%">
                   <!-- <h4 class="widgettitle">Master Entry</h4>-->
                    
                    <table class="table table-condensed table-hover table-invoice">
                     
                       <tr>
                      
                         <td><label> <input type="checkbox" value="1" name="production" <?php if($production =='1') { ?> checked <?php } ?> /> <span style="color:#00F">Production</span>
                          </label></td>
                       </tr>
                       <tr>
                         <td><label> <input type="checkbox" value="1" name="dispatch" <?php if($dispatch =='1') { ?> checked <?php } ?> /> <span style="color:#00F">Dispatch</span>
                         </label></td>
                       </tr>
                       <tr>
                         <td><label> 
                          <input type="checkbox" value="1" name="dispatch_return"   <?php if($dispatch_return =='1') { ?> checked <?php } ?> /> <span style="color:#00F">Dispatch Return</span>
                         </label></td>
                       </tr>
                       <tr>
                         <td><label> <input type="checkbox" value="1" name="delivery" <?php if($delivery =='1') { ?> checked <?php } ?> /> <span style="color:#00F">Delivery</span>
                         </label></td>
                       </tr>
                       <tr>
                         <td><label> <input type="checkbox" value="1" name="delivery_return"  <?php if($delivery_return =='1') { ?> checked <?php } ?> /> <span style="color:#00F">Delivery Return</span></label></td>
                        </tr>
                      <tr>
                        <td style="text-align: center;"><input type="submit" class="btn btn-primary"  value="<?php echo $btn_name; ?>" name="assign">
                        <!-- <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a> --></td>
                      </tr>
                    </table>
                        </form>
                </div>
              <?php } ?>
              </div>
            </div><!--contentinner-->
        </div><!--maincontent-->
    </div>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>
    <!--  <?php include("inc/footer.php"); ?> -->
    <!--footer-->
<!--mainwrapper-->
<script>
function getusertype(userid)
{
    window.location.href='?userid='+userid;
}

</script>
</body>
</html>
