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

  <div class="w3-row w3-padding-64">
    <div class="w3-30% w3-container">
        <form action="/student/check_in_out" method="POST">
        @csrf
      <h1 class="w3-text-teal">入退宿申请</h1>

       <div style="background-color:AliceBlue;">
        <br>
        <br>
        @php
        if( $user->status == "毕业" ){
            echo "<center><h4>亲爱的 $user->name 校友，您已完成毕业生退宿手续。</h4></cemter><br><br>";
        }
        else{
            if( $user->status == "住宿" ){
                echo "<h2 style='color:#00838F;margin-left:515px;'>退宿申请</h2>";
                echo "<br><h4 style='color:#00838F;margin-left:300px;'> $user->name 同学，您已入住  $user->dormitoryid </h4>";
                echo "<h5 style='color:#455A64;margin-left:300px;'>请选择您的退宿原因：";
                echo "<input type='radio' style='margin-left:20px' name='reason' value='走读' required> 走读
                    <input type='radio' style='margin-left:20px' name='reason' value='毕业'> 毕业
                    <input type='radio' style='margin-left:20px' name='reason' value='休学'> 休学
                    <input type='radio' style='margin-left:20px' name='reason' value='退学'> 退学
                    <input type='radio' style='margin-left:20px' name='reason' value='其他'> 其他
                    </h5>";
                echo "<h5 style='color:#455A64;margin-left:300px;'>确认办理退宿，请重新输入学号和密码：</h5>";
            }
            else{
                echo "<h2 style='color:#00838F;margin-left:515px;'>入宿申请</h2>";
                echo "<br><h4 style='color:#00838F;margin-left:300px;'> $user->name 同学，学生宿舍欢迎您</h4>";
                echo "<h6 style='color:#455A64;margin-left:300px;'>欲办理入宿，请重新输入学号和密码：</h6>";
            }
            echo "<div class='w3-row-padding' style='margin:0 -16px;'>
                  <div class='w3-half'>
                  <label style='color:#455A64;margin-left:300px;'>学号</label>
                  <input style='margin-left:300px' class='w3-input w3-border' name='id' type='text' placeholder='学号'>
                  <br>
                  <label style='color:#455A64;margin-left:300px;'>密码</label>
                  <input style='margin-left:300px' class='w3-input w3-border' name='pwd' type='password' placeholder='密码'>
                  </div>
                  </div>
                  <br>
                  <br>
                  <center><p><button type='submit' class='submit'>确认申请</button></p></center>
                  <br>
               </div>
               </form>";
        }
        @endphp
    </div>
    <div class="w3-third w3-container">

    </div>

  </div>



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
window.onload = function() {
    if({{ $continue }}==1 && {{ $check }}==1) alert('提交成功，等待审核！');
    if ({{ $continue }}==2) alert('学号密码有误，请重新操作！');
    if({{ $check }}==2) alert('您已提交过申请，请耐心等候社区审批！');
}
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
