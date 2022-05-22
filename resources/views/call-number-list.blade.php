@include('header')
<body>
<div class="container">

    <table class="table table-bordered">
        <button style="float: right"><a  href="/en/new-number">Add New</a></button>

        <tbody>
        @if(isset($getData['total']) && $getData['total'] > 0)
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">email</th>
                <th scope="col">call_receive_number</th>
                <th scope="col">start_end</th>
                <th scope="col">service_id</th>
                <th scope="col">edit</th>
                <th scope="col">delete</th>
            </tr>
            </thead>
        @foreach($result as $val)
        <tr>
            <td>{{$val['id']}}</td>
            <td>{{$val['email']}}</td>
            <td>{{$val['call_receive_number']}}</td>
            <td>{{$val['start_end']}}</td>
            <td>{{$val['service_id']}}</td>
            <td><a href="/en/edit-number/{{$val['id']}}">Edit</a></td>
            <td><a href="/en/delete-number/{{$val['id']}}">Delete</a></td>

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

</body>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
<script>
    function updateData(id,status){
        var ans=confirm("Are you sure to change status?");
        if(!ans) {
            return false;
        }
        var call_receive_number = $("#call_receive_number").attr('value_id');
        console.log(call_receive_number);
        var settings = {
            async: true,
            crossDomain: true,
            contentType: "application/json; charset=utf-8",
            dataType: "json",

            url: "/en/update-status?id="+id+"&status="+status+"&call_receive_number="+call_receive_number,
            method: "GET",
            headers: {
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

</html>
