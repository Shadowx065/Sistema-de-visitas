<?php
require_once __DIR__ . '/Visit.php';
require_once __DIR__ . '/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    redirectWithMessage('index.php', 'warning', 'ID inválido.');
}

$database = new Database();
$visitModel = new Visit($database->connect());
$visit = $visitModel->getById($id);

if (!$visit) {
    redirectWithMessage('index.php', 'warning', 'Registro no encontrado.');
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar visita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="h4 mb-3">Editar visita #<?= (int)$visit['id']; ?></h1>
            <form method="POST" action="update.php" class="row g-3">
                <input type="hidden" name="id" value="<?= (int)$visit['id']; ?>">
                <div class="col-12">
                    <label for="nombre_completo" class="form-label">Nombre completo *</label>
                    <input type="text" id="nombre_completo" name="nombre_completo" class="form-control" maxlength="100" value="<?= sanitize($visit['nombre_completo']); ?>" required>
                </div>
                <div class="col-12">
                    <label for="persona_visitada" class="form-label">Persona visitada *</label>
                    <input type="text" id="persona_visitada" name="persona_visitada" class="form-control" maxlength="100" value="<?= sanitize($visit['persona_visitada']); ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="fecha" class="form-label">Fecha *</label>
                    <input type="date" id="fecha" name="fecha" class="form-control" value="<?= sanitize($visit['fecha']); ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="hora_entrada" class="form-label">Hora de entrada *</label>
                    <input type="time" step="1" id="hora_entrada" name="hora_entrada" class="form-control" value="<?= sanitize($visit['hora_entrada']); ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="hora_salida" class="form-label">Hora de salida</label>
                    <input
                        type="time"
                        step="1"
                        id="hora_salida"
                        name="hora_salida"
                        class="form-control"
                        value="<?= sanitize($visit['hora_salida'] ?? ''); ?>"
                        <?= $visit['hora_salida'] !== null ? 'readonly' : ''; ?>
                    >
                    <?php if ($visit['hora_salida'] !== null): ?>
                        <small class="text-muted">La hora de salida ya fue registrada y no se puede editar.</small>
                    <?php endif; ?>
                </div>
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary">Actualizar</button>
                    <a href="index.php" class="btn btn-outline-secondary">Volver</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
