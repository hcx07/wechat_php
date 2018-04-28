/**
 * Created by yangzc on 2017/11/15.
 */
/**
 * Created by yangzc on 2017/7/28.
 * 公用js库
 */

// document.onkeydown = function(e){
//     var ev = document.all ? window.event : e;
//     if(ev.keyCode==13) {
//         search();
//     }
// }

//关闭iframe页面
// var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
// parent.layer.close(index);
// parent.location.reload();  //刷新父类


$('.lll').click(function(){
    var obj= $(this);
    var id = $(this).attr('about');


    if(id){
        ajax_post(check_auth_url,{url:'Coursekb/set_kb'},function(re){
            if(re.errcode ==201){
                return msg(re.msg,201);
            }else{



            }
        });
    }else{
        return msg('请选择需要操作的数据',201);
    }
});


/*
 * @param num
 * @returns {*}
 * 判断是否是正整数
 */
function is_int(num){
    //判断是否是数字
    var r = /^\+?[1-9][0-9]*$/;　　//正整数
    if(!r.test(num)){
        return false;
    }else{
        return num;
    }
}



/**
 * 验证ajax 返回参数
 * @param $data
 */

function check_data($data,type){
    if($data.errcode!=200){
        return msg($data.msg,201);
    }else{
        if(type==1){
            msg($data.msg,200);
        }
        return $data.data;
    }
}

/***
 * jq ajaxpost
 * @param url
 * @param data
 * @param call_function
 */
function ajax_post(url,data,call_function){
    $.ajax({
        url:url,
        type:'post',
        data:data,
        dataType:'json',
        success:call_function,
        error:function(){
            return msg('请求失败',201);
        }
    });
}

/**
 * 公用提示
 * @param $msg
 */
function msg($msg,$code){
    if($code==200){
        return layer.msg($msg, {icon: 1,time:1000});
    }else{
        return layer.msg($msg, {icon: 5,time:2000});
    }
}

/**
 * 加载层
 */
function loading(time){
    //加载层-风格4
    if(!time){
        time =2000;
    }
    layer.msg('加载中', {
        icon: 16,shade: 0.01,time:time
    });
}

/**
 *数组转对象
 */
function array_to_object($arr){
    var object = new Object();
    for(var key in $arr){
        object[key] = $arr[key];
    }
    return object;
}

/**
 * 对象转数组
 */
function object_to_array($obj){
    var arr = [];
    for(var val in $obj){
        arr.push($obj[val]);
    }
    return arr;
}

/**
 * 搜索时间设置
 * @param time
 */
function set_sel_time(time){
    if(time){
        var arr = time.split("~");
        var statrt = Date.parse(new Date(arr[0]))/1000;
        var end = Date.parse(new Date(arr[1]))/1000;
        return statrt+'_'+((end+3600*24)-1);
    }
}


/**
 * 判断有无权限
 */
function check_auth(url){

  var status = true;


  alert(status);
}

/**
 * 验证密码规则
 */
function check_pwd(pwd){

}


/**
 * ajax 上传文件
 *  var formData = new FormData();
 *  var name = $("input").val();
 *  formData.append("file",$("#upload")[0].files[0]);
 *  formData.append("name",name);
 *  name input 的id 和上传文件的name 值
 */
function ajax_upload_file(Url,name,func,load){
    var formData = new FormData();
    formData.append(name,$("#"+name)[0].files[0]);
    $.ajax({
        url : Url,
        type : 'POST',
        data : formData,
        // 告诉jQuery不要去处理发送的数据
        processData : false,
        // 告诉jQuery不要去设置Content-Type请求头
        contentType : false,
        beforeSend:load,
        success : func,
        error : function(responseStr) {
            return msg('请求失败~',201);
        }
    });
}




/**
 * 2017年12月05日15:27:22
 * 模板
 */
function check_authhhhhh(){
    ajax_post(check_auth_url,{url:'admin/to_add'},function(re){
        if(re.errcode ==201){
            msg(re.msg,201);
        }else{

        }
    });
}

/**
 * 获取 name值相同的 input 的值 返回 arr
 * @param $name
 * @returns {Array}
 */
function eq_input_val($name){
    var obj = $("input[name="+$name+"]");
    var arr =[];
    for(var i=0;i<obj.length;i++){
        var value = $(obj[i]).val();
        arr.push(value);
    }
   return arr;
}

