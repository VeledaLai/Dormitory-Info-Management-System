<!DOCTYPE html>
<html lang="en">
<head>
  <title>宿舍信息管理系统-宿管</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}
    .w3-sidebar{
      z-index: 3;
      width: 250px;
      top: 43px;
      bottom: 0;
      height: inherit;
    }
    .filterDiv{
      float: left;
      background-color: AliceBlue;
      color: #0C0C0C;
      width: 100px;
      line-height: 50px;
      text-align: center;
      margin: 2px;
      display: none;
    }
    .show{
      display: block;
    }
    .container{
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
      padding: 6px 8px;
      color: white;
      background-color: #0097A7;
      cursor: pointer;
    }
    table{
        font-family: 微軟正黑體;
        font-size:18px;
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
  </style>
</head>
<body>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-theme w3-top w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-right w3-hide-large w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
    <a href="/manager" class="w3-bar-item w3-button w3-theme-l1">学生宿舍管理系统</a>
    <a href="/logout" class="w3-bar-item w3-button w3-theme-l1 w3-right">登出系统</a>
  </div>
</div>

<!-- Sidebar -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
    <i class="fa fa-remove"></i>
  </a>
  <h4 class="w3-bar-item"><b>主页</b></h4>
  <a class="w3-bar-item w3-button w3-hover-black" href="/manager/info">宿舍信息管理</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="/manager/fee_manager">宿舍水电管理</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="/manager/maintain">宿舍报修管理</a>
  <a class="w3-bar-item w3-button w3-hover-black" href="/manager/late">宿舍夜归管理</a>
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->

<div class="w3-main" style="margin-left:250px">
  <div class="w3-row w3-padding-64">
    <div class="w3-30% w3-container">
      <h1 class="w3-text-teal">宿舍水电管理</h1>
      <div style="background-color:AliceBlue;">
        <br>
          <br>
          <h5>
            <form action="/manager/fee_manager" method="post" enctype="multipart/form-data">
                @csrf
                <center><input type="text" placeholder=" 宿舍号" id="did" name="did" >
                <button style="margin-left:10px" class="submit" type="submit">查找</button></center>
                <br>
            </form>
           </h5>
          <br>
       </div>
    </div>
        <br>
    <div class="w3-30% w3-container">
    <div style="background-color:AliceBlue;">
        <br>
        <div id="myBtnContainer">
          <button sytle="margin-left:50px;" class="btn active" onclick="filterSelection('展示全部')"> 展示全部</button>
          <button style="margin-left:10px;" class="btn" onclick="filterSelection('已缴费')"> 已缴费</button>
          <button style="margin-left:10px;" class="btn" onclick="filterSelection('欠费')"> 欠费</button>
        </div>
      <div class="container">
        <div style="margin-left:250px" class="filterDiv 展示全部">
            @php
            if(!is_null($all)){
                echo "<center>
                      <table>
                      <thead>
                      <tr>
                      <th>学年</th>
                      <th>月份</th>
                      <th>寝室号</th>
                      <th>状态</th>
                      </tr>
                      </thead><tbody>";
                    foreach ($all as $a) {
                        echo "<tr><td>$a->year</td><td>$a->month</td><td>$a->dormitoryid</td><td>";
                        if($a->status != "pass")
                            echo"欠费</td></tr>";
                        else echo"已缴清</td></tr>";
                    }
                echo "</tbody></table></center>";
            }else{
                echo "<center><h4 style='color:#455A64'>无记录</h4></center>";
            }
            @endphp
            <br>

          <br>
        </div>
        <div style="margin-left:250px" class="filterDiv 已缴费">
            @php
            if(!is_null($paid)){
              echo "<center><table><thead>
                    <tr>
                        <th>学年</th>
                        <th>月份</th>
                        <th>寝室号</th>
                    </tr>
                    </thead><tbody>";
                foreach ($paid as $p) {
                    echo "<tr><td>$p->year</td><td>$p->month</td><td>$p->dormitoryid</td></tr>";
                }
              echo "</tbody></table></center>";
            }else{
                echo "<center><h4 style='color:#455A64'>无记录</h4></center>";
            }
            @endphp
        <br>
        </div>
        <div style="margin-left:250px" class="filterDiv 欠费">
        @php
        if(!is_null($unpaid)){
            echo "<center><table><thead><tr><th>学年</th><th>月份</th><th>寝室号</th></tr></thead><tbody>";
            foreach ($unpaid as $u) {
                echo "<tr><td>$u->year</td><td>$u->month</td><td>$u->dormitoryid</td></tr>";
            }
              echo "</tbody></table>";
            echo "</table></center>";
        }else{
            echo "<center><h4 style='color:#455A64'>无记录</h4></center>";
        }
        @endphp
        <br>
        </div>
      </div>
    </div>
    </div>
</div>
<div class="w3-30% w3-container"></div>
</div>

  <!-- Pagination -->
  <footer id="myFooter" style="margin-left">
      <div id="myFooter" style="position: fixed;bottom: 0px;">
    <div class="w3-container w3-theme-l2 w3-padding-32">
   <a href="/manager" ><h4>返回主页</h4></a>
    </div>

    <div class="w3-container w3-theme-l1"></div>
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
