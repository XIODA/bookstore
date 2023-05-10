



function select(ele){
    // var dropdownShow = document.getElementById("dropdown");

    // document.getElementById("showPic").innerHTML = ;
    // document.getElementById("showPic").innerHTML =   dropdown;

    // var datas = {
    //     "showPic": dropdownShow[0],
    // }
    
    $.ajax({
        type: 'POST',
        url: './backend/APIs/menu/menushow.php',
        dataType: 'JSON',
        success: function(response){
        document.getElementById("showPic").innerHTML = 123;
            
        }
    })
}
    window.onload = function(){


        function select(){

        }

        $.ajax({
            type: 'POST',
            url: './backend/APIs/menu/menu.php',
            dataType: 'JSON',
            success: function(response) {
               var dropdown = document.getElementById('dropdown');
            //    console.log(dropdown);
                var menu = '<option name="">請選擇分類</option>';
                // console.log(response);
                for(var i = 0 ; i < response.length ; i++){
                    console.log(response[i].idmenu + response[i].namemenu);
                    menu = menu + "<option name='" + response[i].namemenu + "'>" +response[i].namemenu + "</option>";
                }
                dropdown.innerHTML = menu;

                


                // console.log(menu);
             }
          })
    }


    // var selectDrop = {
    //     "dropdown" : ele.getAttribute("picid"),
    // }
    

    
    // window.location.reload(true)

