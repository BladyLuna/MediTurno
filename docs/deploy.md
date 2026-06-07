# Deploy - MediTurno MVP

## Objetivo

Preparar MediTurno para un entorno de presentación o producción básica.

## Requisitos

- PHP 8.2.
- Composer 2.
- Node.js compatible con Vite 5.
- MySQL 8.
- Nginx o Apache apuntando a `public/`.
- Extensiones PHP requeridas por Laravel y MySQL.

## Variables de Entorno

Configurar `.env`:

```env
APP_NAME=MediTurno
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mediturno
DB_USERNAME=usuario
DB_PASSWORD=clave_segura
```

Generar clave si corresponde:

```bash
php artisan key:generate
```

## Instalación

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
php artisan migrate --force
```

Para entorno demo:

```bash
php artisan migrate:fresh --seed
```

No usar `migrate:fresh --seed` en producción con datos reales.

## Cachés Laravel

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Permisos

El servidor web debe poder escribir en:

```text
storage/
bootstrap/cache/
```

## Nginx

El document root debe apuntar a:

```text
/ruta/del/proyecto/public
```

## Verificación

```bash
php artisan migrate:status
php artisan test
```

En Docker local:

```bash
docker compose up -d
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan test
```

## Seguridad de Dependencias

Antes de desplegar:

```bash
composer audit
npm audit
```

Resultado actual del cierre MVP:

- Composer reporta advisory en `laravel/framework 10.50.2`, `CVE-2026-48019`.
- npm reporta vulnerabilidad moderada en `esbuild` vía `vite`.

Acción recomendada:

- Evaluar actualizaciones dirigidas.
- No ejecutar `composer update` masivo sin revisar impacto.
- No ejecutar `npm audit fix --force` sin revisar salto mayor de Vite.
- Ejecutar pruebas completas después de cualquier actualización.

## Checklist Final

- [ ] `APP_DEBUG=false`.
- [ ] `APP_KEY` configurada.
- [ ] Base de datos conectada.
- [ ] Migraciones ejecutadas.
- [ ] Assets compilados.
- [ ] Permisos de `storage` y `bootstrap/cache`.
- [ ] Pruebas pasando.
- [ ] Auditoría de dependencias revisada.
