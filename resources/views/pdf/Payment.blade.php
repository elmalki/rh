@include('pdf.style')
@extends('pdf.header')
@section('title')
    <title>Etat</title>
@endsection
@section('content')
    <h4 style="text-align: center">Divulgation du contrôle et statistiques des jours de travail des agents de la
        promotion nationale du mois <span
            style="text-decoration: underline;"> {{$title_date}} Du {{$start}} au {{$end}} </span></h4>
    @php
        $total_days=0;
    @endphp
    <table class="table table-condensed table-bordered margin">
        <thead>
        <tr class="active">
            <th style="broder:1px solid black" rowspan="2">Nom Complet</th>
            <th style="broder:1px solid black" rowspan="2">CNIE</th>
            <th colspan="16"> Première moitiée du mois</th>
            <th style="broder:1px solid black;width: 10px" rowspan="2">Nbre de jours</th>
            <th style="broder:1px solid black;width: 10px" rowspan="2">Taux</th>
            <th style="broder:1px solid black;width: 10px" rowspan="2">Montant(Dhs)</th>
            <th style="broder:1px solid black" rowspan="2">Observations</th>
        </tr>
        <tr>
            @for($i=1;$i<=15;$i++)
                <th style="broder:1px solid black;width: 15px">{{$i}}</th>
            @endfor
            <th style="broder:1px solid black;width: 15px"></th>

        </tr>
        </thead>
        <tbody>
        @foreach ($workers as $worker)
            @php
                $days=0;
            @endphp
            <tr >
                <td style="broder:1px solid black"> {{$worker->nom_complet}}</td>
                <td style="broder:1px solid black"> {{$worker->cnie}}</td>
                @for($i=1;$i<=15;$i++)
                    @if($worker['dates']->contains($i))
                        <td style="broder:1px solid black;font-weight: bold">X
                        </td>
                        @php
                            $days++;
                            $total_days++;
                        @endphp
                    @else
                        <td style="broder:1px solid black;font-weight: bold" bgcolor="#f6f6f6">
                        </td>
                    @endif
                @endfor
                <td style="broder:1px solid black" bgcolor="gray"></td>
                <td style="broder:1px solid black">{{$days}}</td>
                <td style="broder:1px solid black">{{$worker->pointages->first()->wage}}</td>
                <td style="broder:1px solid black">{{$worker->pointages->first()->wage*$days}}</td>
                <td style="broder:1px solid black"></td>

            </tr>
        @endforeach
        <tr style="font-weight: bold" bgcolor="#faebd7">
            <td style="broder:1px solid black" colspan="18">TOTAL</td>
            <td style="broder:1px solid black">{{$total_days}}</td>
            <td style="broder:1px solid black">{{$workers->first()->pointages->first()->wage}}</td>
            <td style="broder:1px solid black">{{$workers->first()->pointages->first()->wage*$total_days}}</td>
            <td style="broder:1px solid black" bgcolor="#d3d3d3"></td>
        </tr>
        </tbody>
    </table>
    @php
        $total_days=0;
    @endphp
    <table class="table table-condensed table-bordered margin">
        <thead>
        <tr class="active">
            <th style="broder:1px solid black" rowspan="2">Nom Complet</th>
            <th style="broder:1px solid black" rowspan="2">CNIE</th>
            <th colspan="16">Deuxième moitiée du mois</th>
            <th style="broder:1px solid black;width: 10px" rowspan="2">Nbre de jours</th>
            <th style="broder:1px solid black;width: 10px" rowspan="2">Taux</th>
            <th style="broder:1px solid black;width: 10px" rowspan="2">Montant(Dhs)</th>
            <th style="broder:1px solid black" rowspan="2">Observations</th>
        </tr>
        <tr>
            @for($i=16;$i<=31;$i++)
                <th style="broder:1px solid black;width: 15px">{{$i}}</th>
            @endfor

        </tr>
        </thead>
        <tbody>
        @foreach ($workers as $worker)
            @php
                $days=0;
            @endphp
            <tr >
                <td style="broder:1px solid black"> {{$worker->nom_complet}}</td>
                <td style="broder:1px solid black"> {{$worker->cnie}}</td>
                @for($i=16;$i<=31;$i++)
                    @if($worker['dates']->contains($i))
                        <td style="broder:1px solid black;font-weight: bold">X
                        </td>
                        @php
                            $days++;
                            $total_days++;
                        @endphp
                    @else
                        <td style="broder:1px solid black;font-weight: bold" bgcolor="#f6f6f6">
                        </td>
                    @endif
                @endfor
                <td style="broder:1px solid black">{{$days}}</td>
                <td style="broder:1px solid black">{{$worker->pointages->first()->wage}}</td>
                <td style="broder:1px solid black">{{$worker->pointages->first()->wage*$days}}</td>
                <td style="broder:1px solid black"></td>

            </tr>
        @endforeach
        <tr style="font-weight: bold" bgcolor="#faebd7">
            <td style="broder:1px solid black" colspan="18">TOTAL</td>
            <td style="broder:1px solid black">{{$total_days}}</td>
            <td style="broder:1px solid black">{{$workers->first()->pointages->first()->wage}}</td>
            <td style="broder:1px solid black">{{$workers->first()->pointages->first()->wage*$total_days}}</td>
            <td style="broder:1px solid black" bgcolor="#d3d3d3"></td>
        </tr>
        </tbody>
    </table>
    @include('pdf.footer')
@endsection
