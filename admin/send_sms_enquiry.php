<?php include("../adminsession.php");
//include("../lib/smsinfo.php");

$pagename = "send_sms_enquiry.php";
$module = "Send SMS To Enquiry";
$submodule = "Send SMS To Enquiry";
$btn_name = "Search";
$keyvalue =0 ;
if(isset($_POST['sendsms']))
{

  $msg=$_POST['msg'];
    $hiddenid=$_POST['hiddenid'];
  $sentdate = date("Y-m-d H:i:s");
  
  
  $mobarray = explode(",",$hiddenid);
  $contactlist_chunk = array_chunk($mobarray, 1);
  $size=sizeof($mobarray);  

  foreach($contactlist_chunk as $chunkarr)
  {

    $comm_sep_mobiles = rtrim(implode(",",$chunkarr),',');
    //$obj->sendsmsGET($username,$pass,$senderid,$msg,$serverUrl,$comm_sep_mobiles);
    //$obj->send_sms_indor($comm_sep_mobiles,$msg);

  }
  
  echo "<script>alert('Message sent..');</script>";
  echo "<script>location='send_sms_enquiry.php';</script>";
}

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php include("inc/top_files.php"); ?>
<script>
function fetch_card_customer(ctype)
{
  //alert(ctype);
  /*$.ajax({
      //alert(ctype);
      type: 'POST',
      url: 'show_customer_list.php',
      data: 'ctype='+ctype,
      dataType: 'html',
      success: function(data){
       if(data != "")
       {
         alert(data);
        //arr = data.split("|");
        $("#example1").html(data);
       }
      }
    
      });//ajax close*/
  
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      //alert(this.responseText);
      document.getElementById("example1").innerHTML = this.responseText;
    }
  };
  xmlhttp.open("GET", "show_customer_list.php?ctype=" + ctype, true);
  xmlhttp.send();
}


function addids()
{

    strids="";
    var cbs = document.getElementsByTagName('input');
    var len = cbs.length;
    for (var i = 1; i < len; i++)
    {
         if (document.getElementById("chk" + i)!=null)
         {
              if (document.getElementById("chk" + i).checked==true)
              {
                   if(strids=="")
                   strids=strids + document.getElementById("chk" + i).value;
                   else
                   strids=strids + "," + document.getElementById("chk" + i).value;
               }
          }
     }
     document.getElementById("hiddenid").value=strids;
}

function toggle(source)
{

//alert(source);
if(source == true)
{
//alert("hi");
var cbs = document.getElementsByTagName('input');
var cond_yes_or_no = "";
for (var i=0, len = cbs.length; i < len; i++)
{
if (cbs[i].type.toLowerCase() == 'checkbox')
{
cbs[i].checked = true;
}
}
addids();
}
else
{
//alert("hello");
var cbs = document.getElementsByTagName('input');
var cond_yes_or_no = "";
for (var i=0, len = cbs.length; i < len; i++)
{
if (cbs[i].type.toLowerCase() == 'checkbox')
{
cbs[i].checked = false;
}
}
addids();
}
}

</script>
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
         
              <!--widgetcontent--> 
                  
                <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                
                  <div class="span4" style="margin-left:0px;overflow:scroll; height:400px;">
                        
                      <br>
                      <?php
                      $slno = 1;
                      $sql = $obj->executequery("select * from enquiry_master");
                      $total_cust_count = sizeof($sql);
                      ?>
                      <table id="example1" class="table table-bordered table-striped">
                      <tr>
                         <td colspan="4"> <p style="color:#F00;font-weight:bold;" id="total_cust"><?php echo $total_cust_count; ?> Records Found...</p></td>
                      </tr>
                      <tr>
                          <th><input type="checkbox" name="chk0" id="chk0" onClick="toggle(this.checked)" />ALL</th>
                          <th>Sno.</th>
                          <th>Enquiry Name</th>
                          <th>Mobile no.</th>
                      </tr>
                           <?php
                           $count = 1;
                           foreach($sql as $row_get)
                          {
                           ?>
                        <tr>
                          <td><input type="checkbox" name="chk<?php echo $count; ?>" id="chk<?php echo $count; ?>" onClick="addids()" value="<?php echo $row_get['mobile']; ?>"/></td>
                          <td><?php echo $slno++; ?></td>
                          <td><?php echo $row_get['enq_name']; ?></td>
                          <td><?php echo $row_get['mobile']; ?></td>
                        </tr>
                    <?php
                    $count++;
                    }
                    ?>
                    </table>
                    </div>

                    <div class="span6">
                        <h4 class="widgettitle nomargin shadowed">SMS Panel.</h4>
                        <div class="widgetcontent bordered shadowed">
                        <form method="post" action="" enctype="multipart/form-data" >
               
                <table class="table table-bordered table-striped">
                <tr>
                    <td colspan="2"> <span style="color:#C00">Mobile Number(s)</span></td>
                </tr>
                       
                <tr>
                    <td  rowspan="4">
                    <textarea name="hiddenid" id="hiddenid" class="form-control"rows="10" placeholder="Please Check mobile number from the Customer list or enter with mobile number separated by comma. eg. 9770131555,9755920017"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2"><span class="text-blue">Enter Message (max 160 char)</span></td>
                </tr>
                <tr>
                  <td colspan="2"><textarea name="msg" id="msg" rows="5" class="form-control" onKeyPress="check_length(this.form); " onKeyDown="check_length(this.form); " placeholder="Type your message here."></textarea></td> 
                  </tr>
                  <tr> 
                  <td width="40%">&nbsp;&nbsp;&nbsp;<input size=1 value=160 id="charcnt" name=text_num readonly><strong>Char Left</strong></td>                  
                </tr>
                     
                <tr>
                <td>&nbsp;</td>
                <td width="60%"><button type="submit" name="sendsms" id="sendsms" class="btn btn-xs btn-primary"  onClick="return checkinputs(); " >Submit</button>                      &nbsp;
                  <button type="button" name="submit" class="btn btn-xs btn-danger" >Reset</button>
                  </td>           
                </tr>
                    
          </table>
          </form>
                        </div><!--widgetcontent-->
                    </div>
            </div><!--contentinner-->
        </div><!--maincontent-->
    </div><!--rightpanel-->
    
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>
     <?php include("inc/footer.php"); ?>
    <!--footer-->

    
</div><!--mainwrapper-->
  <script>
  function checkinputs()
  {
    if($("#hiddenid").val() == "")
    {
      alert("Please enter mobile numbers");
      $("#hiddenid").focus();
      return false;
    }
    else if($("#msg").val() == "")
    {
      alert("Please Enter Message");
      $("#msg").focus();
      return false;
    }
    
    
  }

  function check_length(my_form)
{
  //alert("hii");
  maxLen = 160; // max number of characters allowed
  if (my_form.msg.value.length >= maxLen) {
// Alert message if maximum limit is reached. 
// If required Alert can be removed. 
var msg = "You have reached your maximum limit of characters allowed";
alert(msg);
  // Reached the Maximum length so trim the textarea
    my_form.msg.value = my_form.msg.value.substring(0,maxLen);
   }
  else{ // Maximum length not reached so update the value of msg counter
    my_form.text_num.value = maxLen - my_form.msg.value.length;}
}

  </script>      

</body>

</html>
