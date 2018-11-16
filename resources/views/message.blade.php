<html>
<head>
    <title>Laravel Ajax示例</title>

    <script src="js/app.js">
    </script>

    <meta name="_token" content="{{ csrf_token() }}"/>

    <script>
        function getMessage() {
            $.ajax({

                type: 'post',

                url: '/getmsg',

                data: {'date': '2015-03-12'},

                dataType: 'json',

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                },

                success: function (data) {
                    console.log(data);
                    $("#msg").html(data.msg);
                },
                error: function (data, json, errorThrown) {
                    console.log(data);
                    var errors = data.responseJSON.errors.date;
                    $("#msg").html(errors);
                }
                /*error: function(XMLHttpRequest, textStatus, errorThrown) {
                 alert(XMLHttpRequest.status);
                 alert(XMLHttpRequest.readyState);
                 alert(textStatus);
                 alert(errorThrown);
                   }*/

            });
        }

    </script>
</head>

<body>
<div id='msg'>这条消息将会使用Ajax来替换.
    点击下面的按钮来替换此消息.
</div>

<button onClick="getMessage()">替换消息</button>
</body>

</html>
