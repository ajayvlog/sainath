<?php include("../adminsession.php");
$pagename = "print_studentcard.php";
$module = "Print Student Card";
$submodule = "PRINT STUDENT CARD";
$btn_name = "Save";
$keyvalue =0 ;
//$tblname = "m_class";
//$tblpkey = "class_id";
// if(isset($_GET['class_id']))
// $keyvalue = $_GET['class_id'];
// else
// $keyvalue = 0;
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
                          
                            <th class="head0 nosort">Sno.</th>
                            <th class="head0">Student Name</th>
                            <th class="head0">Email</th>
                            <th class="head0">Mobile</th>
                            <th class="head0">Id Number</th>
                            <th class="head0">Enrollment No.</th>
                            <th class="head0">DOB</th>
                            <th class="head0">Action</th>
                           <!--  <th width="9%" class="head0">Edit</th>
                            <th width="10%" class="head0">Delete</th>  -->
                         </tr>
                    </thead>
                    <tbody>
                           </span>
        <?php
            $slno=1;
            //$res = $obj->fetch_record("m_city");
            $res = $obj->executequery("select * from class_transfer");
            foreach($res as $row_get)
                {
                  $m_student_reg_id = $row_get['m_student_reg_id'];
                  $transferid = $row_get['transferid'];
                  $stu_name = $obj->getvalfield("m_student_reg","stu_name","m_student_reg_id=$m_student_reg_id");
                  $email = $obj->getvalfield("m_student_reg","email","m_student_reg_id=$m_student_reg_id");
                  $mobile = $obj->getvalfield("m_student_reg","mobile","m_student_reg_id=$m_student_reg_id");
                  $enrollment = $obj->getvalfield("m_student_reg","enrollment","m_student_reg_id=$m_student_reg_id");
                  $dob = $obj->getvalfield("m_student_reg","dob","m_student_reg_id=$m_student_reg_id");
                  $imgname = $obj->getvalfield("m_student_reg","imgname","m_student_reg_id=$m_student_reg_id");
                ?>   
                   <tr>
                        <td><?php echo $slno++; ?></td> 
                        <td><?php echo $stu_name; ?></td>
                        <td><?php echo $email; ?></td>
                        <td><?php echo $mobile; ?></td>
                        <td><?php echo $transferid; ?></td>
                        <td><?php echo $enrollment; ?></td>
                        <td><?php echo $obj->dateformatindia($dob); ?></td>
                         <td><a class="btn btn-danger" href="pdf_printcard.php?m_student_reg_id=<?php echo  $m_student_reg_id; ?>" target="_blank" >Print Card</a></td>
                       <!-- <td><a class='icon-edit' title="Edit" href='m_class.php?class_id=<?php echo $row_get['class_id'] ; ?>'></a></td>
                        <td>
                        <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['class_id']; ?>);' style='cursor:pointer'></a>
                        </td> -->
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
         // alert(data);
           location='<?php echo $pagename."?action=3" ; ?>';
        }
        
        });//ajax close
    }//confirm close
  } //fun close

  </script>
</body>
</html>
