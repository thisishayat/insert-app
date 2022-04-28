@include('header')

<body>
{{--{{dd(($getData))}}--}}
<div class="container">
    <h4>Completed: {{$get_complete}}</h4>
    <h4>Pendig: {{$get_not_complete}}</h4>

    <table class="table table-bordered">

        <tbody>

        @if(isset($getData['total']) && $getData['total'] > 0)
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">call_number</th>
                <th scope="col">call_receive_number</th>
{{--                <th scope="col">No. of Try</th>--}}
                <th scope="col">input_date_time</th>
                <th scope="col">start_end</th>
                <th scope="col">remarks</th>
                <th scope="col">created_at</th>
                <th scope="col">updated_at</th>
                <th scope="col">Current Status</th>
                <th scope="col">Action</th>
            </tr>
            </thead>

        @foreach($result as $val)
        <tr>
{{--            <th scope="row">{{$val[0]['id']}}</th>--}}
{{--            <td>{{$val[0]['call_number']}}</td>--}}
{{--            <td value_id={{$val[0]['call_receive_number']}} id="call_receive_number">{{$val[0]['call_receive_number']}}</td>--}}
{{--            <td>{{count($val)}}</td>--}}
{{--            <td>{{$val[0]['input_date_time']}}</td>--}}
{{--            <td>{{$val[0]['start_end']}}</td>--}}
{{--            <td>{{$val[0]['remarks']}}</td>--}}
{{--            <td>{{$val[0]['created_at']}}</td>--}}
{{--            <td>{{$val[0]['updated_at']}}</td>--}}
{{--            <td>{{$val[0]['status']}}</td>--}}

{{--            <td><a class="btn btn-primary" role="button"  onclick="updateData({{$val[0]['id']}},1)">Status Update Here</a></td>--}}

            <th scope="row">{{$val['id']}}</th>
            <td>{{$val['call_number']}}</td>
            <td value_id={{$val['call_receive_number']}} id="call_receive_number">{{$val['call_receive_number']}}</td>
{{--            <td>{{count($val)}}</td>--}}
            <td>{{$val['input_date_time']}}</td>
            <td>{{$val['start_end']}}</td>
            <td>{{$val['remarks']}}</td>
            <td>{{$val['created_at']}}</td>
            <td>{{$val['updated_at']}}</td>
            <td>{{$val['status']}}</td>

            <td><a class="btn btn-primary" role="button"  onclick="updateData({{$val['id']}},1)">Status Update Here</a></td>

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
