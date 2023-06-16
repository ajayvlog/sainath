<?php include("../adminsession.php");
$pagename = "online_registration.php";
$module = "Online Registration";
$submodule = "ONLINE REGISTRATION";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "online_registration";
$tblpkey = "reg_id";
$dup = "";
$imgpath = "images/image/";
if(isset($_GET['reg_id']))
{
 $keyvalue = $_GET['reg_id'];
}
else
{
  $keyvalue = 0;
}

if(isset($_GET['action']))
{
  $action = $_GET['action'];
}
else
{
  $action = "";
}

?>
<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <script>
    function Numberin(input)
    {
     var num = /[^0-9]/g;
     input.value=input.value.replace(num,"");
    }
  </script>
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
          <form class="stdform stdform2" method="post" action="" enctype="multipart/form-data">
           
                                
            <div>
              <?php echo $dup; ?>
            </div>
            <br>
        
        </form>
      </div>
      <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
      <table class="table table-bordered" id="dyntable">
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
            <th  class="head0 nosort">Sno.</th>
            <th  class="head0">Student Name</th>
             <th class="head0">Admission Session</th>
            <th class="head0">Admission For</th>
            <th class="head0">Admission Date</th>
            <th class="head0">Mobile</th>
            <th class="head0">Father Name</th>
            <th class="head0">Photo</th>
            
            <th class="head0">Action</th>
            <?php $chkdel = $obj->check_delBtn("online_registration.php",$loginid);             

              if($chkdel == 1 || $loginid == 1){  ?>
            <th class="head0">Delete</th>
          <?php } ?>
            <!-- <th width="4%" class="head0">Edit</th> -->
            <!-- <th width="5%" class="head0">Delete</th> --> 
          </tr>
        </thead>
        <tbody>
        </span>
        <?php
        $slno=1;
            //$res = $obj->fetch_record("m_product");

        $res = $obj->executequery("select * from online_registration order by reg_id desc");
        foreach($res as $row_get)
        {
          $reg_id = $row_get['reg_id'];
          $fname = $row_get['fname'];
          $session = $row_get['session'];
          $addmis_for =$row_get['addmis_for'];
          $class_name = $obj->getvalfield("m_class","class_name","class_id=$addmis_for");
          $image =$row_get['image'];
          $tenth_att = $row_get['tenth_att'];
          $twel_att = $row_get['twel_att'];
          $tc_att = $row_get['tc_att'];
          ?>   
          <tr>
            <td><?php echo $slno++; ?></td>
            <td><?php echo $fname; ?></td>
            <td><?php echo $session; ?></td> 
            <td><?php echo $class_name; ?></td>
            <td><?php echo $row_get['addmis_date']; ?></td>
            <td><?php echo $row_get['contact_one']; ?></td>
            <td><?php echo $row_get['father_name']; ?></td>
            <td><img style="width: 60px; height: 60px;" src="../images/image/<?php echo $image; ?>"></td>
            
            <td><a class="btn btn-danger" href="pdf_online_reg.php?reg_id=<?php echo $reg_id; ?>" target="_blank">Print</a></td>
            <!-- <td><a class='icon-edit' title="Edit" href='m_student_reg.php?m_student_reg_id=<?php //echo $row_get['reg_id'] ; ?>'></a></td> -->
            <?php if($chkdel == 1 || $loginid == 1){  ?>
            <td>
              <a class="icon-remove" title="Delete" onclick="funDel(<?php echo $reg_id; ?>);" style='cursor:pointer'></a>
            </td>
            <?php } ?>
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
  { 
    //alert(id);   
    var tblname = '<?php echo $tblname; ?>';
    var tblpkey = '<?php echo $tblpkey; ?>';
    var pagename = '<?php echo $pagename; ?>';
    var submodule = '<?php echo $submodule; ?>';
    var imgpath = '<?php echo $imgpath; ?>';
   module = '<?php echo $module; ?>';
     //alert(module); 
     if(confirm("Are you sure! You want to delete this record."))
     {
      //ajax/delete_image_student_master.php
      jQuery.ajax({
       type: 'POST',
       url: 'ajax/delete_onlinereg.php',
       data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&imgpath='+'&module='+module,
       dataType: 'html',
       success: function(data){
           //alert(data);
           location='<?php echo $pagename."?action=3" ; ?>';
         }

        });//ajax close
    }//confirm close
  } //fun close


  jQuery('#admission_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
  jQuery('#dob').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
  jQuery('#admission_date').focus();

  jQuery(document).ready(function(){
    // Smart Wizard  
    jQuery('#wizard2').smartWizard({onFinish: onFinishCallback});

    function onFinishCallback(){
      alert('Finish Clicked');
    } 
    
    jQuery(".inline").colorbox({inline:true, width: '60%', height: '500px'});
    jQuery('select, input:checkbox').uniform();
  });

  function changetab(pagename)
  {
    //alert('hi');
    location = pagename;
  }
</script>
</body>
</html>
