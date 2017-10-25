var socketConfig = 'wss://uhihz.peigongdh.com:11130';

function init(csrfToken, apiToken) {
    var ws;

    if (!ws) {
        try {
            ws = new WebSocket(socketConfig);

            ws.onmessage = function (e) {
                var data = eval("(" + e.data + ")");
                var type = data.type || '';
                switch (type) {
                    case 'init':
                        $.ajax({
                            type: 'POST',
                            url: '/api/bind',
                            headers: {
                                "X-CSRF-TOKEN": csrfToken,
                                "Authorization": apiToken
                            },
                            data: {
                                client_id: data.client_id
                            }
                        }).done(function (data) {
                            console.log("ws connect result:" + data.status)
                        });
                        break;
                    case 'ping':
                        console.log("ping");
                        break;
                    case 'action':
                        // todo
                        console.log("action: " + data.data);
                        break;
                    default :
                        console.log("unknown message, drop");
                }
            };
        } catch (e) {
            console.log('websocket connect failed: ' + e.message);
        }
    } else {
        console.log("ws keep connection")
    }
};

let csrfToken = document.head.querySelector('meta[name="csrf-token"]');
let apiToken = document.head.querySelector('meta[name="api-token"]');

if (csrfToken.content && apiToken.content) {
    if (document.location.pathname == "/timeline") {
        init(csrfToken.content, apiToken.content);
    }
} else {
    console.log('csrf token or api token not found');
}
