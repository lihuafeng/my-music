<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>{$faceUrl['avataroffline']}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/Template/default/static/src/css/layui.css?timspan=3" media="all">
    <link rel="stylesheet" href="/Template/default/static/css/index.css?timspan=24">
    <script src="/Template/default/static/js/jquery.js"></script>
    <script src="/Template/default/static/js/jquery.json.js"></script>
    <script src="/Template/default/static/js/console.js"></script>
    <!--<script src="/config.js?timespan=12347" charset="utf-8"></script>-->
    <script src="/Template/default/static/js/comet.js?timespan=123" charset="utf-8"></script>
    <script src="/Template/default/static/js/chat.js?timespan=124567911710721534" charset="utf-8"></script>
    <!--<script type="text/javascript" src="/Template/default/static/js/swfupload.js"></script>-->
    <!--<script type="text/javascript" src="/Template/default/static/js/swfupload.queue.js"></script>-->
    <!--<script type="text/javascript" src="/Template/default/static/js/fileprogress.js"></script>-->
    <script type="text/javascript" src="/Template/default/static/js/handlers.js"></script>
    <!--<script type="text/javascript" src="/Template/default/static/js/facebox.js"></script>-->
    <script>
        var avataroffline = "<?php echo ($faceUrl['avataroffline']); ?>";
        var avatarofflinemessage = '<?php echo ($faceUrl["avatarofflinemessage"]); ?>';
        var avatarleadermessage = '<?php echo ($faceUrl["avatarleadermessage"]); ?>';
        var avatarleaderonline = '<?php echo ($faceUrl["avatarleaderonline"]); ?>';
        var avatarworkermessage = '<?php echo ($faceUrl["avatarworkermessage"]); ?>';
        var avatarworkeronline = '<?php echo ($faceUrl["avatarworkeronline"]); ?>';
        var webim = '<?php echo ($faceUrl["webim"]); ?>';
        var users = <?php echo ($userjson); ?>;
        var user = <?php echo ($selfjson); ?>;
        var debug = true;
    </script>
    <script type="text/javascript">

        window.onload = function () {
            //普通图片上传
            var sess = '<?php echo ($sess); ?>';
            layui.use('upload', function () {
                var $ = layui.jquery,
                        upload = layui.upload;
                //普通图片上传
                var uploadInst = upload.render({
                    elem: '#upload_button_middle',
                    url: "/index.php?s=/Index/upload.html" + sess,
                    before: function (obj) {
                        //预读本地文件示例，不支持ie8
                        obj.preview(function (index, file, result) {
                            //  $('#demo1').attr('src', result); //图片链接（base64）
                        });
                    }
                    , done: function (res) {
                        //如果上传失败
                        if (res.status !=200) {
                            return layer.msg('上传失败');
                        }
                        uploadSuccess('',res.repsoneContent);
                        //上传成功
                    }
                    , error: function () {
                        //演示失败状态，并实现重传
                        //var demoText = $('#demoText');
                        demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                        demoText.find('.demo-reload').on('click', function () {
                            uploadInst.upload();
                        });
                    }
                })
            });
        }

    </script>
</head>

