<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('libs/bootstrap/css/bootstrap.min.css')}}">
</head>
<body>
    <div class="form-group">
        <label>Name</label>
        <input type="input" name="name" id="name" class="form-control" placeholder="Name">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="input" class="form-control" id="email" placeholder="Email">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="pwd" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-default" id="btn">报名</button>
    <script src="{{asset('libs/bootstrap/js/jquery.min.js')}}"></script>
    <script src="{{asset('libs/bootstrap/js/bootstrap.min.js')}}"></script>
</body>
<script>
    $('#btn').click(function () {
        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#pwd').val();
        $.ajax({
            data:{name: name, email: email, password: password, _token:'{{csrf_token()}}'},
            type: 'post',
            url: '{{url('index')}}',
            dataType: 'json',
            success: function (data) {
                if (data.success==1) {
                    location.href = '{{url("confirm")}}';
                } else {
                    alert(data.tip);
                }
            }
        });
    });
</script>
</html>