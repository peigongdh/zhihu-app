ws = new WebSocket("ws://devzhihu.zhangpei.online:11130");

// 服务端主动推送消息时会触发这里的onmessage
ws.onmessage = function (e) {
    alert(e);
    // json数据转换成js对象
    var data = eval("(" + e.data + ")");
    var type = data.type || '';
    switch (type) {
        // Events.php中返回的init类型的消息，将client_id发给后台进行uid绑定
        case 'init':
            // 利用jquery发起ajax请求，将client_id发给后端进行uid绑定
            $.post('./bind.php', {client_id: data.client_id}, function (data) {
            }, 'json');
            break;
        // 当mvc框架调用GatewayClient发消息时直接alert出来
        default :
            alert(e.data);
    }
};