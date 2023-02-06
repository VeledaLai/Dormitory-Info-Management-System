<!DOCTYPE html>
<html lang="en">
<head>
    <title>宿舍信息管理系统-物业</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    html,body,h1,h2,h3,h4,h5,h6{font-family: "Roboto", sans-serif;}
    .w3-sidebar{
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
               padding: 6px 8px;
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
    <a href="/maintain/" class="w3-bar-item w3-button w3-theme-l1">物业管理系统</a>
    <a href="/logout" class="w3-bar-item w3-button w3-theme-l1 w3-right">登出系统</a>
  </div>
</div>

<!-- Sidebar -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" id="mySidebar">
        <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
            <i class="fa fa-remove"></i>
        </a>
        <h4 class="w3-bar-item"><b>主页</b></h4>
        <a class="w3-bar-item w3-button w3-hover-black" href="/maintain/fee">水电费管理</a>
        <a class="w3-bar-item w3-button w3-hover-black" href="/maintain/repair">报修项目管理</a>
    </nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main" style="margin-left:250px">
  <div class="w3-row w3-padding-64">
    <div class="w3-30% w3-container">
      <h1 class="w3-text-teal">水电费管理</h1>
      <div style="background-color:AliceBlue;">
            <div>
            <br>
            <form action="/maintain/fee" accept-charset="UTF-8" method="post">
            @csrf
            @if($exist)
              <h4 style='color:#455A64;margin-left:50px;'> {{ $month }} 月份 水电费缴纳纪录</h4>
              <h5 style='color:#00838F;margin-left:50px;'>选择宿舍楼栋
                  <select style='color:#455A64;width:50px;' class='bid' name='bid'>
                  <option value='{{ $bid_selected }}'>{{ $bid_selected }}</option>
              @foreach($building as $b)
                @if($b->buildingid === $bid_selected) @continue @endif
                <option value='{{ $b->buildingid }}'>{{ $b->buildingid }}</option>
              @endforeach
              </select>
                   <button style='margin-left:10px' class='submit' name='submit' id='submit'>查询</button></h5>
              </div>
                   <br>
                   <center>
                   <table>
                   <thead>
                   <tr>
                   <th>宿舍号</th>
                   <th>学年</th>
                   <th>月份</th>
                   <th>水费</th>
                   <th>电费</th>
                   <th>状态</th>
                   </tr>
                   </thead><tbody>
              @foreach($record as $r)
              <tr>
                    <td>{{ $r['did'] }}</td>
                    <td>{{ $year }}</td>
                    <td>{{ $month }}</td>
                    <td>{{ $r['water'] }}</td>
                    <td>{{ $r['electric'] }}</td>
                    <td>{{ $r['status'] }}</td>
                    </tr>
              @endforeach
              </tbody></table>
                   <br>
                   </div></div>

            @endif
          </form>
          <form action="/maintain/fee_submit" accept-charset="UTF-8" method="post">
          @csrf
          @php
          if($exist == false){
              echo"<br>
                   <center><h4>请更新 $year 学年 $month 月份 水电费缴纳通知</h3>
                   <br>
                   <button class='submit'>更新通知</button></center>
                   <br>
                   ";
            }
          @endphp
          </form>
      </div>
      </div>
      <div class="w3-third w3-container"></div>

  <!-- Pagination -->
  <footer id="myFooter" style="margin-left">
    <div id="myFooter" style="position: fixed;bottom: 0px;">
      <div class="w3-container w3-theme-l2 w3-padding-32">
        <a href="/maintain/" target="_blank"><h4>返回主页</h4></a>
      </div>
      <div class="w3-container w3-theme-l1">  </div>
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
        if({{ $check }} == "1")
            alert("更新成功！");
            {{ $check = 0; }}
    }
</script>

</body>
</html>
