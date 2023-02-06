<!DOCTYPE html>
<html lang="en">
<head>
<title>宿舍信息管理系统-学生</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}
.w3-sidebar {
  z-index: 3;
  width: 250px;
  top: 43px;
  bottom: 0;
  height: inherit;
}
table{
        font-family: 微軟正黑體;
        font-size:20px;
        width:700px;
        border:0.5px solid #80CBC4 ;
        text-align:center;
        border-collapse:collapse;
    }
    th{
        background-color:#80CBC4  ;
        padding:15px;
        border:0.5px solid #80CBC4 ;
        color:#fff;
    }
    td{
        border:0.5px solid #80CBC4 ;
        padding:5px;
        color:#455A64;
    }
</style>
</head>
<body>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-theme w3-top w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-right w3-hide-large w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
    <a href="/student" class="w3-bar-item w3-button w3-theme-l1">学生宿舍管理系统</a>
    <a href="/logout" class="w3-bar-item w3-button w3-theme-l1 w3-right">登出系统</a>
  </div>
</div>

<!-- Sidebar -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
    <i class="fa fa-remove"></i>
  </a>
  <h4 class="w3-bar-item"><b>主页</b></h4>
  <a class="w3-bar-item w3-button w3-hover-black" href="/student/dormitory">寝室信息</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="/student/repair">寝室报修</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="/student/late">夜归记录</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="/student/fee">水电费缴纳</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="/student/payment">住宿费缴纳</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="/student/check_in_out">入退宿申请</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="/student/leave_return">假期离校返校信息</a>
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main" style="margin-left:250px">

  <div class="w3-row w3-padding-64">
    <div class="w3-30% w3-container">
      <h1 class="w3-text-teal">夜归记录</h1>
      <h5  style='color:#455A64'>（根据学生宿舍守则，超过23:00回到宿舍则为夜归）</h5>

      <div style="background-color:AliceBlue;">
        <?php
        if($count > 0){
            echo "<br><center><table><tr><th>日期</th><th>夜归时间</th><th>夜归原因</th></tr>";
            foreach ($records as $record) {
                echo "<tr> <td>".date('Y-m-d', strtotime($record->recordtime))."</td><td>".date('H:m:s', strtotime($record->recordtime))."</td><td>".$record->reason."</td></tr>";
            }
            echo "</table>";
        }
        ?>
        <br>
      <center><h4  style='color:#455A64'>{{ date('m') }}月总夜归次数为：{{ $count }}次</h4></center>
    <br>
    <div class="w3-third w3-container">

    </div>




  <!-- Pagination -->
  <footer id="myFooter" style="margin-left">
      <div id="myFooter" style="position: fixed;bottom: 0px;left:250px;">
    <div class="w3-container w3-theme-l2 w3-padding-32">
   <a href="/student" ><h4>返回主页</h4></a>
    </div>

    <div class="w3-container w3-theme-l1">
    </div>
</div>
  </footer>

<!-- END MAIN -->
</div>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidebar.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

// Close the sidebar with the close button
function w3_close() {
  mySidebar.style.display = "none";
  overlayBg.style.display = "none";
}
</script>

</body>
</html>
