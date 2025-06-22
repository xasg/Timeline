# Línea de Tiempo ANUIES TIC - Versión PHP

## Descripción General
Este es un sistema completo de gestión de línea de tiempo basado en PHP para la celebración de los 10 años de ANUIES TIC. El sistema proporciona capacidades tanto de visualización pública como de gestión administrativa.

## Características

### Interfaz Pública (`index.php`)
- **Visualización de Línea de Tiempo Adaptable**: Muestra eventos históricos, proyectos y publicaciones.
- **Filtrado por Categoría**: Filtra por "eventos", "proyectos" o "publicaciones".
- **Interfaz de Usuario Moderna**: Diseño con la marca ANUIES TIC y animaciones.
- **Adaptable a Móviles**: Optimizado para todos los tamaños de dispositivo.

### Sistema Administrativo
- **Inicio de Sesión Seguro** (`login.php`): Sistema de autenticación simple.
- **Panel de Administración** (`admin.php`): Interfaz completa de gestión de contenido.
- **Operaciones CRUD**: Crear, leer, actualizar y eliminar elementos de la línea de tiempo.
- **Gestión de Contenido**: Administra títulos, descripciones, fechas y contenido extendido.
- **Soporte Multimedia**: Integración de imágenes basada en URL.
- **Control de Publicación**: Funcionalidad de borrador y publicación.

## Instalación

### Requisitos
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx)

### Pasos de Configuración

1. **Configuración de la Base de Datos**
   ```bash
   mysql -u root -p < database.sql
   ```

2. **Configuración**
   - Edita `config.php` para que coincida con tus credenciales de base de datos.
   - Actualiza las credenciales de administrador si es necesario (por defecto: admin/admin123).

3. **Permisos de Archivos**
   ```bash
   chmod 755 uploads/
   chmod 644 uploads/.htaccess
   ```

4. **Servidor Web**
   - Apunta el `document root` al directorio `php/`.
   - Asegúrate de que `mod_rewrite` esté habilitado (para `.htaccess`).

## Estructura de Archivos

```
php/
├── index.php          # Interfaz pública de la línea de tiempo
├── login.php          # Autenticación de administrador
├── admin.php          # Panel de administración
├── logout.php         # Cierre de sesión
├── config.php         # Configuración de la base de datos y la aplicación
├── database.sql       # Esquema de la base de datos y datos iniciales
├── uploads/           # Directorio de archivos multimedia
│   ├── .htaccess     # Configuración de seguridad
│   └── .gitkeep      # Mantiene el directorio en git
└── README.md          # Este archivo
```

## Esquema de la Base de Datos

### timeline_items
- `id`: Clave primaria (autoincremental)
- `title`: Título del elemento (obligatorio)
- `description`: Descripción breve (obligatoria)
- `extended_content`: Contenido detallado (opcional)
- `date`: Fecha de visualización (ej., "Diciembre 2015")
- `type`: Categoría (eventos/proyectos/publicaciones)
- `image_url`: URL de imagen externa
- `is_published`: Estado de publicación (booleano)
- `sort_order`: Orden de visualización
- `created_at`/`updated_at`: Marcas de tiempo

### media_files
- Almacenamiento básico de metadatos de archivos.
- Actualmente admite imágenes basadas en URL.
- Ampliable para futura funcionalidad de carga de archivos.

### admin_sessions
- Gestión de sesiones para autenticación de administrador.
- Limpieza automática de sesiones expiradas.

## Características de Seguridad

- **Hashing de Contraseñas**: Utiliza la función `password_hash()` de PHP.
- **Protección contra Inyección SQL**: Sentencias preparadas en todo el sistema.
- **Prevención de XSS**: Codificación de entidades HTML en todas las salidas.
- **Protección CSRF**: Envíos solo basados en formularios.
- **Seguridad en Carga de Archivos**: Restricciones de `.htaccess` en el directorio `uploads`.
- **Gestión de Sesiones**: Manejo seguro de sesiones.

## Credenciales por Defecto

**Acceso de Administrador:**
- Usuario: `admin`
- Contraseña: `admin123`

⚠️ **Importante**: Cambia estas credenciales en producción actualizando las constantes `ADMIN_USER` y `ADMIN_PASS` en `config.php`.

## Datos Iniciales

El sistema viene precargado con 10 elementos en la línea de tiempo que representan la historia de ANUIES TIC:

1. **Creación del Comité ANUIES TIC** (Diciembre 2015)
2. **Primer Encuentro ANUIES TIC** (Noviembre 2016)
3. **Primer Estudio de Estado Actual de las TIC** (Noviembre 2016)
4. **Publicación del Marco de Referencia TI** (Mayo 2018)
5. **Lanzamiento de la Red Nacional de Investigación** (Febrero 2019)
6. **Programa de Capacitación Digital** (Agosto 2020)
7. **Red de Colaboración en Ciberseguridad** (Marzo 2021)
8. **Plataforma Nacional de Recursos Educativos** (Septiembre 2022)
9. **Conferencia Internacional de Innovación Educativa** (Junio 2023)
10. **Programa de Transformación Digital 2024** (Enero 2024)

## Personalización

### Estilos
Todo el CSS está contenido dentro de los archivos PHP para facilitar la implementación. Los colores siguen las directrices de marca de ANUIES TIC:
- Primario: `#882642`
- Secundario: `#f8f8f8`
- Acento: `#c16c81`

### Añadir Funcionalidades
La estructura modular facilita la extensión:
- Añade nuevas vistas de administración en `admin.php`.
- Extiende el esquema de la base de datos según sea necesario.
- Implementa la funcionalidad de carga de archivos en el sistema de `uploads`.

## Consideraciones para Producción

1. **Cambiar Credenciales por Defecto**: Actualiza el nombre de usuario y contraseña del administrador.
2. **Seguridad de la Base de Datos**: Utiliza un usuario de base de datos dedicado con privilegios mínimos.
3. **HTTPS**: Asegura el cifrado SSL/TLS para el acceso de administrador.
4. **Estrategia de Copias de Seguridad**: Implementa copias de seguridad regulares de la base de datos.
5. **Registro de Errores**: Configura el registro de errores de PHP.
6. **Rendimiento**: Considera el uso de caché para escenarios de alto tráfico.

## Soporte de Navegadores

- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Navegadores móviles (iOS Safari, Chrome Mobile)

## Licencia

Desarrollado para fines educativos de ANUIES TIC.
