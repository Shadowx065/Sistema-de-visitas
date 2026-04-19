# Sistema de Visitas (CRUD con POO en PHP + MySQL)

## Requisitos
- PHP 8+
- MySQL / MariaDB

## Configuración rápida
1. Crear base de datos y tabla:
   ```bash
   mysql -u root -p < database.sql
   ```
2. Ajustar credenciales en `db.php` si es necesario.
3. Levantar servidor local:
   ```bash
   php -S localhost:8000
   ```
4. Abrir `http://localhost:8000/index.php`

## Estructura
- `index.php`: listado + búsqueda + estado dentro/fuera.
- `create.php` / `store.php`: alta de visitas.
- `edit.php` / `update.php`: edición y registro de salida.
- `delete.php`: eliminación con confirmación JS desde la tabla.
- `Visit.php`: clase modelo con operaciones CRUD.
- `db.php`: conexión PDO encapsulada.
- `helpers.php`: utilidades de sesión, mensajes y sanitización.

## Regla de negocio implementada
- `hora_salida` inicia en `NULL`.
- Solo se permite registrar `hora_salida` cuando aún está en `NULL`.
- Si ya existe `hora_salida`, el campo queda de solo lectura.
