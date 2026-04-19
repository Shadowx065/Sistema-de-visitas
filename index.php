<?php
require_once __DIR__ . '/Visit.php';
require_once __DIR__ . '/helpers.php';

$database = new Database();
$visitModel = new Visit($database->connect());

$search = isset($_GET['search']) ? trim($_GET['search']) : null;
$visitas = $visitModel->getAll($search);
$flash = getFlashMessage();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Visitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
        <h1 class="h3 mb-0">Control de Ingreso y Salida</h1>
        <a href="create.php" class="btn btn-primary">+ Registrar visita</a>
    </div>

    <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type']; ?> alert-dismissible fade show" role="alert">
            <?= sanitize($flash['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form method="GET" class="card card-body mb-3">
        <div class="row g-2 align-items-end">
            <div class="col-12 col-md-8">
                <label for="search" class="form-label">Buscar por nombre o fecha</label>
                <input type="text" id="search" name="search" class="form-control" placeholder="Ej: María o 2026-04-16" value="<?= sanitize($search ?? ''); ?>">
            </div>
            <div class="col-12 col-md-4 d-grid">
                <button class="btn btn-outline-secondary">Buscar</button>
            </div>
        </div>
    </form>

    <div class="table-responsive bg-white rounded shadow-sm">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Visitado</th>
                <th>Fecha</th>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Estado</th>
                <th class="text-center">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($visitas)): ?>
                <tr>
                    <td colspan="8" class="text-center py-4">No hay registros disponibles.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($visitas as $row): ?>
                    <tr>
                        <td><?= (int)$row['id']; ?></td>
                        <td><?= sanitize($row['nombre_completo']); ?></td>
                        <td><?= sanitize($row['persona_visitada']); ?></td>
                        <td><?= sanitize($row['fecha']); ?></td>
                        <td><?= sanitize($row['hora_entrada']); ?></td>
                        <td><?= $row['hora_salida'] ? sanitize($row['hora_salida']) : '-'; ?></td>
                        <td>
                            <?php if ($row['hora_salida'] === null): ?>
                                <span class="badge text-bg-success">🟢 Dentro</span>
                            <?php else: ?>
                                <span class="badge text-bg-danger">🔴 Fuera</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="edit.php?id=<?= (int)$row['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="delete.php?id=<?= (int)$row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este registro?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
