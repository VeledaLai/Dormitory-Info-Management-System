<!DOCTYPE html>
<html lang="en">
<head>
<title>宿舍信息管理系统-社区</title>
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
        font-size:18px;
        width:300px;
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
    .open-button {
        border: none;
        outline: none;
        background-color: #0097A7;
        color: white;
        padding: 12px 16px;
        cursor: pointer;
        opacity: 0.8;
        bottom: 23px;
        right: 280px;
    }
    button.cancel{
        border: none;
        outline: none;
        padding: 8px 14px;
        background-color:  #A93226 ;
        color: white;
    }
    button.submit{
        border: none;
        outline: none;
        padding: 8px 14px;
        background-color: #0097A7;
        color: white;
    }

         /* The popup form - hidden by default */
    .form-popup {
        display: none;

        bottom: 0;
        left: 50px;
        border: 3px solid #f1f1f1;
        z-index: 9;
    }
    .form-container .btn {
        background-color: #1c7294;
        color: white;
    }
    .form-container .cancel {
        background-color: rgb(134,20,20);
    }
    /* Add styles to the form container */


    /* Add some hover effects to buttons */
    .form-container .btn:hover, .open-button:hover {
        opacity: 1;
    }
</style>
</head>
<body>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-theme w3-top w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-right w3-hide-large w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
    <a href="/admin" class="w3-bar-item w3-button w3-theme-l1">学生宿舍管理系统</a>
            <a href="/logout" class="w3-bar-item w3-button w3-theme-l1 w3-right">登出系统</a>
  </div>
</div>

<!-- Sidebar -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
    <i class="fa fa-remove"></i>
  </a>
  <h4 class="w3-bar-item"><b>主页</b></h4>
  <a class="w3-bar-item w3-button w3-hover-black" href="/admin/freshman">新生入住管理</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="/admin/checkin">入住申请管理</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="/admin/checkout">退宿申请管理</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="/admin/change">寝室调动管理</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="/admin/payment">缴费信息管理</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="/admin/building">楼栋信息管理</a>
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main" style="margin-left:250px">

  <div class="w3-row w3-padding-64">
    <div class="w3-30% w3-container">

      <h1 class="w3-text-teal">楼栋信息管理</h1>
      <div style="background-color:AliceBlue;">
      <br>
      <br>
        <form><center><table>
        <tr>
        <th>楼栋</th>
        </tr>
        @php
        foreach($building as $b){
            echo "<tr><td>$b->buildingid</td></tr>";
        }
        @endphp
        </table></center></form>
        <br>
       <center><h5><button class="open-button" onclick="openForm()">新增/修改楼栋信息</button></h5></center>

        <div class="form-popup" id="myForm">
         <center>
         <form action="/admin/building"  method="POST" class="form-container">
          @csrf
            <br>
            <h5><label for="楼栋"><b>楼栋号:</b></label>
            <input type="text" placeholder="Txx" name="bid" required>
            <br>
            <br>
            <label for="密码"><b>管理员密码:</b></label>
            <input type="password" placeholder="输入8位密码" name="pwd" required>
            <br>
            <br>
            <button type="submit" class="submit">确认</button>
            <button style="margin-left:20px" class="cancel" onclick="closeForm()">取消</button>
         </h5></form></center>
           </div>

   <script>
 function openForm() {
     document.getElementById("myForm").style.display = "block";
                                        }
 function closeForm() {
       document.getElementById("myForm").style.display = "none";
      }
  </script>
                <br>
                <br>
                 <br>
                 <br>
                  <br>
     </div>
    </div>
    <div class="w3-third w3-container">
    </div>
  </div>



  <!-- Pagination -->
  <footer id="myFooter" style="margin-left">
      <div id="myFooter" style="position: fixed;bottom: 0px;">
    <div class="w3-container w3-theme-l2 w3-padding-32">
   <a href="/admin" ><h4>返回主页</h4></a>
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
    if({{$check}} == 200) alert("宿舍楼创建成功！"); //$check = 200 表示成功創建200個did(每棟樓有2002間房)
    if({{$check}} == 1) alert("楼栋管理员密码修改成功！");
    {{ $check=0; }}
}
</script>

</body>
