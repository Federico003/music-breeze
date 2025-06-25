<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dettagli Utente</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { text-align: center; }
        .details { margin-top: 20px; }
        .details th, .details td { padding: 6px 12px; border: 1px solid #000; }
        table { border-collapse: collapse; width: 100%; }
    </style>
</head>
<body>
    <h1>Anagrafica Utente #{{$user->id}}</h1>

    <table class="details">
        <tr>
            <th>ID</th>
            <td>{{ $user->id }}</td>
        </tr>

        <tr>
            <th>Nome</th>
            <td>{{ $user->name }}</td>
        </tr>

        <tr>
            <th>Cognome</th>
            <td>{{ $user->surname }}</td>
        </tr>

        <tr>
            <th>Data di Nascita</th>
            <td>{{ $user->birth_date->format('d/m/Y') }}</td>
        </tr>
        
        <tr>
            <th>Luogo di Nascita</th>
            <td>{{ $user->birth_place }}</td>
        </tr>

        <tr>
            <th>Telefono</th>
            <td>{{ $user->phone }}</td>
        </tr>

        <tr>
            <th>Email</th>
            <td>{{ $user->email }}</td>
        </tr>
        
        <tr>
            <th>Indirizzo</th>
            <td>{{ $user->address }}</td>
        </tr>

        <tr>
            <th>Comune</th>
            <td>{{ $user->city }}</td>
        </tr>

        <tr>
            <th>Stato</th>
            <td>{{ $user->country }}</td>
        </tr>
        
        <tr>
            <th>Iscritto il</th>
            <td>{{ $user->created_at->format('d/m/Y') }}</td>
        </tr>

        <tr>
            <th>Aggiornato il</th>
            <td>{{ $user->updated_at->format('d/m/Y') }}</td>
        </tr>
        

    </table>
</body>
</html>
