<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8" />
    <title>Ricevuta di Pagamento</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Font globale e colori armonici */
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap');

        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        table,
        th,
        td,
        div,
        span {
            color: #4B2E05;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            margin: 20px auto; /* Ridotto per guadagnare spazio */
            max-width: 720px;
            font-size: 14px; /* Ridotto per guadagnare spazio */
            background: #ffffff;
        }

        .receipt-container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 12px 28px rgba(255, 111, 0, 0.2);
            padding: 30px 40px; /* Ridotto per guadagnare spazio */
            border: 1px solid #ffb347;
        }

        /* Header */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 4px solid #ff7800;
            padding-bottom: 15px; /* Ridotto per guadagnare spazio */
            margin-bottom: 20px; /* Ridotto per guadagnare spazio */
        }

        .header-text {
            flex-grow: 1;
            padding-left: 15px; /* Ridotto per guadagnare spazio */
        }

        .header-text h1 {
            margin: 0;
            font-weight: 700;
            font-size: 28px; /* Ridotto per guadagnare spazio */
            color: #ff7800;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }

        .header-text p {
            margin: 3px 0 0; /* Ridotto per guadagnare spazio */
            font-size: 12px; /* Ridotto per guadagnare spazio */
            color: #8a5c00;
            font-style: italic;
        }

        /* Logo */
        .logo {
            width: 80px; /* Ridotto per guadagnare spazio */
            height: auto;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(255, 111, 0, 0.3);
            margin-left: 15px; /* Spazio tra il testo e il logo */
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px; /* Ridotto per guadagnare spazio */
            font-weight: 500;
        }

        th,
        td {
            text-align: left;
            padding: 10px 14px; /* Ridotto per guadagnare spazio */
            background: #fff4e5;
            color: #7a4b00;
            border-radius: 12px;
            transition: background-color 0.3s ease;
            vertical-align: middle;
            font-size: 14px; /* Ridotto per guadagnare spazio */
        }

        th {
            background: #ffd8a8;
            color: #bf6500;
            width: 32%;
            font-weight: 600;
            text-transform: capitalize;
            letter-spacing: 0.03em;
            box-shadow: inset 3px 0 0 #ff7800;
        }

        /* Hover effect for rows for better UX (if interactive) */
        tr:hover td {
            background-color: #fff1c1;
        }

        /* Total row */
        tr.total-row td {
            font-weight: 700;
            font-size: 16px; /* Ridotto per guadagnare spazio */
            color: #4b2e05;
            background: #ffbb59;
            box-shadow: inset 0 0 8px rgba(255, 111, 0, 0.3);
        }

        /* Signature */
        .signature-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px; /* Ridotto per guadagnare spazio */
        }

        .signature {
            font-weight: 600;
            color: #bf6500;
            user-select: none;
            font-size: 14px; /* Ridotto per guadagnare spazio */
        }

        .signature-line {
            margin-top: 10px; /* Ridotto per guadagnare spazio */
            width: 250px; /* Ridotto per guadagnare spazio */
            border-top: 3px solid #ff7800;
            border-radius: 2px;
        }

        /* Footer */
        .footer {
            margin-top: 30px; /* Ridotto per guadagnare spazio */
            font-size: 12px; /* Ridotto per guadagnare spazio */
            color: #a87a00;
            display: flex;
            justify-content: space-between;
            font-style: italic;
            align-items: center;
            border-top: 1px solid #ffd59a;
            padding-top: 15px; /* Ridotto per guadagnare spazio */
        }

        /* Responsive tweaks */
        @media (max-width: 480px) {
            body {
                margin: 15px;
                font-size: 14px;
            }

            .receipt-container {
                padding: 25px 20px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-text {
                padding-left: 0;
                margin-top: 15px;
            }

            table {
                font-size: 14px;
            }

            .signature-line {
                width: 100%;
            }

            .footer {
                flex-direction: column;
                gap: 6px;
                font-size: 13px;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <div class="receipt-container" role="main" aria-label="Ricevuta di pagamento">
        <div class="header justify-between" role="banner">
            <div class="header-text p-6 m-6">
                <h1>Ricevuta di Pagamento</h1>
                <p>Rock Music Academy</p>
                <p>Via F.lli Baccari 15, 45026 Lendinara - P.IVA 01537990291</p>
            </div>
            <div>
            <img src="images/logo_rma.png" alt="Logo dell'azienda" class="logo">
            </div>
        </div>

        <table role="table" aria-label="Dettagli pagamento">
            <tbody>
                <tr>
                    <th scope="row">Studente</th>
                    <td>{{ $payment->student->name }} {{ $payment->student->surname }}</td>
                </tr>
                <tr>
                    <th scope="row">Data di nascita</th>
                    <td>{{ $payment->student->birth_date->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th scope="row">Corso</th>
                    <td>{{ $payment->course->name }}</td>
                </tr>
                <tr>
                    <th scope="row">Tipo di pagamento</th>
                    <td>{{ $payment->paymentType->name }}</td>
                </tr>
                @if ($payment->month)
                    <tr>
                        <th scope="row">Mese</th>
                        <td>{{ $payment->month->name }}</td>
                    </tr>
                @endif
                @if ($payment->year)
                    <tr>
                        <th scope="row">Anno</th>
                        <td>{{ $payment->year }}</td>
                    </tr>
                @endif
                <tr class="total-row">
                    <th scope="row">Importo</th>
                    <td>€{{ number_format($payment->amount, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <th scope="row">Data pagamento</th>
                    <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="signature-container" aria-label="Firma e Timbro">
            <div>
                <span class="signature">Firma e Timbro</span>
                <br><br><br><br>
                <div class="signature-line"></div>
            </div>
        </div>

        <div class="footer" role="contentinfo">
            <div>Data emissione: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
            <div>Contatti: info@rockmusicacademy.it | Tel: +39 0425 123456</div>
        </div>
    </div>
</body>

</html>
