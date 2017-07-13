<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
            integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

</head>
<body>

<div class="col-md-12">
    <br>
    <h2>Services Contracts Payments in Month</h2>
    <h3>{{ $contractText }}</h3>
    <br>

    <table class="table table-bordered table-sm">
        <thead style="display: table-row-group;">
            <tr>
                @foreach($titles as $title)
                    <th>{{ $title }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    @foreach($attributes as $attribute)
                        @if ($loop->first)
                            <td scope="row">{{$item->$attribute}}</td>
                        @else
                            <td >{{$item->$attribute}}</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
