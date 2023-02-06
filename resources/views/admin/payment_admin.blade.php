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
.filterDiv {
  float: left;
  background-color: AliceBlue;
  color: #0C0C0C;
  width: 450px;
  line-height: 50px;
  text-align: center;
  margin: 2px;
  display: none;
}

.show {
  display: block;
}

.container {
  margin-top: 20px;
  overflow: hidden;
}

/* Style the buttons */
.btn{
      border: none;
      outline: none;
      padding: 12px 16px;
      background-color: #B2DFDB;
      color:#455A64;
      cursor: pointer;
    }
    .btn:hover{
      background-color: #B2DFDB;
      color:white;
    }
    .btn.active{
      background-color:#0097A7;
      color: white;
    }
button.submit{
               border: none;
               outline: none;
               background-color: #0097A7;
               color: white;
               padding: 12px 16px;
               cursor: pointer;
}

    table{
        font-family: 微軟正黑體;
        font-size:18px;
        width:800px;
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
    table tbody {
                display: block;
                height: 340px;
                overflow-y: scroll;
    }
    table thead {
                width: calc( 100% - 1em)
    }
    table thead,
    tbody tr {
                display: table;
                width: 100%;
                table-layout: fixed;
    }
    button.download{
        border: none;
        outline: none;
        background-color: #0097A7;
        color: white;
        padding: 4px 18px;
        cursor: pointer;
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

      <h1 class="w3-text-teal">缴费信息管理</h1>
      <form action="/admin/payment" accept-charset="UTF-8" method="post">
        @csrf
        @php
          if($inform == true){
                    echo "<div style='background-color:AliceBlue;''>
                          <br>
                          <div id='myBtnContainer'>
                          <div>
                          <br>
                          <center><h4 style='color:#455A64'>尚未发起 $current 学年的缴费通知</h4>
                          <button typr='submit' class='submit'>更新缴费通知</button></center><br>
                          <br>
                          </div>
                          </div>
                          </div>";
        }
        if($make_fail == true){
                    echo "<div style='background-color:AliceBlue;''>
                          <br>
                          <div id='myBtnContainer'>
                          <div>
                          <br>
                          <center><h4 style='color:#455A64'>尚未更新 $current 学年的缴费失效通知</h4>
                          <button typr='submit' class='submit'>更新缴费通知</button></center><br>
                          <br>
                          </div>
                          </div>
                          </div>";
        }
        @endphp
      </form>
      <br>
      <div style="background-color:AliceBlue;">
       <br>
       <center><h2 <h2 style="color:#00838F"> {{$current}} 学年缴费情况</h2></center>
       <div id="myBtnContainer">
         <button style="margin-left:50px;" class="btn active" onclick="filterSelection('展示全部')"> 展示全部</button>
         <button style="margin-left:10px;" class="btn" onclick="filterSelection('已缴费')"> 已缴费</button>
         <button style="margin-left:10px;" class="btn" onclick="filterSelection('未缴费')"> 未缴费</button>
       </div>

      <div class="container">
      <div style="margin-left:220px" class="filterDiv 展示全部">
        <form action="/admin/payment_download/all" accept-charset='UTF-8' method='post' id="exportall">
        @csrf @php
              if($all != []){
                echo "<table>
                      <thead>
                      <tr>
                      <th>楼栋</th>
                      <th>寝室</th>
                      <th>姓名</th>
                      <th>学号</th>
                      <th>状态</th>
                      <th>缴费情况</th>
                      </tr></thead><tbody>";
                foreach($all as $a){
                    echo "<tr>
                          <td>$a[bid]</td>
                          <td>$a[room]</td>
                          <td>$a[name]</td>
                          <td>$a[id]</td>
                          <td>$a[status]</td>
                          <td>$a[bill]</td>
                          </tr>";
                    }
                    echo "</tbody></table>
                          <br>
                          <button style='margin-left:320px' onclick='{ if(confirm('确定下载？')) {document.getElementById('exportall').submit();}}'' class='download'>导出名单</button>
                          <br>
                          <br>
                          </div>";
                }
             @endphp
            </form>
        <div style="margin-left:220px" class="filterDiv 已缴费">
            <form action="/admin/payment_download/pass" accept-charset='UTF-8' method='post' id='exportpass'>
            @csrf @php
                  if($pass != []){
                    echo "<table>
                          <thead>
                          <tr>
                          <th>楼栋</th>
                          <th>寝室</th>
                          <th>姓名</th>
                          <th>学号</th>
                          <th>状态</th>
                          <th>缴费情况</th>
                          </tr></thead><tbody>";
                    foreach($pass as $ps){
                        echo "<tr>
                            <td>$ps[bid]</td>
                            <td>$ps[room]</td>
                            <td>$ps[name]</td>
                            <td>$ps[id]</td>
                            <td>$ps[status]</td>
                            <td>$ps[bill]</td>
                            </tr>";
                        }
                        echo "</tbody></table>
                          <br>
                          <button style='margin-left:320px' onclick='{ if(confirm('确定下载？')) {document.getElementById('exportpass').submit();}}' class='download'>导出名单</button>
                          <br>
                          <br>";
                }
                 @endphp
                  </form>
                 </div>
        <div style="margin-left:220px" class="filterDiv 未缴费">
            <form action="/admin/payment_download/pending" accept-charset='UTF-8' method='post' id='exportpending'>
                @csrf
                @php
                if($pending != []){
                        echo "<table>
                            <thead>
                            <tr>
                            <th>楼栋</th>
                            <th>寝室</th>
                            <th>姓名</th>
                            <th>学号</th>
                            <th>状态</th>
                            <th>缴费情况</th>
                            </tr></thead><tbody>";
                        foreach($pending as $p){
                            echo "<tr>
                                <td>$p[bid]</td>
                                <td>$p[room]</td>
                                <td>$p[name]</td>
                                <td>$p[id]</td>
                                <td>$p[status]</td>
                                <td>$p[bill]</td>
                                </tr>";
                            }
                        echo "</tbody></table>
                            <br>
                            <button style='margin-left:320px' onclick='{ if(confirm('确定下载？')) document.getElementById('exportpending').submit()}' class='download'>导出名单</button>
                            <br>
                            <br>";
                    }
                @endphp
            </form>
            </div>
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
    filterSelection("展示全部")
    function filterSelection(c) {
        var x, i;
        x = document.getElementsByClassName("filterDiv");
        if (c == "all") c = "";
        for (i = 0; i < x.length; i++) {
        w3RemoveClass(x[i], "show");
        if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
        }
    }

    function w3AddClass(element, name) {
        var i, arr1, arr2;
        arr1 = element.className.split(" ");
        arr2 = name.split(" ");
        for (i = 0; i < arr2.length; i++) {
        if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
        }
    }

    function w3RemoveClass(element, name) {
        var i, arr1, arr2;
        arr1 = element.className.split(" ");
        arr2 = name.split(" ");
        for (i = 0; i < arr2.length; i++) {
        while (arr1.indexOf(arr2[i]) > -1) {
            arr1.splice(arr1.indexOf(arr2[i]), 1);
        }
        }
        element.className = arr1.join(" ");
    }

    // Add active class to the current button (highlight it)
    var btnContainer = document.getElementById("myBtnContainer");
    var btns = btnContainer.getElementsByClassName("btn");
    for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function(){
        var current = document.getElementsByClassName("active");
        current[0].className = current[0].className.replace(" active", "");
        this.className += " active";
        });
    }

       </script>

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
    if({{ $check }} == "1"){
        alert("更新成功！");
        {{ $check = 0; }}
    }
}
</script>

</body>
