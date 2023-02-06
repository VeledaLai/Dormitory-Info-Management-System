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
   button.disagree{
                    border: none;
                    outline: none;
                    padding:6px 8px;
                    background-color: #A93226 ;
                    color: white;
    }
    button.agree{
                    border: none;
                    outline: none;
                    padding:6px 8px;
                    background-color: #0097A7;
                    color: white;
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
    <form action="/admin/checkout" method="post">
    @csrf
      <h1 class="w3-text-teal">退宿申请管理</h1>
      <div style="background-color:AliceBlue;">
      <br>
       <div style="background-color:AliceBlue;">
       <br>@php
            if($apply == []){
                echo "<br><center><h4 style='color:#455A64'>暂无待审批的退宿申请名单</h4></center>";
            }
            else{
                echo "<h3 style='margin-left:50px' class='w3-text-teal'>个人申请名单</h3>
                    <br>
                    <center><table class='multi-table' cellspacing='0' border>
                    <thead>
                    <tr>
                    <th> <input id='js-all-checkbox' type='checkbox' onclick='checkAll(this)'></th>
                    <th>序号</th>
                    <th>姓名</th>
                    <th>学号</th>
                    <th>年级</th>
                    <th>宿舍</th>
                    <th>原因</th>
                    </tr>
                    </thead>
                    <tbody>";
                $num = 0;
                foreach($apply as $a){
                    $num++;
                    echo "<tr><td><input type='checkbox' name='select[]' value='$a[id]' oninput='clickCheckbox()'></td>
                        <td>$num</td>
                        <td>$a[name]</td>
                        <td>$a[id]</td>
                        <td>$a[class]</td>
                        <td>$a[did]</td>
                        <td>$a[reason]</td>
                        </tr>";
                    echo "</tbody>
                        </table></center>
                        <br>
                        <br>
                        <center><h4><button name='operation' value='agree' class='agree'>同意</button>
                        <button style='margin-left:10px' name='operation' value='decline' class='disagree'>拒绝</button></h4></center>
                        </form>";
                }
            }
            @endphp

      <!--<h3>当前选中的是: <span id="js-check-text"></span></h3>-->

       <br>
       <br>
       <br>
       </div>
    </div>
    <div class="w3-third w3-container">

    </div>
  </div>


<script>
    let checkValues = [];

    function clickCheckbox(e) {
        //拿到所有选择的dom复选框
        let checkDomArr = document.querySelectorAll('.multi-table tbody input[type=checkbox]:checked');
        //拿到所有选择的dom复选框的值
        checkValues = [];
        for (let i = 0, len = checkDomArr.length; i < len; i++) {
            var checkobj = {}
            checkobj.id = checkDomArr[i].parentNode.parentNode.children[1].innerHTML
            checkobj.name = checkDomArr[i].parentNode.parentNode.children[2].innerHTML
            checkobj.age = checkDomArr[i].parentNode.parentNode.children[3].innerHTML
            checkValues.push(checkobj);
        }
        //更新当前选中的文本值
        updateText();
        //拿到所有的单选框dom
        let allCheckDomArr = document.querySelectorAll('.multi-table tbody input[type=checkbox]');
        console.log(allCheckDomArr, 'allcheckdom---------')
        //拿到复选框dom
        let allCheckbox = document.getElementById('js-all-checkbox');
        //遍历所有的单选框
        for (let i = 0, len = allCheckDomArr.length; i < len; i++) {
            //如果有一个单选框的check值为false，复选框都不能为true
            if (!allCheckDomArr[i].checked) {
                if (allCheckbox.checked) allCheckbox.checked = false;
                break;
            } else if (i === len - 1) {
                //否则 遍历到i=len-1的时候(即最后一项单选框了)，任然不存在上种情况，说明单选框全部选中，此时复选框的checked值为true
                document.getElementById('js-all-checkbox').checked = true;
                return;
            }
        }
    }

    //复选功能
    function checkAll(current) {
        console.log(current, 'current-----------')
        //拿到所有的单选框
        let allCheckDomArr = document.querySelectorAll('.multi-table tbody input[type=checkbox]');
        //点击之后，如果复选框的checked值为false,说明没点击时为true，即是勾选状态，此时所有的单选框接下来应该为false
        if (!current.checked) { // 点击的时候, 状态已经修改, 所以没选中的时候状态时true
            checkValues = [];
            //遍历所有的单选框
            for (let i = 0, len = allCheckDomArr.length; i < len; i++) {
                //拿到当前遍历的单选框的checked值
                let checkStatus = allCheckDomArr[i].checked;
                //若为true（即选中状态），置为false
                if (checkStatus) allCheckDomArr[i].checked = false;
            }
        } else {
            //同理
            //如果复选框为true，那么所有的单选框都应该被勾选
            checkValues = [];
            for (let i = 0, len = allCheckDomArr.length; i < len; i++) {
                let checkStatus = allCheckDomArr[i].checked;
                if (!checkStatus) allCheckDomArr[i].checked = true;
                var checkobj = {}
                checkobj.id = allCheckDomArr[i].parentNode.parentNode.children[1].innerHTML
                checkobj.name = allCheckDomArr[i].parentNode.parentNode.children[2].innerHTML
                checkobj.age = allCheckDomArr[i].parentNode.parentNode.children[3].innerHTML
                checkValues.push(checkobj);
            }
        }
        //更新当前选中的文本值
        updateText();
    }

    function updateText() {
        document.getElementById('js-check-text').innerHTML = JSON.stringify(checkValues);
    }
</script>

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

    window.onload = function(){
        if(session('check') == 1) alert("审批已通过！");
        else if (session('check') == 2) alert("审批已驳回！");
    }
</script>

</body>
