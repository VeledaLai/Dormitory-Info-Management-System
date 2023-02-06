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
    .w3-sidebar {
        z-index: 3;
        width: 250px;
        top: 43px;
        bottom: 0;
        height: inherit;
    }
    input{ vertical-align:middle; margin:0; padding:0}
    .file-box{ position:relative;width:340px}
    .txt{ height:22px; border:1px solid #cdcdcd; width:180px;}
    .btn{ background-color:#FFF; border:1px solid #CDCDCD;height:24px; width:70px;}
    .file{ position:absolute; top:0; right:80px; height:24px; filter:alpha(opacity:0);opacity: 0;width:260px }
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
    </style>
    </head>

    <body>
    <!-- Navbar -->
    <div class="w3-top">
        <div class="w3-bar w3-theme w3-top w3-left-align w3-large">
            <a class="w3-bar-item w3-button w3-right w3-hide-large w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
            <a href="/manager" class="w3-bar-item w3-button w3-theme-l1">宿舍管理系统</a>
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
        <h1 class="w3-text-teal">宿舍报修管理</h1>
        <div style="background-color:AliceBlue;">
        <br>
        <br>
        <h5>
            <form action="/manager/maintain" method="post" enctype="multipart/form-data">
                @csrf
                <center><input type="text" placeholder=" 宿舍号" id="did" name="did" >
                <button style="margin-left:10px" class="submit" type="submit">查找</button></center>
                <br>
            </form>
        </h5>
        <br>
        </div>
    </div>
        <div class="w3-30% w3-container">
        <h3 class='w3-text-teal'>宿舍报修名单</h3>
        <div style="background-color:AliceBlue;">
            <br>
            @php
            echo "<center>";
                if(!is_null($lists)){
                echo "<table>
                <tr>
                    <th>寝室号</th>
                    <th>预约时间</th>
                    <th>报修物项</th>
                    <th>保修原因</th>
                    <th>联系电话</th>
                </tr>";
                foreach ($lists as $l) {
                    echo "<tr>
                    <td>$l->dormitoryid</td>
                    <td>$l->applytime</td>
                    <td>$l->goodsname</td>
                    <td>$l->reason</td>
                    <td>$l->phone</td>
                </tr>";
                }
                echo "</table>";
            }else {
                echo "<br><center><h4 style='color:#455A64'>无报修记录</h4></center>";
            }
            echo "</center>";
            @endphp
            <br>
        <p>
        </p>
    <br>

    </div>
    </div>
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
    // Get the Sidebar
    var mySidebar = document.getElementById("mySidebar");
    // Get the DIV with overlay effect
    var overlayBg = document.getElementById("myOverlay");
    // Toggle between showing and hiding the sidebar, and add overlay effect
    function w3_open(){
        if (mySidebar.style.display === 'block') {
            mySidebar.style.display = 'none';
            overlayBg.style.display = "none";
        }
        else{
            mySidebar.style.display = 'block';
            overlayBg.style.display = "block";
        }
    }
    // Close the sidebar with the close button
    function w3_close(){
        mySidebar.style.display = "none";
        overlayBg.style.display = "none";
    }
    </script>
</body>
