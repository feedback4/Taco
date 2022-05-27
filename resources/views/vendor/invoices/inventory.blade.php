<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Production Order {{ $order->id }} By {{ $order->user->name }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        body {
            direction: rtl;
            width: 210mm;
            height: 297mm;
            margin: auto;
        }

        th,td {

            font-size:16px;
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
        .logo{
            height: 50mm ;
        }
        img{
            height: 100%;
        }
    </style>
</head>

<body>
<div class="container mt-5">
    <header class="nav">
        @if(setting('show_logo') == true)
            <div class="logo mx-auto">
                <img src="{{asset(setting('company_logo')) }}" alt="company logo">
            </div>
        @endif
    </header>
        <h1 class="text-center my-3">Production Order</h1>
        <h3 class="well">Formula {{$order->formula->name}} <b>{{$order->amount}}</b>  kg</h3>
        <table class="table table-bordered mb-5">
            <thead>
            <tr >
                <th scope="col">Element</th>
                <th scope="col">Amount</th>
                <th scope="col">Created</th>
                <th scope="col">Inventory</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->items ?? '' as $item)
                <tr>
                    <td>{{ $item->element->name }} -- {{ $item->element->code }}</td>
                    <td>{{ number_format($item->pivot->amount   , 2)  + 0}} kg</td>
                    <td class="border  py-2">{{$item->created}}</td>
                    <td>{{ $item->inventory->name }}</td>

                </tr>
                <td colspan="5"> {!! DNS1D::getBarcodeSVG($item->id, 'C39') !!}</td>
            @endforeach
            </tbody>
        </table>
    <br /><br />



        <footer  class="footer text-center fixed-bottom">
            <small>{{ now() }} printed by {{auth()->user()->name}}</small>
        </footer>
</div>
<script>
    window.print()
</script>
</body>

</html>
