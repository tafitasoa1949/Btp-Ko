<!DOCTYPE html>
<html>
<head>
    <title>Facture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: black;
        }

        h1 {
            color: black;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            color: black;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .company-profile-left, .company-profile-right {
            padding: 20px;
            margin-bottom: 20px;
            /* Retirez la propriété background-color */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<h1>BTP-Ko</h1>
<div class="row">
    <div class="company-profile-left">
        <p>Travail : {{ $devisMaison->maison->nom }}</p>
        <p>Durée: {{ $devisMaison->maison->duree }} jour(s)</p>
        <p>Finition: {{ $devisMaison->finition->nom }}</p>
    </div>
</div>
<div class="row">
    <table>
        <thead>
        <tr>
            <th>N°</th>
            <th>Designation</th>
            <th>U</th>
            <th>Q</th>
            <th style="width: 110px">PU</th>
            <th style="width: 200px">Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($devisMaison->detailDevis as $details)
            <tr>
                <td>{{ $details->compte->code }}</td>
                <td>{{ $details->compte->nom }}</td>
                <td>{{ $details->compte->unite->nom }}</td>
                <td>{{ $details->quantite }}</td>
                <td>{{ $details->pu }} Ar</td>
                <?php
                    $total = $details->quantite * $details->pu
                    ?>
                <td>{{ $total }} Ar</td>
            </tr>
        @endforeach
        </tbody>
            <tr>
                <?php
                $bigtotal = 0;
                foreach ($devisMaison->detailDevis as $devis){
                    $total = $devis->quantite * $devis->pu;
                    $bigtotal += $total;
                }
                $prixfinition = ($devisMaison->taux_finition * $bigtotal)/100;
                $totalNet =$bigtotal+$prixfinition;
                ?>
                <td colspan="5" style="text-align: center">Total</td>
                <td>{{ $totalNet }} Ar</td>
            </tr>
    </table>
</div>
<h2>Listes Paiement</h2>
<div class="row">
    <table>
        <thead>
        <tr>
            <th>Reference</th>
            <th>Montant</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
            @foreach($devisMaison->paiement as $paiement)
                <tr>
                    <td>{{ $paiement->reference }}</td>
                    <td>{{ $paiement->montant }} Ar</td>
                    <td>{{ $paiement->date }}</td>
                </tr>
            @endforeach
        </tbody>
        <tr>
            <td colspan="">Total</td>
            <?php
                $total = 0;
                foreach ($devisMaison->paiement as $paiement) {
                    $total += $paiement->montant;
                }
            ?>
            <td>{{ $total }} Ar</td>
            <td></td>
        </tr>
    </table>
</div>
</body>
</html>
