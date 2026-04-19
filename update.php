<?php
require_once __DIR__ . '/Visit.php';
require_once __DIR__ . '/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectWithMessage('index.php', 'warning', 'Método no permitido.');
}

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
    redirectWithMessage('index.php', 'warning', 'ID inválido.');
}

$nombreCompleto = trim($_POST['nombre_completo'] ?? '');
$personaVisitada = trim($_POST['persona_visitada'] ?? '');
$fecha = trim($_POST['fecha'] ?? '');
$horaEntrada = trim($_POST['hora_entrada'] ?? '');
$horaSalidaInput = trim($_POST['hora_salida'] ?? '');

if ($nombreCompleto === '' || $personaVisitada === '' || $fecha === '' || $horaEntrada === '') {
    redirectWithMessage("edit.php?id={$id}", 'danger', 'Todos los campos obligatorios deben completarse.');
}

$database = new Database();
$visitModel = new Visit($database->connect());
$currentVisit = $visitModel->getById($id);

if (!$currentVisit) {
    redirectWithMessage('index.php', 'warning', 'Registro no encontrado.');
}

$horaSalida = $currentVisit['hora_salida'];
if ($currentVisit['hora_salida'] === null) {
    $horaSalida = $horaSalidaInput !== '' ? $horaSalidaInput : null;
}

$updated = $visitModel->update($id, [
    'nombre_completo' => $nombreCompleto,
    'persona_visitada' => $personaVisitada,
    'fecha' => $fecha,
    'hora_entrada' => $horaEntrada,
    'hora_salida' => $horaSalida,
]);

if ($updated) {
    redirectWithMessage('index.php', 'success', 'Registro actualizado correctamente.');
}

redirectWithMessage("edit.php?id={$id}", 'danger', 'No se pudo actualizar el registro.');
