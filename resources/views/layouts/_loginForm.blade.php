<div class="col-xs-offset-3 col-xs-4 loginForm" style="display: {{ $display }};z-index: 1" id="loginForm">
    <h3 style="margin:0px 0px 25px 0px;">登录</h3>
    <form class="form-horizontal" action="{{ route('login') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="phone" class="col-xs-4 control-label">电话号码：</label>
            <div class="col-xs-8">
                <input type="text" id="loginPhone" name="phone" class="form-control" value="{{old('phone')}}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="passwd" class="col-xs-4 control-label">密码：</label>
            <div class="col-xs-8">
                <input id="passwd" type="password" name="password" class="form-control" required>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-offset-3 col-xs-6">
                <button class="btn btn-primary col-xs-12" style="margin:30px 0 0 0;" type="submit" name="button">登录
                </button>
            </div>
        </div>

    </form>
</div>