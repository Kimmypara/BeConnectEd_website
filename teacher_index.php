

<?php
include "includes/nav.php";
include 'includes/conditions.php'
?>


<style>
<?php include 'css/style.css'; ?>
</style>




<div class="container-fluid">
  <div class="row">

      <div class="col-lg-2 col-md-3 p-0">
          <?php include 'includes/menuteacher.php'; ?>
      </div>
     

 <div class="col-1"></div>
  <div class="col-lg-9 col-md-8">
      <div class="row">  
        <div class="col-12">  
            <div class="form_bg">
             

                           <!--cards-->
         <div class="row gx-2">
         <div class="col-12 col-md-6 col-lg-4 ">
        <div class="card my-2" >
  <a href="plan_schedule_teacher.php"><img src="assets/images/calendar.png" class="card-img-top img_card" alt="calendar link"></a>
    <a  href="plan_schedule_teacher.php" class="button2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar mx-2" viewBox="0 0 16 16">
  <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
</svg>Plan & Schedule</a>
</div>
</div>

  <div class="col-12 col-md-6 col-lg-4">
        <div class="card my-2" >
  <a href="enrolment_teacher.php"><img src="assets/images/enrolment.jpg" class="card-img-top img_card" alt="enrolment link"></a>
    <a  href="enrolment_teacher.php" class="button2 "><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-mortarboard m-1" viewBox="0 0 16 16">
  <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917zM8 8.46 1.758 5.965 8 3.052l6.242 2.913z"/>
  <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466zm-.068 1.873.22-.748 3.496 1.311a.5.5 0 0 0 .352 0l3.496-1.311.22.748L8 12.46z"/>
</svg>Enrolment</a>
</div>
</div>





  <div class="col-12 col-md-6 col-lg-4">
        <div class="card my-2" >
  <a href="teaching_units_teacher.php"><img src="assets/images/assign_lecturer.jpg" class="card-img-top img_card" alt="attendance link"></a>
    <a  href="teaching_units_teacher.php" class="button2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen m-1" viewBox="0 0 16 16">
  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
</svg>Teaching Units</a>
</div>
</div>


  <div class="col-12 col-md-6 col-lg-4">
        <div class="card my-2" >
  <a href="notifications_teacher.php"><img src="assets/images/notifications.jpg" class="card-img-top img_card" alt="notifications link"></a>
    <a  href="notifications_teacher.php" class="button2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell m-1" viewBox="0 0 16 16">
  <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
</svg>Notifications</a>
</div>
</div>


  <div class="col-12 col-md-6 col-lg-4">
        <div class="card my-2" >
  <a href="chats_teacher.php"><img src="assets/images/chats.jpg" class="card-img-top img_card" alt="chats link"></a>
    <a  href="chats_teacher.php" class="button2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-dots m-1" viewBox="0 0 16 16">
  <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
  <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2"/>
</svg>Chats</a>
</div>
</div>


</div>


            </div>
         </div>
         </div>
        </div>

</div>
</div>