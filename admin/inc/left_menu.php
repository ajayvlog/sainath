<div class="leftpanel">
   <div class="logopanel">

      <h1 style="font-size:18px;">
         <center><a href="index.php">SAINATH</a></center>
      </h1>
   </div>
   <!--logopanel-->

   <div class="datewidget"><span style="font-size:15px"><b>Session <?php echo $obj->getvalfield("m_session", "session_name", "sessionid = '$sessionid'"); ?></b></span></div>

   <div class="searchwidget">
      <form action="" method="post">
         <div class="input-append">
            <input type="text" class="span2 search-query" placeholder="Search here...">
            <button type="submit" class="btn"><span class="icon-search"></span></button>
         </div>
      </form>
   </div>
   <!--searchwidget-->

   <div class="leftmenu">
      <ul class="nav nav-tabs nav-stacked" id="mymenu">
         <li <?php if ($pagename == "index.php") { ?>class="active" <?php } ?>><a href="index.php"><span class="icon-align-justify"></span>Dashboard</a></li>

         <?php

         $master_chk = $obj->checkmenu("Master", $loginid);

         if ($master_chk != '0' || $_SESSION['usertype'] == 'admin') {

         ?>

            <li class="dropdown  <?php if (
                                    $pagename == "user_master.php"
                                    || $pagename == "m_class.php" || $pagename == "m_subject.php" || $pagename == "section_master.php" || $pagename == "fee_setting.php" || $pagename == "college_setting.php" || $pagename == "master_session.php" || $pagename == "document_master.php" || $pagename == "fee_head_master.php" || $pagename == "semester_master.php" || $pagename == "district_master.php" || $pagename == "counselor_master.php" || $pagename == "holiday_master.php"
                                 ) { ?> active <?php } ?>"><a href="#"><span class="icon-pencil"></span> Master </a>
               <ul <?php if ($pagename == "user_master.php" || $pagename == "m_class.php" || $pagename == "m_subject.php" || $pagename == "section_master.php" || $pagename == "fee_setting.php" || $pagename == "college_setting.php" || $pagename == "master_session.php" || $pagename == "document_master.php" || $pagename == "fee_head_master.php" || $pagename == "m_category.php" || $pagename == "semester_master.php"  ||  $pagename == "counselor_master.php" || $pagename == "district_master.php" || $pagename == "holiday_master.php") { ?>style="display: block" <?php } ?>>



                  <?php

                  $chkmenu = $obj->check_menuname("college_setting.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>

                     <li><a href="college_setting.php">College Setting</a></li>

                  <?php }

                  $chkmenu = $obj->check_menuname("master_session.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>

                     <li><a href="master_session.php">Session Year</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("m_class.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>

                     <li><a href="m_class.php">Course Master</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("m_subject.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
                  ?>
                     <li><a href="m_subject.php">Subject Master</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("master_session.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>

                     <li><a href="semester_master.php">Semester / Year Master</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("counselor_master.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>

                     <li><a href="counselor_master.php">Counselor Master</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("m_category.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>

                     <li><a href="m_category.php">Category Master</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("fee_head_master.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>

                     <li><a href="fee_head_master.php">Fee Head Master</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("document_master.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>

                     <li><a href="document_master.php">Document Master</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("section_master.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>

                     <li><a href="section_master.php">Section Master</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("district_master.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="district_master.php">District Master</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("holiday_master.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="holiday_master.php">Holiday Master</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("user_master.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="user_master.php">User Master</a></li>
                  <?php } ?>
               </ul>
            </li>


            <li class="dropdown  <?php if ($pagename == "employee_master.php" || $pagename == "employee_salary.php" || $pagename == "print_empcard.php" || $pagename == "employee_manual_attendence.php" || $pagename == "employee_advance.php" || $pagename == "employee_transaction.php" || $pagename == "employee_attendence_report.php" || $pagename == "employee_salary_report.php") { ?> active <?php } ?>"><a href="#"><span class="icon-pencil"></span>Employee Master</a>
               <ul <?php if ($pagename == "employee_master.php" || $pagename == "employee_salary.php" || $pagename == "employee_manual_attendence.php" || $pagename == "employee_advance.php" || $pagename == "print_empcard.php" || $pagename == "employee_transaction.php" || $pagename == "employee_attendence_report.php" || $pagename == "employee_salary_report.php") { ?>style="display: block" <?php } ?>>
                  <?php

                  $chkmenu = $obj->check_menuname("employee_master.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="employee_master.php">Employee Master</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("employee_salary.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="employee_salary.php">Employee Salary</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("print_empcard.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="print_empcard.php">Print Employee Card</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("employee_manual_attendence.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="employee_manual_attendence.php">Employee Attendence</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("employee_advance.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="employee_advance.php">Employee Advance</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("employee_transaction.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="employee_transaction.php">Employee Transaction</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("employee_attendence_report.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="employee_attendence_report.php">Employee Attendance Report</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("employee_salary_report.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="employee_salary_report.php">Employee Salary Report</a></li>
                  <?php } ?>
               </ul>
            </li>

            <li class="dropdown  <?php if ($pagename == "m_student_reg.php" || $pagename == "online_registration.php" || $pagename == "fee_payment.php" || $pagename == "manual_attendance.php" || $pagename == "print_studentcard.php" || $pagename == "student_subject_master.php" || $pagename == "student_wiseattendence_report.php") { ?> active <?php } ?>"><a href="#"><span class="icon-pencil"></span>Student</a>
               <ul <?php if ($pagename == "m_student_reg.php" || $pagename == "fee_payment.php" || $pagename == "online_registration.php" || $pagename == "manual_attendance.php" || $pagename == "print_studentcard.php" || $pagename == "student_subject_master.php" || $pagename == "student_wiseattendence_report.php") { ?>style="display: block" <?php } ?>>
                  <?php
                  $chkmenu = $obj->check_menuname("m_student_reg.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="m_student_reg.php">Student Registration Master</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("fee_payment.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="fee_payment.php">Fee Payment</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("manual_attendance.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="manual_attendance.php">Manual Attendance</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("print_studentcard.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="print_studentcard.php">Print Student Card</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("student_subject_master.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="student_subject_master.php">Student Subject Master</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("student_wiseattendence_report.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="student_wiseattendence_report.php">Student Wise Attendance Report</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("online_registration.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="online_registration.php">Student Online Registration</a></li>
                  <?php } ?>
               </ul>
            </li>

            <li class="dropdown  <?php if ($pagename == "character_certificate_page.php" || $pagename == "transfer_certificate_page.php" || $pagename == "scholership_form.php") { ?> active <?php } ?>"><a href="#"><span class="icon-pencil"></span>Student Certificates</a>
               <ul <?php if ($pagename == "character_certificate_page.php" || $pagename == "transfer_certificate_page.php" || $pagename == "scholership_form.php" || $pagename == "complication_certificate_page.php" || $pagename == "noduse_certificate_page.php" || $pagename == "student_info_page.php") { ?>style="display: block" <?php } ?>>
                  <?php
                  $chkmenu = $obj->check_menuname("character_certificate_page.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="character_certificate_page.php">Student Character Certificates</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("transfer_certificate_page.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="transfer_certificate_page.php">Student Transfer Certificates</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("scholership_form.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="scholership_form.php">Scholars Registration</a></li>
                  <?php }
                  $chkmenu = $obj->check_menuname("complication_certificate_page.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="complication_certificate_page.php">Completion Certificate</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("noduse_certificate_page.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="noduse_certificate_page.php">No Dues Certificate</a></li>
                  <?php }
                  $chkmenu = $obj->check_menuname("student_info_page.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="student_info_page.php">Student Personal Information</a></li>
                  <?php } ?>

               </ul>
            </li>


            <?php
            $chkmenu = $obj->check_menuname("enquiry_master.php", $loginid);

            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

            ?>
               <li <?php if ($pagename == "enquiry_master.php") { ?>class="active" <?php } ?>><a href="enquiry_master.php"><i class="icon-user"></i>
                     &nbsp;&nbsp;&nbsp;
                     Enquiry Form</a></li>
            <?php }

            $chkmenu = $obj->check_menuname("assign_subjects.php", $loginid);

            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

            ?>


               <li <?php if ($pagename == "assign_subjects.php") { ?>class="active" <?php } ?>><a href="assign_subjects.php"><i class="icon-user"></i>
                     &nbsp;&nbsp;&nbsp;
                     Assign Subjects</a></li>
            <?php }

            $chkmenu = $obj->check_menuname("coursefeesetting.php", $loginid);

            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

            ?>


               <li <?php if ($pagename == "coursefeesetting.php") { ?>class="active" <?php } ?>><a href="coursefeesetting.php"><i class="icon-user"></i>

                     &nbsp;&nbsp;&nbsp;
                     Course Fee Setting</a></li>
            <?php } ?>

            <li class="dropdown  <?php if ($pagename == "time_table.php" || $pagename == "time_table_report.php") { ?> active <?php } ?>"><a href="#"><span class="icon-pencil"></span>Time Table </a>
               <ul <?php if ($pagename == "time_table.php" || $pagename == "time_table_report.php") { ?>style="display: block" <?php } ?>>
                  <?php
                  $chkmenu = $obj->check_menuname("time_table.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="time_table.php">Create Time Table</a></li>

                  <?php }
                  $chkmenu = $obj->check_menuname("time_table_report.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="time_table_report.php">Time Table Report</a></li>
                  <?php } ?>
               </ul>
            </li>
            <li class="dropdown  <?php if ($pagename == "send_sms.php" || $pagename == "send_sms_employee.php" || $pagename == "send_sms_parents.php" || $pagename == "send_sms_enquiry.php") { ?> active <?php } ?>"><a href="#"><span class="icon-pencil"></span>Send SMS</a>
               <ul <?php if ($pagename == "send_sms.php" || $pagename == "send_sms_employee.php" || $pagename == "send_sms_parents.php" || $pagename == "send_sms_enquiry.php") { ?>style="display: block" <?php } ?>>
                  <?php
                  $chkmenu = $obj->check_menuname("send_sms.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="send_sms.php">Send SMS To Student</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("send_sms_employee.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="send_sms_employee.php"> Send SMS To Employee</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("send_sms_parents.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="send_sms_parents.php"> Send SMS To Parents</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("send_sms_enquiry.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="send_sms_enquiry.php"> Send SMS To Enquiry</a></li>
                  <?php } ?>

               </ul>
            </li>

            <li class="dropdown  <?php if ($pagename == "hostel_master.php" || $pagename == "floor_master.php" || $pagename == "room_master.php") { ?> active <?php } ?>"><a href="#"><span class="icon-pencil"></span>Hostel</a>
               <ul <?php if ($pagename == "hostel_master.php" || $pagename == "floor_master.php" || $pagename == "room_master.php") { ?>style="display: block" <?php } ?>>
                  <?php
                  $chkmenu = $obj->check_menuname("hostel_master.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="hostel_master.php">Hostel Master</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("floor_master.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="floor_master.php">Floor Master</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("room_master.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="room_master.php">Room Master</a></li>
                  <?php } ?>
               </ul>
            </li>

            <li class="dropdown  <?php if ($pagename == "expanse_head.php" || $pagename == "income_head.php" || $pagename == "expanse_group_entry.php" || $pagename == "income_group_entry.php" || $pagename == "expanse_report.php" || $pagename == "income_report.php" || $pagename == "cash_book.php" || $pagename == "cash_book_report.php") { ?> active <?php } ?>"><a href="#"><span class="icon-pencil"></span>Account Module</a>
               <ul <?php if ($pagename == "expanse_head.php" || $pagename == "income_head.php" || $pagename == "expanse_group_entry.php" || $pagename == "income_group_entry.php" || $pagename == "expanse_report.php" || $pagename == "income_report.php" || $pagename == "cash_book.php" || $pagename == "cash_book_report.php") { ?>style="display: block" <?php } ?>>
                  <?php
                  $chkmenu = $obj->check_menuname("expanse_head.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="expanse_head.php">Expense Group Master</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("income_head.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="income_head.php">Income Group Master</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("expanse_group_entry.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="expanse_group_entry.php">Expense Entry Master</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("income_group_entry.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="income_group_entry.php">Income Entry Master</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("expanse_report.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="expanse_report.php">Expense Report</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("income_report.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="income_report.php">Income Report</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("cash_book.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="cash_book.php">Cash Book</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("cash_book_report.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="cash_book_report.php">Cash Book Report</a></li>
                  <?php }
                  ?>

               </ul>
            </li>

            <li class="dropdown  <?php if ($pagename == "fee_report.php" || $pagename == "overall_fee_report.php" || $pagename == "student_reg_report.php" || $pagename == "head_wise_fee_report.php" || $pagename == "hostel_list.php" || $pagename == "percentage_of_stu_attend.php" | $pagename == "enquiry_report.php" || $pagename == "student_fee_report.php" || $pagename == "document_report.php" || $pagename == "employee_attendence_report.php" || $pagename == "app_attendence_report.php" || $pagename == "head_wise_fee_report_new.php" || $pagename == "student_head_wise_fee_report_new.php") { ?> active <?php } ?>"><a href="#"><span class="icon-pencil"></span>Report</a>
               <ul <?php if ($pagename == "fee_report.php" || $pagename == "overall_fee_report.php" || $pagename == "student_reg_report.php" || $pagename == "head_wise_fee_report.php"  || $pagename == "hostel_list.php" || $pagename == "percentage_of_stu_attend.php" || $pagename == "enquiry_report.php" || $pagename == "student_fee_report.php" || $pagename == "document_report.php" || $pagename == "employee_attendence_report.php" || $pagename == "app_attendence_report.php" || $pagename == "head_wise_fee_report_new.php" || $pagename == "student_head_wise_fee_report_new.php") { ?>style="display: block" <?php } ?>>
                  <?php
                  $chkmenu = $obj->check_menuname("fee_report.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="fee_report.php">Date Wise Fee Report</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("student_fee_report.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>

                     <li><a href="student_fee_report.php">Student Wise Fee Report</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("overall_fee_report.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>

                     <li><a href="overall_fee_report.php">Over All Fee Report</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("document_report.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>

                     <li><a href="document_report.php">Student Document Report</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("student_reg_report.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>

                     <li><a href="student_reg_report.php">Student Registration Report</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("head_wise_fee_report.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="head_wise_fee_report.php">Head Wise Fee Report</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("head_wise_fee_report_new.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="head_wise_fee_report_new.php">Head Wise Fee Report New</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("student_head_wise_fee_report_new.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="student_head_wise_fee_report_new.php">Student Head Wise Fee Report</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("hostel_list.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="hostel_list.php">Hosteller Report</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("percentage_of_stu_attend.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="percentage_of_stu_attend.php">Percentage Of Student Attendance</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("enquiry_report.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="enquiry_report.php">Enquiry Report</a></li>
                  <?php }

                  $chkmenu = $obj->check_menuname("app_attendence_report.php", $loginid);

                  if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

                  ?>
                     <li><a href="app_attendence_report.php">App Student Attendence Report</a></li>
                  <?php } ?>
               </ul>
            </li>
            <?php
            $chkmenu = $obj->check_menuname("user_privilege.php", $loginid);

            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

            ?>
               <li <?php if ($pagename == "user_privilege.php") { ?>class="active" <?php } ?>><a href="user_privilege.php"><i class="icon-user"></i>
                     &nbsp;&nbsp;&nbsp;
                     User Privilege</a>
               <?php } ?>

            <?php } ?>

               <li <?php if ($pagename == "changepassword.php") { ?>class="active" <?php } ?>><a href="changepassword.php"><i class="icon-user"></i>
                     &nbsp;&nbsp;&nbsp;
                     Change Password</a></li>

      </ul>

   </div>
   <!--leftmenu-->

</div>