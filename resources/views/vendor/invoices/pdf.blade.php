<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Production Order {{ $order->id }} By {{ $order->user->name }}</title>

    <style>
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        th,td {

            font-size:14px;
        }

        table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 0px;
            border-spacing: 0;
            border-collapse: collapse;
            background-color: transparent;

        }

        thead  {
            text-align: left;
            display: table-header-group;
            vertical-align: middle;
        }

        th, td  {
            border: 1px solid #ddd;
            padding: 6px;
        }
        .well {
            min-height: 20px;
            padding: 19px;
            margin-bottom: 20px;
            background-color: #f5f5f5;
            border: 1px solid #e3e3e3;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
        }
    </style>
</head>

<body>
<div class="container mt-5">
        <h1 class="text-center mb-3">Production plan</h1>
        <h3 class="well">Formula {{$order->formula->name}} <b>{{$order->amount}}</b> kg ,  {{$order->times}} times</h3>
        <table class="table table-bordered mb-5">
            <thead>
            <tr >
                <th scope="col">Element</th>
                <th scope="col">Code</th>
                <th scope="col">Amount</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->formula->elements ?? '' as $element)
                <tr>
                    <td>{{ $element->name }}</td>
                    <td>{{ $element->code }}</td>
                    @php
                        $t = $element->pivot->amount * ($order->amount / $order->times) / 100 ;
                    @endphp

                    <td><b> @if($t > 1) {{$t}} kg  @else {{$t * 1000}} g  @endif</b></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    <br /><br />
    <div>
        <small>{{ now() }} printed by {{auth()->user()->name}}</small>
    </div>




</div>

</body>

</html>
