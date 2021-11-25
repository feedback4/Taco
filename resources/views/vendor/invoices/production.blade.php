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
        <h1 class="text-center mb-3">Production Order</h1>
        <h3 class="well">Formula {{$order->formula->name}} <b>{{$order->amount}}</b>  kg</h3>
        <table class="table table-bordered mb-5">
            <thead>
            <tr >
                <th scope="col">Element</th>
                <th scope="col">Code</th>
                <th scope="col">Amount</th>
                <th scope="col">Expire</th>
                <th scope="col">Inventory</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->items ?? '' as $item)
                <tr>
                    <td>{{ $item->element->name }}</td>
                    <td>{{ $item->element->code }}</td>
                    <td>{{ $item->pivot->amount }} kg</td>
                    <td class="border  py-2">{{$item->expire_at->format('d/m/Y')}}</td>
                    <td>{{ $item->inventory->name }}</td>

                </tr>
                <td> {!! DNS1D::getBarcodeHTML('15998321875', 'C39') !!}</td>
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
