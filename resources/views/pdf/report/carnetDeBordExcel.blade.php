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
        <td colspan="7" rowspan="2" style="vertical-align: top; text-align: center;">
            CARNET DE BORD DU VIHÉCULE: {{' '.$car->plate}}
            <br>
            DU MOIS: <span style="text-transform: uppercase">{{' '.$date}}</span>
        </td>

    </tr>
    </tbody>
</table>

<table style="table-layout: auto;">
    <tbody>
    <tr class="active">
        <td rowspan="2" style="border:1px solid #000; font-weight: bold; text-align: center; vertical-align: center;"
            bgcolor="#e1e1e1">DATE
        </td>
        <td colspan="4" style="border:1px solid #000; font-weight: bold; text-align: center; vertical-align: center;"
            bgcolor="#e1e1e1">DÉPLACEMENTS</td>
        <td rowspan="2" style="border:1px solid #000; font-weight: bold; text-align: center; vertical-align: center;"
            bgcolor="#e1e1e1">NOM DU CONDUCTEUR
        </td>
        <td rowspan="2" style="border:1px solid #000; font-weight: bold; text-align: center; vertical-align: center;"
            bgcolor="#e1e1e1">SIGNATURE
        </td>
    </tr>
    <tr>
        <td style="border:1px solid #000; font-weight: bold; text-align: center; vertical-align: center;"
            bgcolor="#e1e1e1">KILOMÉTRAGE DE DÉPART
        </td>
        <td style="border:1px solid #000; font-weight: bold; text-align: center; vertical-align: center;"
            bgcolor="#e1e1e1">KILOMÉTRAGE DE FIN DE LA MISSION
        </td>
        <td style="border:1px solid #000; font-weight: bold; text-align: center; vertical-align: center;"
            bgcolor="#e1e1e1">DISTANCE EN KM
        </td>
        <td style="border:1px solid #000; font-weight: bold; text-align: center; vertical-align: center;"
            bgcolor="#e1e1e1">MOTIF
        </td>
    </tr>
    @foreach ($items as $item)
        <tr style="border:1px solid #000; text-align: center; vertical-align: center;">
            <td style="border:1px solid #000; text-align: center; vertical-align: center;">  {{ \Carbon\Carbon::parse($item->date)->format('d/m/Y')}}</td>
            <td style="border:1px solid #000; text-align: center; vertical-align: center;">  {{ $item->km_depart }}</td>
            <td style="border:1px solid #000; text-align: center; vertical-align: center;">  {{ $item->km_arrivee}}</td>
            <td style="border:1px solid #000; text-align: center; vertical-align: center;">  {{ $item->km_arrivee-$item->km_depart}}</td>
            <td style="border:1px solid #000; text-align: center; vertical-align: center;">  {{ $item->motif}}</td>
            <td style="border:1px solid #000; text-align: center; vertical-align: center;">  {{ $item->personnel->fullname}}</td>
            <td style="border:1px solid #000; text-align: center; vertical-align: center;"> </td>
        </tr>
    @endforeach
    </tbody>
</table>
