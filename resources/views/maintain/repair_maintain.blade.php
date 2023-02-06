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
    html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}
    .w3-sidebar {
    z-index: 3;
    width: 250px;
    top: 43px;
    bottom: 0;
    height: inherit;
    }
    /* Add styles to the form container */
     .container {
    margin-top: 20px;
    overflow: hidden;
    }
    .filterDiv {
    float: left;
    background-color: AliceBlue;
    color: #455A64;
    width: 450px;
    line-height: 50px;
    text-align: center;
    margin: 2px;
    display: none;
    }
    .show {
    display: block;
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
    button.done {
                    border: none;
                    outline: none;
                    background-color: #0097A7;
                    color: white;
                    padding: 1px 16px;
    }
    .open-button {
           border: none;
           outline: none;
           background-color: #B2DFDB;
           color: #455A64;
           padding: 12px 16px;
           cursor: pointer;
           opacity: 0.8;
           bottom: 23px;
           right: 280px;
    }
    button.cancel{
                    border: none;
                    outline: none;
                    background-color: rgb(134,20,20);
                    color: white;
    }
    button.submit{
                    border: none;
                    outline: none;
                    background-color: #096B92;
                    color: white;
    }
    table{
        font-family: 微軟正黑體;
        font-size:18px;
        width:900px;
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
    /* The popup form - hidden by default */
    .form-popup {
           display: none;
           bottom: 0;
           left: 50px;
           border: 3px solid #f1f1f1;
           z-index: 9;
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

      <h1 class="w3-text-teal">报修项目管理</h1>
      <div style="background-color:AliceBlue;">
      <br>
       <div id="myBtnContainer">
         <button style="margin-left:50px;" class="btn active" onclick="filterSelection('待完成')"> 待完成</button>
         <button style="margin-left:10px;" class="btn" onclick="filterSelection('已完成')"> 已完成</button>
       </div>

      <div class="container">
        <div style="margin-left:220px" class="filterDiv 待完成">
            <form action="/maintain/repair_submit" accept-charset='UTF-8' method='post' id='done'>
            @csrf @php
                if($item == []){
                    echo "<h4 style='margin-left:220px'>尚无待完成的报修项目</h4>";
                }
                else{
                    echo "<center><table class='multi-table' cellspacing='0'>
                          <tr>
                          <th><input id='js-all-checkbox' type='checkbox' onclick='checkAll(this)'></th>
                          <th>楼栋</th>
                          <th>寝室号</th>
                          <th>预约时间</th>
                          <th>报修项目</th>
                          <th>具体情况</th>
                          <th>联系电话</th>
                          </tr>";
                    foreach($item as $i){
                        echo "<tr><td><input type='checkbox' name='select[]' value='$i[id]' oninput='clickCheckbox()'></td>
                              <td>$i[bid]</td>
                              <td>$i[room]</td>
                              <td>$i[applytime]</td>
                              <td>$i[goodsname]</td>
                              <td>$i[reason]</td>
                              <td>$i[phone]</td>
                              </tr>";
                        }
                        echo "</table></center>
                              <center><h6><button style='margin-left:350px' name='operation' value='done' class='done'>完成</button></h6></center>";
                }
                 @endphp
                </form>
        </div>
        <div style="margin-left:220px" class="filterDiv 已完成">
                @php
                    if($record == []){
                        echo "<h4 style='margin-left:220px'>尚无已完成的报修项目</h4>";
                    }
                    else{
                        echo "<center><table border>
                             <tr>
                             <th>楼栋</th>
                             <th>寝室号</th>
                             <th>完成时间</th>
                             <th>报修项目</th>
                             <th>联系电话</th>
                             </tr>";
                        foreach($record as $r){
                            echo "<tr>
                                <td>$r[bid]</td>
                                <td>$r[room]</td>
                                <td>$r[ctime]</td>
                                <td>$r[goodsname]</td>
                                <td>$r[phone]</td>
                                </tr>";
                            }
                        echo "</table></center><br>";
                    }
                @endphp
        </div>
            </div>
                <h6><button style='margin-left:50px' class='open-button' onclick='openForm()'>查询指定宿舍报修信息</button></h6>

         <div class="form-popup" id="myForm">
         <center>
         <form action="/maintain/repair"  method="POST" class="form-container">
          @csrf
         <h4 style="margin-right:500px"> 请输入宿舍信息：</h4>
         <h5><label for="楼栋"><b style="color:#455A64">楼栋号:</b></label>
         <input type="text" placeholder="Txx" name="bid" required>
         <br>
         <br>
         <label for="寝室"><b style="color:#455A64">寝室号:</b></label>
         <input type="text" placeholder="XXX" name="did" required>
          <br>
          <br>
          <button style="margin-left:60px" type="submit" class="submit">确认</button>
          <button style="margin-left:20px" class="cancel" onclick="closeForm()">取消</button>
         </h5></form></center>
         </div>
    <br>
    <br>
    </div>
    <br>
    <br>
    <br>
     </div>
    </div>
</div>
    <script>
        function openForm() {
            document.getElementById("myForm").style.display = "block";
                                               }
        function closeForm() {
              document.getElementById("myForm").style.display = "none";
             }
         </script>
    <div class="w3-third w3-container">
    </div>
  </div>
     </div>
     </div>
     </div>
    <!-- Pagination -->
    <footer id="myFooter" style="margin-left">
        <div id="myFooter" style="position: fixed;bottom: 0px;">
            <div class="w3-container w3-theme-l2 w3-padding-32">
                <a href="/maintain/" target="_blank"><h4>返回主页</h4></a>
            </div>
            <div class="w3-container w3-theme-l1"></div>
        </div>
    </footer>

    <!-- END MAIN -->
</div>
<script>
    filterSelection("待完成")
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
            alert("查找成功！");
        if({{ $check }} == "2")
            alert("更新成功！");
        if({{ $check }} == "3")
            alert("查找的宿舍不存在，请重新查询！");
            {{ $check = 0; }}

    }
</script>
</body>
