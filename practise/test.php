<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../js/lib/jquery.js"></script>
</head>

<body>
    <ul class="info">

        <form>
            <div id="aa">
                <input type="text" name="iten">
                <button type="button" class="btn" onclick="btn()">遊樂園資訊</button>
            </div>
        </form>
        <div>
            <span name="showRes">測試1</span><br />
            <span name="showRes">測試2</span><br />
            <span name="showRes">測試3</span><br />
            <span name="showRes">測試4</span><br />
            <span name="showRes">測試5</span><br />
        </div>
</body>

<script>
    // $.post(./practise/ajax.php,data,callback,type);




    function btn() {
        var iten = document.getElementsByName("iten");
        // console.log(iten[0].value)

        var datas = {
            "itennum": iten[0].value // keyvalue = "" : "" (字串冒號字串)
        }


        $.ajax({
            type: 'POST',
            url: './ajax.php',
            data: datas,
            dataType: 'JSON', //可省略不寫 

            success: function(response) {
                if (response.error == 0) {
                    // console.log(response.error);
                    // console.log(response.msg[0]["_id"]);
                    // console.log(response.msg[0]["name"]);
                    // console.log(response.msg[0]["email"]);
                    // console.log(response.msg[0]["friends"][0]["id"] + " : " + response.msg[0]["friends"][0]["name"]);
                    var showRes = document.getElementsByName("showRes");
                    showRes[0].innerHTML = response.msg[0]["_id"];
                    showRes[1].innerHTML = response.msg[0]["name"];
                    showRes[2].innerHTML = response.msg[0]["email"];
                    showRes[3].innerHTML = response.msg[0]["friends"][0]["id"] + " : " + response.msg[0]["friends"][0]["name"];


                } else {
                    alert("資料輸入錯誤");
                }
            } //可以指定函式或匿名函式
        })


    }
    $(function() {
        $.ajax({
            type: 'POST',
            url: './ajax.json',
            //   data: data,
            success: function(response) {
                // console.log(response);
                // console.log(response[0].age);
                // console.log(response[0].about);
                // console.log(response[0].balance);
                // console.log(response[0].email);
                // console.log(response[0].friends[1].name);
                // // console.log(response[1].about);
                // console.log(response[1].age);
                // console.log(response[1].email);
                // console.log(response[1].name);
                // console.log(response[1]._id);    
                // console.log(response[2].about);
                // console.log(response[2].age);
                // console.log(response[2].email);
                // console.log(response[2].name);
                // console.log(response[2].tags[3]); 
                // console.log(response[3].about);
                // console.log(response[3].age);
                // console.log(response[3].email);
                // console.log(response[3].name);
                // console.log(response[3].tags[3]);
                // console.log(response[4].about);
                // console.log(response[4].age);
                // console.log(response[4].email);
                // console.log(response[4].name);
                // console.log(response[4].tags[3]);
                // response.innerHtml = response[0].age
            }, //可以指定函式或匿名函式
            dataType: "json", //可省略不寫
        });
    })
</script>

</html>