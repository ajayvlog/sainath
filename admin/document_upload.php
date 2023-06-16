<?php include("../adminsession.php");
$pagename = "document_upload.php";
$module = "Document Upload";
$submodule = "DOCUMENT UPLOAD";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "document_upload";
$tblpkey = "doc_upload_id";
$imgpath = "uploaded/document/";


if(isset($_GET['doc_upload_id']))
$keyvalue = $_GET['doc_upload_id'];
else
$keyvalue = 0;

//echo $_GET['m_student_reg_id'];die;

if(isset($_GET['m_student_reg_id']))
$m_student_reg_id1 = $_GET['m_student_reg_id'];
else
$m_student_reg_id1 = 0;

// if(isset($_GET['doc_upload_id']))
// $doc_upload_id = $_GET['doc_upload_id'];
// else
// $doc_upload_id = 0;

if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";

$status = "";
$dup = "";
if(isset($_POST['submit']))
{ //print_r($_FILES); die;
  
   $m_student_reg_id = $_POST['m_student_reg_id'];
   $document_id = $_POST['document_id'];
   $imgname = $_FILES['imgname'];
  

  //   //check Duplicate
  $cwhere = array('m_student_reg_id'=>$_POST['m_student_reg_id'],'document_id'=>$_POST['document_id']);
  $count = $obj->count_method("document_upload",$cwhere);
      if($count > 0 && $keyvalue == 0 )
      {
      /*$dup = " Error : Duplicate Record";*/
      $dup="<div class='alert alert-danger'>
      <strong>Error!</strong> Error : Duplicate Record.
      </div>";
      } 
      
    else{
      //insert
        if($keyvalue == 0)
        {    
        $form_data = array('m_student_reg_id'=>$m_student_reg_id,'document_id'=>$document_id,'ipaddress'=>$ipaddress,'createdate'=>$createdate);
        // $obj->insert_record($tblname,$form_data); 

        $keyvalue = $obj->insert_record_lastid($tblname,$form_data);
         $uploaded_filename = $obj->uploadImage($imgpath,$imgname);
         //print_r($uploaded_filename);
         $form_data1 = array('imgname'=>$uploaded_filename);
         $where = array($tblpkey=>$keyvalue);
          $obj->update_record($tblname,$where,$form_data1);
        //print_r($form_data); die;
        $action=1;
        $process = "insert";
        echo "<script>location='$pagename?action=$action&m_student_reg_id=$m_student_reg_id1'</script>";
        }
  
         else{
        //update
        $form_data = array('m_student_reg_id'=>$m_student_reg_id,'document_id'=>$document_id,'imgname'=>$imgname,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate);
        $where = array($tblpkey=>$keyvalue);
        $keyvalue = $obj->update_record($tblname,$where,$form_data);
        $action=2;
        $process = "updated";
          
               }
    echo "<script>location='$pagename?action=$action'</script>";
    }
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
          <div class="contentinner">
              <?php include("../include/alerts.php"); ?>
              <!--widgetcontent-->        
                <form class="stdform" method="post" enctype="multipart/form-data">
                  <div id="wizard2" class="wizard tabbedwizard">

                  <?php include("inc/tabmenu.php");?>
                  <div class="stepContainer">
                  <h4>Step 4: Document Upload</h4>
                  <?php echo $dup; ?>
                  <div id="new2">
                  <div class="row-fluid">

                  </div>
                            <br>
                             <!--span8-->
                    <div >
                   <div class="alert alert-success">
                     <table class="table table-bordered table-condensed">
                     <tr style="font-weight:bold;">
                      <td>Student Name </td> 
                      <td>Document Name </td>
                      <td>Choose Document</td>
                      <td></td>
                     </tr>
                     <tr>
                        <td>
                        <select name="m_student_reg_id" id="m_student_reg_id" style="width:180px;" class="chzn-select" onchange="getid(this.value);">
                        <option value="">--Select--</option>
                        <?php
                        $res = $obj->executequery("select * from class_transfer where sessionid=$sessionid");
                        foreach($res as $row)
                        {
                          $m_student_reg_id = $row['m_student_reg_id'];
                          $stu_name = $obj->getvalfield("m_student_reg","stu_name","m_student_reg_id=$m_student_reg_id");
                          $class_id = $obj->getvalfield("m_student_reg","class_id","m_student_reg_id=$m_student_reg_id");
                          $class_name = $obj->getvalfield("m_class","class_name","class_id=$class_id");
                        ?>
                        <option value="<?php echo $m_student_reg_id; ?>"><?php echo $stu_name." / ".$class_name; ?></option>
                        <?php
                        }
                        ?>
                        </select>
                        <script> document.getElementById('m_student_reg_id').value='<?php echo $m_student_reg_id1; ?>'; </script>    
                        </td>
                        <td>
                        <select name="document_id" id="document_id" style="width:180px;">
                        <option value="">--Select--</option>
                        <?php
                        $res = $obj->executequery("select * from m_document");
                        foreach($res as $row)
                        {
                        ?>
                        <option value="<?php echo $row['document_id']; ?>"><?php echo $row['document_name']; ?></option>
                        <?php
                        }
                        ?>
                        </select>
                        <script> document.getElementById('document_id').value='<?php echo $document_id;?>'; </script>   
                        </td>  
                              
                        <td>
                          <input type="file" name="imgname" id="imgname">
                        </td>   
                            
                          <td>
                           <input type="submit" name="submit" id="submit" class="btn btn-primary" value="SUBMIT" style="width:90%;" onchange="addlist();">
                          </td>
                      </tr>
                    </table>
                      </div>
                    </div>
                  <!--span4-->
                  <br>
                     
               
                <!--row-fluid-->
                 
                
                </div>
                          <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
               <table class="table table-bordered">
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
                            <th class="head0">Document Name</th>
                            
                           
                            <th class="head0">Download</th>
                            <?php  $chkdel = $obj->check_delBtn("document_upload.php",$loginid);
                            if($chkdel == 1 || $loginid == 1){  ?>
                            <th width="5%" class="head0">Delete</th>
                            <?php } ?>  
                         </tr>
                    </thead>
                    <tbody>
                           </span>
        <?php
            $slno=1;
            $res = $obj->executequery("select * from document_upload where m_student_reg_id = $m_student_reg_id1");
            foreach($res as $row_get)
                {
                     $stu_name = $obj->getvalfield("m_student_reg","stu_name","m_student_reg_id = '$row_get[m_student_reg_id];'");  
                     $doc_name = $obj->getvalfield("m_document","document_name","document_id = '$row_get[document_id];'");  
                ?>   
                   <tr>
                        <td><?php echo $slno++; ?></td>
                        <td><?php echo $stu_name; ?></td>
                        <td><?php echo $doc_name; ?></td>
                       
                        
                        <td><a class="btn btn-danger" href="uploaded/document/<?php echo $row_get['imgname']; ?>" target="_blank">Download</a></td>
                        <?php   if($chkdel == 1 || $loginid == 1){  ?>
                        <td>
                        <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['doc_upload_id']; ?>);' style='cursor:pointer'></a>
                        </td>
                      <?php } ?>
                </tr>
                
                <?php
                }
                ?>     
                    </tbody>
                </table>
                            
                        </div><!--#wiz1step2_1-->
                        
                      
                    </div><!--#wizard-->
                    </form>
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
    imgpath = '<?php echo $imgpath; ?>';
    module = '<?php echo $module; ?>';
    // alert(imgpath); 
    if(confirm("Are you sure! You want to delete this record."))
    {
      jQuery.ajax({
        type: 'POST',
        url: 'ajax/delete_image_master.php',
        data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module+'&imgpath='+imgpath,
        dataType: 'html',
        success: function(data){
          //alert(data);
           location='<?php echo $pagename."?action=3" ; ?>';
        }
        
        });//ajax close
    }//confirm close
  } //fun close


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

function getid(m_student_reg_id)
  { 
    var $url = 'document_upload.php?m_student_reg_id='+m_student_reg_id;
   
    location = $url
    
  }
  </script>
</body>
</html>