<body>
<div class="w_main clear">
    <div class="w_user_list left">
        <div class="u_top">
            <p class="top_hide">
                <span>站内聊天</span>
                <i class="r_p_kefu r_p_common_extent"></i>
                <!--<img class="hide_btn" src="/Template/default/static/img/icon_hide.png?timespan=1" alt="缩小">-->
            </p>
            <input type="text" id="applyCertNum" name="title" lay-verify="title" onchange="getchild();" autocomplete="off" placeholder="搜索"
                   class="layui-input search_input">
        </div>
        <div class="user_l_content">
            <div class="layui-collapse">

                <div class="layui-colla-item">

                    <div class="layui-colla-content layui-show user_name_info clear active" id="inroom_0" onclick="selectUser(0)" username="chatroom">
                        <div class="user_text left">
                            <p>聊天室</p>
                            <p></p>
                        </div>
                        <span class="right"></span>
                    </div>
                </div>


                <div class="layui-colla-item" id="left-userlist">

                       <h2 class="layui-colla-title">用户列表<span id="children_count"></span>/<?php echo ($count); ?></h2>
                    <?php if(is_array($users)): $i = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; if($v['userid'] != $self['userid']): ?><div class="layui-colla-content layui-show user_name_info clear <?php echo ($v["not_read"]); ?>"  last_login="<?php echo ($v["last_login"]); ?>"
                                 onclick="selectUser(<?php echo ($v["userid"]); ?>)" id="inroom_<?php echo ($v["userid"]); ?>"
                                 userid="<?php echo ($v["userid"]); ?>" fd="-1" username="<?php echo ($v["username"]); ?>" not_read_number="<?php echo ($v["not_read_number"]); ?>">
                                <img class="left" src="<?php echo ($v["avatar"]); ?>" alt="">
                                <div class="user_text left">
                                    <p><?php echo ($v["username"]); ?></p>
                                    <p></p>
                                </div>
                                <span class="right"></span>
                            </div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
        </div>
        <div class="group_content">
            <div class="g_c_click">
                <img class="group_send" src="/Template/default/static/img/icon_group.png" alt="">
                <span style="color: #7F8393; font-size: 14px; margin-left: 10px">群发</span>
            </div>
        </div>
    </div>
    <div class="w_user_info right">
        <!--群发-->
        <div class="group_main message_list clear" style="display: none">
            <div class="send_title">
                <span style='font-size: 18px; color: #363636; margin-right: 15px'>群发消息</span>
            </div>
            <div class="sfend_sent_text">
                <textarea class="layui-textarea" id="many_content" onkeydown="enter(event)"></textarea>
                <div class="select_face"><p class="i_sub_text">我的下级：</p>
                    <form class="layui-form" action="">
                        <input class="all_box" type="checkbox" lay-filter="all" name="checkboxAll" title="全选"
                               lay-skin="primary">
                    </form>
                </div>
                <div class="select_user">
                    <form class="layui-form" action="">
                        <!--<{if $parent.userid}>-->
                        <!--<input type="checkbox" lay-filter="singleBox" name="<?php echo ($parent["username"]); ?>" value="<?php echo ($parent["userid"]); ?>"-->
                        <!--title="<?php echo ($parent["username"]); ?>" lay-skin="primary"-->
                        <!--checked>-->
                        <!--<{/if}>-->
                        <?php if(is_array($users)): $i = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; if($v['userid'] != $self['userid']): ?><input type="checkbox" lay-filter="singleBox" name="<?php echo ($v["username"]); ?>" value="<?php echo ($v["userid"]); ?>"
                                      title="<?php echo ($v["username"]); ?>" lay-skin="primary"><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </form>
                </div>
                <button class="layui-btn right" onclick="sendAll();">发送</button>
                <button class="layui-btn layui-btn-primary right">取消</button>
            </div>
        </div>
        <!--给某人发-->
        <div class="alone_main message_list clear">
            <div class="send_title">
                <span style='font-size: 18px; color: #363636; margin-right: 15px' id="span_name"><?php echo ($self["username"]); ?></span>
                最后登录时间 <span id="last_login_time"><?php echo ($self["login_time"]); ?></span>
            </div>
            <div class="history_message" id="chat-messages">
                <p class="history_time"></p>
            </div>
            <div class="sent_text">
                <div class="select_face">
                    <img src="/Template/default/static/img/icon_face.png" alt="选择表情" onclick="toggleFace()" id="chat_face">
                    <img id="upload_button_middle" src="/Template/default/static/img/icon_img.png" alt="选择表情">
                    <!--<span id="upload_button" style="background-color: #f5f5f5;"></span>-->
                    <!--<span style="display: none"><input id="btnCancel" style="height: 25px;" type="button"-->
                    <!--value="取消上传" onclick="swfu.cancelQueue();"-->
                    <!--disabled="disabled"/></span>-->

                    <!--聊天表情弹出层-->
                    <div id="show_face" class="show_face"></div>
                </div>

                <textarea class="layui-textarea" id="msg_content"></textarea>
                <div class="right" style="line-height: 28px">
                    <span style="color: #7F8393; font-size: 14px; margin-right: 20px">Ctrl+Enter 折行</span>
                    <button class="layui-btn right" onclick="sendMsg($('#msg_content').val(),'text')">发送</button>
                </div>

            </div>
        </div>
    </div>
