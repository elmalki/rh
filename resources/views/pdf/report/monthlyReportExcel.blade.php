<table border="1">
    <tbody>
    <tr class="active">
        <td colspan="3" style="text-align: center;vertical-align: center;">
            ROYAUME DU MAROC<br>
            MINISTÈRE DE L'INTÉRIEUR<br>
            PROVINCE DE CHTOUKA AIT BAHA<br>
            CERCLE BELFAA-MASSA<br>
            CAIDAT MASSA<br>
            COMMUNE TERRITORIALE DE MASSA
        </td>

    </tr>
    <tr class="active">
        <td colspan="8" rowspan="2" style="vertical-align: top; text-align: center;">
            État des consommations du: Gasoil, Lubrifiant et Entretien
            <br>
            Du Mois: <span style="text-transform: uppercase">{{$date}}</span>
        </td>

    </tr>
    </tbody>
</table>
@php
    $total_gasoils = 0;
    $total_lubrifiants = 0;
    $total_entretients = 0;
@endphp
<table style="table-layout: auto;">
    <tbody>
    @foreach ($items as $operations)
        @php
            $car_gasoils = 0;
            $car_lubrifiants = 0;
            $car_entretients = 0;

        @endphp

        <tr class="active">
            <td colspan="8" data-format="0.00" bgcolor="#90ee90" align="center" style="border:1px solid #000; text-align: center; vertical-align: center;">
                <strong>
                    {{ $operations[0]->car->car_type->label }} {{  $operations[0]->car->car_brand->label }} {{ $operations[0]->car->model }}
                    {{$operations[0]->car->plate}}
                    <span  data-format="0.00">( {{$operations->sum('maintenance.montant')+$operations->sum('dotation.value')}} Dhs )</span>

                </strong>
            </td>
        </tr>
        <tr class="active">
            <td style="border:1px solid #000; font-weight: bold; text-align: center; vertical-align: center;" bgcolor="#e1e1e1">N°</td>
            <td style="border:1px solid #000; font-weight: bold; text-align: center; vertical-align: center;" bgcolor="#e1e1e1">Date</td>
            <td style="border:1px solid #000; font-weight: bold; text-align: center; vertical-align: center;" bgcolor="#e1e1e1">Gasoil</td>
            <td style="border:1px solid #000; font-weight: bold; text-align: center; vertical-align: center;" bgcolor="#e1e1e1">Lubrifiant</td>
            <td style="border:1px solid #000; font-weight: bold; text-align: center; vertical-align: center;" bgcolor="#e1e1e1">Entretien</td>
            <td style="border:1px solid #000; font-weight: bold; text-align: center; vertical-align: center;" bgcolor="#e1e1e1">Compteur actuel</td>
            <td style="border:1px solid #000; font-weight: bold; text-align: center; vertical-align: center;" bgcolor="#e1e1e1">N° Bon</td>
            <td style="border:1px solid #000; font-weight: bold; text-align: center; vertical-align: center;" bgcolor="#e1e1e1">Observations</td>
        </tr>
        @foreach ($operations as $operation)
            <tr style="border:1px solid #000; text-align: center; vertical-align: center;">
                <td style="border:1px solid #000; text-align: center; vertical-align: center;"> {{$loop->index+1}}</td>
                <td style="border:1px solid #000; text-align: center; vertical-align: center;">  {{ $operation->date}}</td>
                @if($operation->dotation_id)
                    @php
                        $car_gasoils+=$operation->dotation->value;
                    @endphp
                    <td style="border:1px solid #000; text-align: center; vertical-align: center;"
                        data-format="0.00">  {{ $operation->dotation->value }}</td>
                    <td style="border:1px solid #000; text-align: center; vertical-align: center;">-</td>
                    <td style="border:1px solid #000; text-align: center; vertical-align: center;">-</td>
                @else
                    <td style="border:1px solid #000; text-align: center; vertical-align: center;">-</td>
                    <td style="border:1px solid #000; text-align: center; vertical-align: center;" data-format="0.00">
                        @php
                            $lubrifiants = max($operation->maintenance->maintenance_types->filter(function ( $value){
                                   return $value->maintenance_category?->label=='Lubrifiant';
                               })->sum('pivot.montant'),0);
                            $car_lubrifiants+=$lubrifiants;
                            $car_entretients+= $operation->maintenance->montant;
                        @endphp
                        {{$lubrifiants}}
                    </td>
                    <td style="border:1px solid #000; text-align: center; vertical-align: center;"
                        data-format="0.00">  {{ $operation->maintenance->montant-$lubrifiants }}</td>
                @endif
                <td style="border:1px solid #000; text-align: center; vertical-align: center;">  {{ $operation->car->kilometrage }}</td>
                <td style="border:1px solid #000; text-align: center; vertical-align: center;">  {{ $operation->dotation?->n_bon }} {{ $operation->maintenance?->n_bon }}</td>
                <td style="border:1px solid #000; text-align: center; vertical-align: center; min-width: fit-content;">
                    @if($operation->maintenance_id)
                        @foreach( $operation->maintenance->maintenance_types as $item)
                            @if($loop->index>0)
                                <br>
                            @endif
                            {{$item->label}} ({{$item->pivot->montant}}dhs) {{$item->pivot->observation}}
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
            <td bgcolor="yellow" style=" font-weight: bold;border:1px solid #000; text-align: center; vertical-align: center;" colspan="2">Total</td>
            <td bgcolor="yellow" style=" font-weight: bold;border:1px solid #000; text-align: center; vertical-align: center;"
                data-format="0.00">{{$car_gasoils}}</td>
            <td bgcolor="yellow" style=" font-weight: bold;border:1px solid #000; text-align: center; vertical-align: center;"
                data-format="0.00">{{$car_lubrifiants}}</td>
            <td bgcolor="yellow" style=" font-weight: bold;border:1px solid #000; text-align: center; vertical-align: center;"
                data-format="0.00">{{$car_entretients-$car_lubrifiants}}</td>
            <td colspan="3"></td>
        </tr>
        <tr></tr>
    @endforeach
    </tbody>
