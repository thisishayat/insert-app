
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <link rel="canonical" href="https://getbootstrap.com/docs/3.3/examples/signin/">

    <title>Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="https://getbootstrap.com/docs/3.3/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src=".https://getbootstrap.com/docs/3.3/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

</head>

<style>
    body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #eee;
    }

    .form-signin {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-signin .form-signin-heading,
    .form-signin .checkbox {
        margin-bottom: 10px;
    }
    .form-signin .checkbox {
        font-weight: normal;
    }
    .form-signin .form-control {
        position: relative;
        height: auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        padding: 10px;
        font-size: 16px;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>

<body>
{{--{{dd(($getData))}}--}}

<div class="container">
    <h4>Completed: {{$get_complete}}</h4>
    <h4>Pendig: {{$get_not_complete}}</h4>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">call_number</th>
            <th scope="col">call_receive_number</th>
            <th scope="col">input_date_time</th>
            <th scope="col">start_end</th>
            <th scope="col">remarks</th>
            <th scope="col">created_at</th>
            <th scope="col">updated_at</th>
            <th scope="col">Current Status</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>

        @if(isset($getData['total']) && $getData['total'] > 0)
        @foreach($getData['data'] as $d)
        <tr>
            <th scope="row">{{$d['id']}}</th>
            <td>{{$d['call_number']}}</td>
            <td>{{$d['call_receive_number']}}</td>
            <td>{{$d['input_date_time']}}</td>
            <td>{{$d['start_end']}}</td>
            <td>{{$d['remarks']}}</td>
            <td>{{$d['created_at']}}</td>
            <td>{{$d['updated_at']}}</td>
            <td>{{$d['status']}}</td>

            <td><a class="btn btn-primary" role="button" onclick="updateData({{$d['id']}},{{$d['status']==0?1:0}})">Status Update Here</a></td>

        </tr>
        @endforeach
        @else
            <h2>No data found. Please try later.</h2>
        @endif

        @if(isset($getData['total']) && $getData['total'] > 0)
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="{{$getData['first_page_url']}}">First Page</a></li>
                    @if(isset($getData['prev_page_url']))
                        <li class="page-item"><a class="page-link" href="{{$getData['prev_page_url']}}">Prev Page</a></li>
                    @endif
                    @if(isset($getData['next_page_url']))
                        <li class="page-item"><a class="page-link" href="{{$getData['next_page_url']}}">Next Page</a></li>
                    @endif
                    <li class="page-item"><a class="page-link" href="{{$getData['last_page_url']}}">Last Page</a></li>
                </ul>
            </nav>
        @endif
        </tbody>
    </table>


</div> <!-- /container -->


<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
<script>
    function updateData(id,status){
        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "http://localhost:8000/en/update-status?id="+id+"&status="+status,
            "method": "GET",
            "headers": {
                "authorization": "Bearer c2bca4367022daf236293e1e98964a60",
                "cache-control": "no-cache",
                "postman-token": "907b4be9-77a5-01c0-49fa-1e629da387d4"
            }
        }

        $.ajax(settings).done(function (response) {
            console.log(response);
            location.reload();

        });
    }

</script>
</body>
</html>
