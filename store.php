<?php
require_once __DIR__ . '/Visit.php';
require_once __DIR__ . '/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectWithMessage('index.php', 'warning', 'Método no permitido.');
}

$nombreCompleto = trim($_POST['nombre_completo'] ?? '');
$personaVisitada = trim($_POST['persona_visitada'] ?? '');
$fecha = trim($_POST['fecha'] ?? '');
$horaEntrada = trim($_POST['hora_entrada'] ?? '');

if ($nombreCompleto === '' || $personaVisitada === '' || $fecha === '' || $horaEntrada === '') {
    redirectWithMessage('create.php', 'danger', 'Todos los campos obligatorios deben completarse.');
}

$database = new Database();
$visitModel = new Visit($database->connect());

$created = $visitModel->create([
    'nombre_completo' => $nombreCompleto,
    'persona_visitada' => $personaVisitada,
    'fecha' => $fecha,
    'hora_entrada' => $horaEntrada,
]);

if ($created) {
    redirectWithMessage('index.php', 'success', 'Visita registrada correctamente.');
}

redirectWithMessage('create.php', 'danger', 'No se pudo registrar la visita.');
