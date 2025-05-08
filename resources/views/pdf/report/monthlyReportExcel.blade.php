<table border="1">
    <tbody>
    <tr class="active">
        <td colspan="3" style="text-align: center;vertical-align: center;">
            ROYAUME DU MAROC<br>
            MINISTÈRE DE L'INTÉRIEUR<br>
            PROVINCE DE CHTOUKA AIT BAHA<br>
            CERCLE BELFAA-MASSA<br>
            CAIDAT MASSA<br>
            COMMUNE TERRITORIALE DE MASSA<br>
        </td>

    </tr>
    <tr class="active">
        <td colspan="8" rowsapn="2" style="vertical-align: top; text-align: center;">
            Etat des consommations du: Gasoil, lubrifiant et entretien du mois: <span style="text-transform: uppercase">{{$date}}</span>
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
            <td colspan="8" bgcolor="#d3d3d3" align="center" style="border:1px solid #000; text-align: center;">
                <strong>
                    {{ $operations[0]->car->car_type->label }} {{  $operations[0]->car->car_brand->label }} {{ $operations[0]->car->model }}
                    {{$operations[0]->car->plate}}
                </strong>
            </td>
        </tr>
        <tr class="active">
            <td style="border:1px solid #000; text-align: center;">N°</td>
            <td style="border:1px solid #000; text-align: center;">Date</td>
            <td style="border:1px solid #000; text-align: center;">Gasoil</td>
            <td style="border:1px solid #000; text-align: center;">Lubrifiant</td>
            <td style="border:1px solid #000; text-align: center;">Entretien</td>
            <td style="border:1px solid #000; text-align: center;">Compteur actuel</td>
            <td style="border:1px solid #000; text-align: center;">N° Bon</td>
            <td style="border:1px solid #000; text-align: center;">Observations</td>
        </tr>
        @foreach ($operations as $operation)
            <tr style="border:1px solid #000; text-align: center;">
                <td style="border:1px solid #000; text-align: center;"> {{$loop->index+1}}</td>
                <td style="border:1px solid #000; text-align: center;">  {{ $operation->date}}</td>
                @if($operation->dotation_id)
                    @php
                        $car_gasoils+=$operation->dotation->value;
                    @endphp
                    <td style="border:1px solid #000; text-align: center;"
                        data-format="0.00">  {{ $operation->dotation->value }}</td>
                    <td style="border:1px solid #000; text-align: center;">-</td>
                    <td style="border:1px solid #000; text-align: center;">-</td>
                @else
                    <td style="border:1px solid #000; text-align: center;">-</td>
                    <td style="border:1px solid #000; text-align: center;" data-format="0.00">
                        @php
                            $lubrifiants = $operation->maintenance->maintenance_types->filter(function ( $value){
                                   return $value->maintenance_category?->label=='Lubrifiant';
                               })->sum('montant');
                            $car_lubrifiants+=$lubrifiants;
                            $car_entretients+= $operation->maintenance->montant;
                        @endphp
                        {{$lubrifiants}}
                    </td>
                    <td style="border:1px solid #000; text-align: center;"
                        data-format="0.00">  {{ $operation->maintenance->montant }}</td>
                @endif
                <td style="border:1px solid #000; text-align: center;">  {{ $operation->car->kilometrage }}</td>
                <td style="border:1px solid #000; text-align: center;">  {{ $operation->dotation?->n_bon }} {{ $operation->maintenance?->n_bon }}</td>
                <td style="border:1px solid #000; text-align: center; min-width: fit-content;">
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
            <td bgcolor="yellow" style="border:1px solid #000; text-align: center;" colspan="2">Total</td>
            <td bgcolor="yellow" style="border:1px solid #000; text-align: center;"
                data-format="0.00">{{$car_gasoils}}</td>
            <td bgcolor="yellow" style="border:1px solid #000; text-align: center;"
                data-format="0.00">{{$car_lubrifiants}}</td>
            <td bgcolor="yellow" style="border:1px solid #000; text-align: center;"
                data-format="0.00">{{$car_entretients}}</td>
            <td bgcolor="yellow" style="border:1px solid #000; text-align: center;" colspan="3"></td>
        </tr>
        <tr bgcolor="#F6BB00">
            <td bgcolor="#F6BB00" align="center" style="border:1px solid #000; text-align: center;" colspan="2">TOTAL ({{ $operations[0]->car->car_type->label }} {{  $operations[0]->car->car_brand->label }} {{ $operations[0]->car->model }})
            </td>
            <td bgcolor="#F6BB00" align="center" style="border:1px solid #000; text-align: center;" colspan="3"
                data-format="0.00">{{$car_gasoils+$car_lubrifiants+$car_entretients}}</td>
            <td bgcolor="#F6BB00" style="border:1px solid #000; text-align: center;" colspan="3"></td>
        </tr>

    @endforeach
    <tr>
        <td bgcolor="#7cfc00" style="border:1px solid #000; text-align: center;" colspan="2">TOTAL (TOUS LES VIHÉCULES)</td>
        <td bgcolor="#7cfc00" style="border:1px solid #000; text-align: center;"
            data-format="0.00">{{$total_gasoils}}</td>
        <td bgcolor="#7cfc00" style="border:1px solid #000; text-align: center;"
            data-format="0.00">{{$total_lubrifiants}}</td>
        <td bgcolor="#7cfc00" style="border:1px solid #000; text-align: center;"
            data-format="0.00">{{$total_entretients}}</td>
        <td bgcolor="#7cfc00" style="border:1px solid #000; text-align: center;" colspan="3"></td>
    </tr>
    <tr bgcolor="#F6BB00">
        <td bgcolor="#F6BB00" align="center" style="border:1px solid #000; text-align: center;" colspan="2">TOTAL GÉNÉRAL</td>
        <td bgcolor="#F6BB00" align="center" style="border:1px solid #000; text-align: center;" colspan="3"
            data-format="0.00">{{$total_gasoils+$total_lubrifiants+$total_entretients}}</td>
        <td bgcolor="#F6BB00" style="border:1px solid #000; text-align: center;" colspan="3"></td>
    </tr>
    <tr bgcolor="#F6BB00">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2">Massa le:...........</td>
    </tr>
    <tr>
        <td></td>
        <td colspan="4" style="text-align: center;">Le responsable du parc</td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
        <td colspan="4"  style="vertical-align: top; text-align: center;" >s/ Jamal RADI</td>
        <td colspan="4"  style="vertical-align: top; text-align: center;">Vice Président, chargée au secteur des travaux communaux</td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
        <td colspan="8"  style="vertical-align: top; text-align: center;">Represéntant de la Sté. Chargée de la fourniture du carburant, lubrifiant et d'entretien  </td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
        <td colspan="8" style="vertical-align: top; text-align: center;">VISA du président de la commune de Massa</td>
    </tr>
    </tbody>
</table>

