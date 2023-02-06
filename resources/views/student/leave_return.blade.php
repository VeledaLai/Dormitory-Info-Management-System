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
button.submit{
               border: none;
               outline: none;
               background-color: #0097A7;
               color: white;
               padding: 12px 16px;
               cursor: pointer;
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
<form action="/student/leave_return" method="POST">
    @csrf
  <div class="w3-row w3-padding-64">
    <div class="w3-thirdfour w3-container">
      <h1 class="w3-text-teal">假期离校返校信息登记</h1>
      <div style="background-color:AliceBlue;">
        <br>
        <br>
        @php
        if( $operation ){
            echo "<center><h2 style='color:#00838F;'>假期离校登记</h2></center>".
                 "<br><center><input style='color:#455A64' type='date' id='leaveday' name='leaveday' value='".date("Y-m-d")."'>";
            echo "<button style='margin-left:20px' type='submit' class='submit'>确认登记</button></center>";
        }
        else{
            echo "<center><h2 style='color:#00838F;'>假期返校登记</h2></center>
                  <br><center><input style='color:#455A64' type='date' id='returnday' name='returnday' value='".date("Y-m-d")."'>";
            echo "<button style='margin-left:20px' type='submit' class='submit'>确认登记</button></center>";
        }
        @endphp
        <br>
        <br>
        <br>
        </div>

    <input value="{{ $operation }}" id="operation" name="operation" hidden>
    </div>
    </div>
    <div class="w3-third w3-container">
    </div>
    </div>
  </div>
</form>

  <!-- Pagination -->
  <footer id="myFooter">
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
window.onload = function() {
    if({{ $check }} == 1){
        alert("登记成功");
        {{ $check = 0; }}
    }
}
</script>

</body>
</html>
