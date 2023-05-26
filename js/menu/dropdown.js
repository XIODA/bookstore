

// 點選類別秀出圖片

function select(){
    var dropdown_1 =document.getElementById("dropdown");
    var index=dropdown_1.selectedIndex ; // selectedIndex代表的是你所選中項的index
    // console.log (dropdown_1.options[index].value);
    // var dropdown_2 = dropdown_1.options[index].value;

    var datas = {
    //     // "userid": ID
        "showPicH": dropdown_1.options[index].value,
      };
    //   console.log(dropdown_1.options[index].value);

   
    $.ajax({
        type: 'POST',
        url: './backend/APIs/menu/menushow.php',
        data: datas,
        dataType: 'JSON',
        success: function(response){
            var showPicH ="";
            // console.log (showPicH);
            for(var i =0 ; i < response.length; i++){
                // console.log(response[i].Idmenu + response[i].);
                // showPicH = showPicH + "<img src = '" + response[i].Image + "'" ;
                
                showPicH = showPicH + '<div class="w3-third " >'+'<div class="image">'+"<img src = '" + response[i].Image + "' style='width:100%' onclick='onClick(this)' + pid ='"+response[i].PicNum+"'></div>"+'</div>';
                // showPicH = showPicH + '<div class="w3-third " >'+'<div class="image">'+"<img src = '" + response[i].Image + "' style='width:100%' onclick='onClick(this)' + pid ='"+response[i].PicNum+"'></div>"+'</div>';

            
            }
            
          
            document.getElementById("showPic").innerHTML = showPicH;
            
        }
    })
}




//點選類別跳轉

    window.onload = function(){


        

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
                    // console.log(response[i].idmenu + response[i].namemenu);
                    menu = menu + "<option value='" + response[i].idmenu + "'>" +response[i].namemenu + "</option>";
                    // menu = menu + "<option value='" + response[i].namemenu + "'>" +response[i].namemenu + "</option>";
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

