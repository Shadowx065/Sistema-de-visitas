<?php
require_once __DIR__ . '/helpers.php';
$today = date('Y-m-d');
$now = date('H:i:s');
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar visita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="h4 mb-3">Registrar nueva visita</h1>
            <form method="POST" action="store.php" class="row g-3">
                <div class="col-12">
                    <label for="nombre_completo" class="form-label">Nombre completo *</label>
                    <input type="text" id="nombre_completo" name="nombre_completo" class="form-control" maxlength="100" required>
                </div>
                <div class="col-12">
                    <label for="persona_visitada" class="form-label">Persona visitada *</label>
                    <input type="text" id="persona_visitada" name="persona_visitada" class="form-control" maxlength="100" required>
                </div>
                <div class="col-md-6">
                    <label for="fecha" class="form-label">Fecha *</label>
                    <input type="date" id="fecha" name="fecha" class="form-control" value="<?= sanitize($today); ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="hora_entrada" class="form-label">Hora de entrada *</label>
                    <input type="time" step="1" id="hora_entrada" name="hora_entrada" class="form-control" value="<?= sanitize($now); ?>" required>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary">Guardar</button>
                    <a href="index.php" class="btn btn-outline-secondary">Volver</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
