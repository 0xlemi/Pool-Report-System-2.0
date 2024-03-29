<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
            integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

	<title>PDF | Services Contracts Payments in Month</title>

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
    <br>
    <table class="table table-bordered table-sm">
        <thead style="display: table-row-group;">
            <tr>
                <th></th>
                @foreach(config('constants.currencies') as $currency)
                    <th>{{ $currency }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <td scope="row">Total Charged</td>
                @foreach($totalCharged as $charged)
                        <td>{{ $charged }}</td>
                @endforeach
            </tr>
            <tr>
                <td scope="row">Total Paid</td>
                @foreach($totalPaid as $paid)
                        <td>{{ $paid }}</td>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>

</body>
</html>
