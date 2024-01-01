<div class="tab">
    <button class="tablinks" onclick="open_tab(event, 'Students')" id="defaultOpen">Students</button>
    <button class="tablinks" onclick="open_tab(event, 'Faculty')">Faculty</button>
    <button class="tablinks" onclick="open_tab(event, 'Staff')">Staff</button>
    <button class="tablinks" onclick="open_tab(event, 'Others')">Others</button>
</div>

<!-- Students -->
<div id="Students" class="tabcontent">

    <div class="box">
        <h1>Direction against sexual harassment</h1>
        <p>Direction against sexual harassment given by the honorable high court division</p>
        <a href="../../storage/file/Sexual_Harassement-Bang.pdf" download>Download</a>
    </div>

    <div class="box">
        <h1>Application for Visa extension or renewal letter (Foreign Students)</h1>
        <p>Student Visa Extension Stamford University prescribed application Form</p>
        <a href="../../storage/file/App__for_Recommendation_letter.docx" download>Download</a>
    </div>
    <div class="box">
        <h1>CV or Bio-Data for a Bachelor/ Honor's Program (Foreign Students)</h1>
        <p>CV or Bio-Data for a Bachelor/ Honor's Program (Foreign Students)</p>
        <a href="../../storage/file/CV-for-Bachelor.docx" download>Download</a>
    </div>
    <div class="box">
        <h1>CV or Bio-Data for Master Program (Foreign Students)</h1>
        <p>CV or Bio-Data for Master Program (Foreign Students)</p>
        <a href="../../storage/file/CV-for-Master.docx" download>Download</a>
    </div>
    <div class="box">
        <h1>Course Registration Form</h1>
        <p>Course Registration Form</p>
        <a href="../../storage/file/Course_Registration_Form_Edit_2019.docx" download>Download</a>
    </div>

    <div class="box">
        <h1>Student ID Card Form</h1>
        <p>Student ID Card Form</p>
        <a href="../../storage/file/Student_ID_Card_Form.docx" download>Download</a>
    </div>
</div>



<!-- Faculty -->
<div id="Faculty" class="tabcontent">
    <div class="box">
        <h1>Clearance Form</h1>
        <p>Clearance Form,Stamford University Bangladesh</p>
        <a href="../../storage/file/Clearance_Form_2019.doc" download>Download</a>
    </div>

    <div class="box">
        <h1>Leave Form</h1>
        <p>Leave Application Form,Stamford University Bangladesh</p>
        <a href="../../storage/file/Leave_Form._2019.doc" download>Download</a>
    </div>

    <div class="box">
        <h1>Missing Attendance Form</h1>
        <p>Missing Attendance Form,HUMAN RESOURCES DIVISION,STAMFORD UNIVERSITY BANGLADESH</p>
        <a href="../../storage/file/Missing_Attendance_Form_2019.doc" download>Download</a>
    </div>

    <div class="box">
        <h1>NOC Form</h1>
        <p>No Objection Form,Human Resources Division,STAMFORD UNIVERSITY BANGLADESH</p>
        <a href="../../storage/file/NOC_Form_doc_Faculty.doc" download>Download</a>
    </div>

    <div class="box">
        <h1>Release Letter Form</h1>
        <p>Release Letter Form,Human Resources Division,STAMFORD UNIVERSITY BANGLADESH</p>
        <a href="../../storage/file/Release_Letter_Form.doc" download>Download</a>
    </div>

    <div class="box">
        <h1>Human Resources Requisition Form</h1>
        <p>Human Resources Requisition Form,Human Resources Division,STAMFORD UNIVERSITY BANGLADESH</p>
        <a href="../../storage/file/Requisition_Form_Blank_new_08_02_203.doc" download>Download</a>
    </div>

    <div class="box">
        <h1>Requisition Form-Goods</h1>
        <p>Requisition Form-Goods,Stamford University Bangladesh</p>
        <a href="../../storage/file/Requisition_Form-Goods_2019.doc" download>Download</a>
    </div>

    <div class="box">
        <h1>Study Leave Permission Form</h1>
        <p>Study Leave Permission Form,Human Resources Division,STAMFORD UNIVERSITY BANGLADESH</p>
        <a href="../../storage/file/Study_Leave_Permission_Form.doc" download>Download</a>
    </div>

    <div class="box">
        <h1>Experience Form</h1>
        <p>Experience Form for Employee</p>
        <a href="../../storage/file/Exp_Form_doc_Faculty.doc" download>Download</a>
    </div>

    <div class="box">
        <h1>Application Form for Teaching Position</h1>
        <p>Application Form for Teaching Position,Human Resources Division</p>
        <a href="../../storage/file/FacultyCVNew.doc" download>Download</a>
    </div>

</div>



<!-- Staff -->
<div id="Staff" class="tabcontent">
    <div class="box">
        <h1>Human Resources Requisition Form (Staff)</h1>
        <p>Human Resources Requisition Form (Staff)</p>
        <a href="../../storage/file/Requisition_Form_Blank_new_08_02_204.doc" download>Download</a>
    </div>

    <div class="box">
        <h1>Clearance Form (Staff)</h1>
        <p>Clearance Form (Staff)</p>
        <a href="../../storage/file/Clearance_Form_20192.doc" download>Download</a>
    </div>

    <div class="box">
        <h1>CV for Administrative Staff</h1>
        <p>CV for Administrative Staff</p>
        <a href="../../storage/file/Admin_CV1.doc" download>Download</a>
    </div>

    <div class="box">
        <h1>CV for Supporting Staff</h1>
        <p>CV for Supporting Staff</p>
        <a href="../../storage/file/Supporting_Staff_CV1.doc" download>Download</a>
    </div>
</div>



<!-- Others -->
<div id="Others" class="tabcontent">
    <!-- <div class="box">
            <h1></h1>
            <p></p>
            <a href="" download>Download</a>
        </div> -->
</div>


<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/main';

$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
$host = 'http://' . $_SERVER['HTTP_HOST'];
$hostPath = $host . "/main";
echo "<link rel='stylesheet' href='$hostPath/style/downloads.css'>";
?>