</table>
<table style="table-layout: auto;">
    <tbody>
    <tr style="">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td bgcolor="#d3d3d3" style="border:1px solid #000;font-weight: bold; text-align: center; vertical-align: center;">Gasoil</td>
        <td bgcolor="#d3d3d3" style="border:1px solid #000;font-weight: bold; text-align: center; vertical-align: center;">Lubrifiant</td>
        <td bgcolor="#d3d3d3" style="border:1px solid #000;font-weight: bold; text-align: center; vertical-align: center;">Entretien</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td colspan="2" bgcolor="#add8e6" style="border:1px solid #000;font-weight: bold; text-align: center;">TOTAL ({{$total_gasoils-$total_lubrifiants+$total_entretients}})</td>
        <td bgcolor="#add8e6" data-format="0.00" style="border:1px solid #000;font-weight: bold; text-align: center;">{{$total_gasoils}}</td>
        <td bgcolor="#add8e6" data-format="0.00" style="border:1px solid #000;font-weight: bold; text-align: center;">{{$total_lubrifiants}}</td>
        <td bgcolor="#add8e6" data-format="0.00" style="border:1px solid #000;font-weight: bold; text-align: center;">{{$total_entretients}}</td>
    </tr>
    <tr></tr>
    <tr bgcolor="#F6BB00">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2">Massa le:...........</td>
    </tr>
    <tr></tr>
    <tr>
        <td colspan="4" style="text-align: center;">Le Responsable du Parc</td>
        <td colspan="4"  style="vertical-align: top; text-align: center;">Vice Président, chargée au secteur des travaux communaux</td>
    </tr>
    <tr></tr>
    <tr>
        <td colspan="4" style="text-align: center;">Jamal Radi</td>
        <td colspan="4"  style="vertical-align: top; text-align: center;">Naima AIT BY</td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
        <td colspan="8"  style="vertical-align: top; text-align: center;">Représentant de la Sté. Chargée de la fourniture du carburant, lubrifiant et d'entretien  </td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
        <td colspan="8" style="vertical-align: top; text-align: center;">VISA du président de la Commune de Massa</td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    </tbody>
</table>

