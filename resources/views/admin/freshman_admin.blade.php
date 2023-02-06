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
        html,
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Roboto", sans-serif;
        }

        .w3-sidebar {
            z-index: 3;
            width: 250px;
            top: 43px;
            bottom: 0;
            height: inherit;
        }

        input {
            vertical-align: middle;
            margin: 0;
            padding: 0
        }

        .file-box {
            position: relative;
            width: 340px
        }

        .txt {
            height: 22px;
            border: 1px solid #cdcdcd;
            width: 180px;
        }

        .btn {
            border: none;
            outline: none;
            background-color: #0097A7;
            color: white;
            padding: 6px 8px;
            cursor: pointer;
        }

        .file {
            position: absolute;
            top: 0;
            right: 80px;
            height: 24px;
            filter: alpha(opacity:0);
            opacity: 0;
            width: 260px
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
                height: 265px;
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
        padding: 12px 16px;
        cursor: pointer;
    }
    </style>
</head>

<body>

    <!-- Navbar -->
    <div class="w3-top">
        <div class="w3-bar w3-theme w3-top w3-left-align w3-large">
            <a class="w3-bar-item w3-button w3-right w3-hide-large w3-hover-white w3-large w3-theme-l1"
                href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
            <a href="/admin" class="w3-bar-item w3-button w3-theme-l1">学生宿舍管理系统</a>
            <a href="/logout" class="w3-bar-item w3-button w3-theme-l1 w3-right">登出系统</a>
        </div>
    </div>

    <!-- Sidebar -->
    <nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left" id="mySidebar">
        <a href="javascript:void(0)" onclick="w3_close()"
            class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
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
    <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu"
        id="myOverlay"></div>

    <!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
    <div class="w3-main" style="margin-left:250px">

        <div class="w3-row w3-padding-64">
            <div class="w3-30% w3-container">

                <h1 class="w3-text-teal">新生入住信息管理</h1>
                <div style="background-color:AliceBlue;">
                    <br>
                    <center><h3 class="w3-text-teal">导入 {{ $year }} 住宿新生名单</h3></center><br>
                    <h5>
                        <div style="margin-left:450px" class="file-box">
                            <form action="/admin/import" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type='text' name='textfield' id='textfield' class='txt' disabled/>
                                <input style="margin-left:10px" type='button' class='btn' value='浏览' />
                                <input type="file" name="file" class="file" id="file" size="28"
                                    oninput="document.getElementById('submitBtn').removeAttribute('disabled');"
                                    onchange="document.getElementById('textfield').value=this.value;" />
                                <input style="margin-left:10px" type="submit" name="submit" class="btn" id="submitBtn" value='导入'
                                    onclick="check()" disabled />
                                <br>
                                <br>
                            </form>
                        </div>
                    </h5>
                    {{-- <h6 style="margin-left:400px" ><a href="#">导入后可点击此查看已安排的新生宿舍名单</a></h6> --}}
                    <br>
                </div>
            </div>
            <form action="/admin/export" method="POST" id="exportform">@csrf
            @php
            if (!$freshstds->isEmpty()) {
                echo "<br>
                <div class='w3-30% w3-container'>
                    <div style='background-color:AliceBlue;'>
                        <br>
                            <center>
                            <h3 class='w3-text-teal'>$year 新生宿舍分配名单</h3>
                            <br><table><thead><tr><th>楼栋</th><th>寝室号</th><th>学号</th><th>姓名</th><th>性别</th></tr></thead><tbody>";
                            foreach ($freshstds as $std) {
                                echo '<tr><td>';
                                if ($std->buildingid == null) {
                                    echo '/</td><td>/</td>';
                                } else {
                                    echo "$std->buildingid</td><td>$std->door_num</td>";
                                }
                                echo "
                                        <td>$std->studentid</td>
                                        <td>$std->name</td>
                                        <td>$std->gender</td>
                                    </tr>";
                            }

                                echo "</tbody></table>
                            </center>
                        <br>
                        <center><p><button id='exportbtn' class='download'>导出名单</button></p></center>
                        <br>
                        </div>
                        </div>";
                    }
                    @endphp
                </form>
            <!-- Pagination -->
            <footer id="myFooter" style="margin-left">
                <div id="myFooter" style="position: fixed;bottom: 0px;">
                    <div class="w3-container w3-theme-l2 w3-padding-32">
                        <a href="/admin" >
                            <h4>返回主页</h4>
                        </a>
                    </div>
                </div>

                <div class="w3-container w3-theme-l1">
                </div>
            </footer>
        </div>
        <!-- END MAIN -->
    </div>
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
            if({{ !is_null($check) }}){
                alert("{{ $check }}");
            }
            {{ session()->forget('failmsg'); }}
        }
    </script>

</body>

</html>