</div>
<style>
    .showone{
        display: none !important;
    }
</style>
<!--聊天表情弹出层结束-->
<script src="/Template/default/static/src/layui.js" charset="utf-8"></script>
<script>
    /*ctrl+enter换行*/
    var down=0;   //设置全局变量down，用来记录ctrl是否被按下；
    function enter(e){
        e = e || window.event;
        if(e.keyCode==17){
            down=1;      //ctrl按下
        }
        if(e.keyCode==13){
            if(down==1){
                document.getElementById("many_content").value+= '\r\n';
                down=0;     //换行后记得将全局变量置为1，否则enter将变成换行，失去发送功能
            }else{
                sendAll();  //执行按钮发送的功能
            }

        }
    }

    $("#applyCertNum").keydown(function(e) {
        if (e.keyCode == 13) {
            getchild();
        }
    });
    function getchild(){
        var val=$('#applyCertNum').val();
        if(val.length>0){
            $(".layui-colla-content").each(function(index,ele){
                var id=$(ele).attr('username');
                if(id.indexOf(val) >= 0){
                    $(ele).removeClass('showone');
                }else{
                    $(ele).addClass('showone');
                }
            });
        }else{
            $(".layui-colla-content").removeClass('showone');
        }
    }
    function sendAll() {
        send_user_list.splice(0, send_user_list.length);
        var i = 0;
        $('.layui-form .layui-form-checked').each(function (index, ele) {
            var val = $(ele).prev('input').val();
            addSend_user_list(val);
            i++;
        });
        if (i == 0) {
            layer.msg('请选择要发送的用户');
        } else {
            var manySendContent = $('#many_content').val();
            if (manySendContent.length > 0) {
                $('#many_content').val('');
                sendMsg(manySendContent, 'text');
                layer.msg('发送成功！！！');
            } else {
                layer.msg('不能发送空消息,请您输入内容,谢谢！！！');
            }
        }
    }
    layui.use('layer', function () { //独立版的layer无需执行这一句
        var $ = layui.jquery; //独立版的layer无需执行这一句
        $('.g_c_click').click(function () {
            $('.group_main').show();
            $('.alone_main').hide();
        });
        $('.user_name_info').click(function () {
            $('.group_main').hide();
            $('.alone_main').show();
        })
    });
    //注意：折叠面板 依赖 element 模块，否则无法进行功能性操作
    layui.use('element', function () {
        var element = layui.element;
        //…
    });
    layui.use('form', function () {
        var form = layui.form;
        //监听提交
        form.on('checkbox(all)', function (data) {
            var $ = layui.jquery;
            var checkbox = $('.select_user .layui-form-checkbox');
            if (data.elem.checked) {
                for (var i = 0; i < checkbox.length; i++) {
                    if (!$(checkbox[i]).hasClass('layui-form-checked')) {
                        $(checkbox[i]).click();
                    }
                }
            } else {
                for (var i = 0; i < checkbox.length; i++) {
                    if ($(checkbox[i]).hasClass('layui-form-checked')) {
                        $(checkbox[i]).click();
                    }
                }
            }
        });
        form.on('checkbox(singleBox)', function (data) {
            var $ = layui.jquery, flag = false;
            if (data.elem.checked) {
                var checkbox = $('.select_user .layui-form-checkbox');
                for (var i = 0; i < checkbox.length; i++) {
                    if (!$(checkbox[i]).hasClass('layui-form-checked')) {
                        flag = true;
                        break;
                    }
                }
                if (flag) {
                    if ($('.all_box').next().hasClass("layui-form-checked")) {
                        $('.all_box').next().removeClass('layui-form-checked')
                    }
                } else {
                    $('.all_box').next().addClass('layui-form-checked')
                }
            } else {
                if ($('.all_box').next().hasClass("layui-form-checked")) {
                    $('.all_box').next().removeClass('layui-form-checked')
                }
            }
        });
    });
</script>

</body>
</html>