@include('pdf.style')
@extends('pdf.header')
@section('title')
    <title>Etat</title>
@endsection
@section('content')
    <h1 style="text-align: center">Etat {{$cars[0]->maintenance_types[0]->label}} commune Massa </h1>
    <h1 style="text-align: center; text-transform: capitalize;"> {{$date}} </h1>
    <table class="table table-condensed table-bordered margin">
        <thead>
        <tr class="active">
            <th style="broder:1px solid black">N°</th>
            <th style="broder:1px solid black">Véhicule</th>
            <th style="broder:1px solid black">Immatriculation</th>
            <th style="broder:1px solid black">Ancien Kilométrage</th>
            <th style="broder:1px solid black">Date</th>
            <th style="broder:1px solid black">Index compteur actuel</th>
            <th style="broder:1px solid black">Reste en Km</th>
            <th style="broder:1px solid black">Observations</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($cars as $car)
            <tr style="broder:1px solid black">
                <td style="broder:1px solid black"> {{$loop->index+1}}</td>
                <td style="broder:1px solid black"> {{ $car->car_type->label }} {{  $car->car_brand->label }} {{ $car->model }}</td>
                <td style="broder:1px solid black"> {{$car->plate}}</td>
                <td style="broder:1px solid black">  {{ $car->maintenance_types->last()->pivot->km }}</td>
                <td style="broder:1px solid black">  {{ \Carbon\Carbon::parse($car->maintenance_types->last()->pivot->date)->format('d/m/Y') }}</td>
                <td style="broder:1px solid black">  {{ $car->kilometrage }}</td>
                <td style="broder:1px solid black">  {{ $car->maintenance_types->last()->pivot->next_km-$car->kilometrage }}</td>
                <td style="broder:1px solid black">  {!! $car->maintenance_types->last()->pivot->observation !!} </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @include('pdf.footer')
@endsection
