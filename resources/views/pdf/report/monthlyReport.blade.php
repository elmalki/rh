@include('pdf.style')
@extends('pdf.header')
@section('title')
    <title>Etat</title>
@endsection
@section('content')
    <h1 style="text-align: center">Etat des consommations du: Gasoil, lubrifiant et entretien </h1>
    <h1 style="text-align: center; text-transform: capitalize;"> {{$date}} </h1>
    @php
        $total_gasoils = 0;
        $total_lubrifiants = 0;
        $total_entretients = 0;
    @endphp
    @foreach ($items as $operations)
        @php
            $car_gasoils = 0;
            $car_lubrifiants = 0;
            $car_entretients = 0;
        @endphp
        <table class="table table-condensed table-bordered margin">
            <thead>
            <tr class="active">
                <td colspan="8" style="broder:1px solid black">
                    <strong>
                        {{ $operations[0]->car->car_type->label }} {{  $operations[0]->car->car_brand->label }} {{ $operations[0]->car->model }}
                        {{$operations[0]->car->plate}}
                    </strong>
                </td>
            </tr>
            <tr class="active">
                <th style="broder:1px solid black">N°</th>
                <th style="broder:1px solid black">Date</th>
                <th style="broder:1px solid black">Gasoil</th>
                <th style="broder:1px solid black">Lubrifiant</th>
                <th style="broder:1px solid black">Entretien</th>
                <th style="broder:1px solid black">Compteur actuel</th>
                <th style="broder:1px solid black">N° Bon</th>
                <th style="broder:1px solid black">Observations</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($operations as $operation)
                <tr style="broder:1px solid black">
                    <td style="broder:1px solid black"> {{$loop->index+1}}</td>
                    <td style="broder:1px solid black">  {{ $operation->date}}</td>
                    @if($operation->dotation_id)
                        @php
                            $car_gasoils+=$operation->dotation->value;
                        @endphp
                        <td style="broder:1px solid black">  {{ $operation->dotation->value }}</td>
                        <td style="broder:1px solid black">-</td>
                        <td style="broder:1px solid black">-</td>
                    @else
                        <td style="broder:1px solid black">-</td>
                        <td style="broder:1px solid black">
                            @php
                                $lubrifiants = $operation->maintenance->maintenance_types->filter(function ( $value){
                                       return $value->maintenance_category?->label=='Lubrifiant';
                                   })->sum('montant');
                                $car_lubrifiants+=$lubrifiants;
                                $car_entretients+= $operation->maintenance->montant;
                            @endphp
                            {{$lubrifiants}}
                        </td>
                        <td style="broder:1px solid black">  {{ $operation->maintenance->montant }}</td>
                    @endif
                    <td style="broder:1px solid black">  {{ $operation->car->kilometrage }}</td>
                    <td style="broder:1px solid black">  {{ $operation->dotation?->n_bon }} {{ $operation->maintenance?->n_bon }}</td>
                    <td style="broder:1px solid black">
                        @if($operation->maintenance_id)
                            @foreach( $operation->maintenance->maintenance_types as $item)
                                <div>
                                    {{$item->label}} ({{$item->pivot->montant}}dhs) {{$item->pivot->observation}}
                                </div>
                            @endforeach
                        @endif

                    </td>
                </tr>
            @endforeach
            @php
                $total_gasoils +=$car_gasoils;
                $total_entretients+=$car_entretients;
                $total_lubrifiants +=$car_lubrifiants;
            @endphp
            <tr>
                <td colspan="2">Total</td>
                <td>{{$car_gasoils}}</td>
                <td>{{$car_lubrifiants}}</td>
                <td>{{$car_entretients}}</td>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td colspan="2">Total</td>
                <td colspan="3">{{$car_gasoils+$car_lubrifiants+$car_entretients}}</td>
                <td colspan="3"></td>
            </tr>
            </tbody>
        </table>
    @endforeach

    @include('pdf.footer')
@endsection
