<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dettagli Corso</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { text-align: center; }
        .details { margin-top: 20px; }
        .details th, .details td { padding: 6px 12px; border: 1px solid #000; }
        table { border-collapse: collapse; width: 100%; }
    </style>
</head>
<body>
    <h1>Dettagli del Corso</h1>

    <table class="details">
        <tr>
            <th>ID</th>
            <td>{{ $course->id }}</td>
        </tr>
        <tr>
            <th>Nome</th>
            <td>{{ $course->name }}</td>
        </tr>
        <tr>
            <th>Descrizione</th>
            <td>{{ $course->description }}</td>
        </tr>
        {{-- <tr>
            <th>Docente</th>
            <td>{{ $course->teacher->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Data Inizio</th>
            <td>{{ $course->start_date }}</td>
        </tr>
        <tr>
            <th>Data Fine</th>
            <td>{{ $course->end_date }}</td>
        </tr> --}}
    </table>
</body>
</html>
