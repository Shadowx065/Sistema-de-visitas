<?php
require_once __DIR__ . '/db.php';

class Visit
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(array $data): bool
    {
        $sql = 'INSERT INTO visitas (nombre_completo, persona_visitada, fecha, hora_entrada, hora_salida)
                VALUES (:nombre_completo, :persona_visitada, :fecha, :hora_entrada, NULL)';
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nombre_completo' => $data['nombre_completo'],
            ':persona_visitada' => $data['persona_visitada'],
            ':fecha' => $data['fecha'],
            ':hora_entrada' => $data['hora_entrada'],
        ]);
    }

    public function getAll(?string $search = null): array
    {
        if (!empty($search)) {
            $sql = 'SELECT * FROM visitas
                    WHERE nombre_completo LIKE :search OR fecha LIKE :search
                    ORDER BY fecha DESC, hora_entrada DESC';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':search' => "%{$search}%"]);
            return $stmt->fetchAll();
        }

        $sql = 'SELECT * FROM visitas ORDER BY fecha DESC, hora_entrada DESC';
        return $this->pdo->query($sql)->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $sql = 'SELECT * FROM visitas WHERE id = :id LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $visit = $stmt->fetch();

        return $visit ?: null;
    }

    public function update(int $id, array $data): bool
    {
        $sql = 'UPDATE visitas
                SET nombre_completo = :nombre_completo,
                    persona_visitada = :persona_visitada,
                    fecha = :fecha,
                    hora_entrada = :hora_entrada,
                    hora_salida = :hora_salida
                WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nombre_completo' => $data['nombre_completo'],
            ':persona_visitada' => $data['persona_visitada'],
            ':fecha' => $data['fecha'],
            ':hora_entrada' => $data['hora_entrada'],
            ':hora_salida' => $data['hora_salida'],
            ':id' => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM visitas WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }
}
