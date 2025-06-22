# ANUIES TIC Timeline - PHP Version

## Overview
This is a complete PHP-based timeline management system for the ANUIES TIC 10-year celebration. The system provides both public viewing and administrative management capabilities.

## Features

### Public Interface (`index.php`)
- **Responsive Timeline Display**: Shows historical events, projects, and publications
- **Category Filtering**: Filter by "eventos", "proyectos", or "publicaciones"  
- **Modern UI**: ANUIES TIC branded design with animations
- **Mobile Responsive**: Optimized for all device sizes

### Administrative System
- **Secure Login** (`login.php`): Simple authentication system
- **Admin Dashboard** (`admin.php`): Complete content management interface
- **CRUD Operations**: Create, read, update, delete timeline items
- **Content Management**: Manage titles, descriptions, dates, and extended content
- **Media Support**: URL-based image integration
- **Publication Control**: Draft and publish functionality

## Installation

### Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

### Setup Steps

1. **Database Setup**
   ```bash
   mysql -u root -p < database.sql
   ```

2. **Configuration**
   - Edit `config.php` to match your database credentials
   - Update admin credentials if needed (default: admin/admin123)

3. **File Permissions**
   ```bash
   chmod 755 uploads/
   chmod 644 uploads/.htaccess
   ```

4. **Web Server**
   - Point document root to the `php/` directory
   - Ensure mod_rewrite is enabled (for .htaccess)

## File Structure

```
php/
├── index.php          # Public timeline interface
├── login.php          # Admin authentication
├── admin.php          # Administration panel
├── logout.php         # Session termination
├── config.php         # Database and app configuration
├── database.sql       # Database schema and initial data
├── uploads/           # Media files directory
│   ├── .htaccess     # Security configuration
│   └── .gitkeep      # Keep directory in git
└── README.md          # This file
```

## Database Schema

### timeline_items
- `id`: Primary key (auto-increment)
- `title`: Item title (required)
- `description`: Brief description (required)
- `extended_content`: Detailed content (optional)
- `date`: Display date (e.g., "Diciembre 2015")
- `type`: Category (eventos/proyectos/publicaciones)
- `image_url`: External image URL
- `is_published`: Publication status (boolean)
- `sort_order`: Display order
- `created_at`/`updated_at`: Timestamps

### media_files
- Basic file metadata storage
- Currently supports URL-based images
- Expandable for future file upload functionality

### admin_sessions
- Session management for admin authentication
- Automatic cleanup of expired sessions

## Security Features

- **Password Hashing**: Uses PHP's password_hash() function
- **SQL Injection Protection**: Prepared statements throughout
- **XSS Prevention**: HTML entity encoding on all outputs
- **CSRF Protection**: Form-based submissions only
- **File Upload Security**: .htaccess restrictions in uploads directory
- **Session Management**: Secure session handling

## Default Credentials

**Admin Access:**
- Username: `admin`
- Password: `admin123`

⚠️ **Important**: Change these credentials in production by updating the `ADMIN_USER` and `ADMIN_PASS` constants in `config.php`.

## Initial Data

The system comes pre-loaded with 10 timeline items representing the ANUIES TIC history:

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

## Customization

### Styling
All CSS is contained within the PHP files for easy deployment. Colors follow the ANUIES TIC brand guidelines:
- Primary: `#882642`
- Secondary: `#f8f8f8`
- Accent: `#c16c81`

### Adding Features
The modular structure makes it easy to extend:
- Add new admin views in `admin.php`
- Extend the database schema as needed
- Implement file upload functionality in the uploads system

## Production Considerations

1. **Change Default Credentials**: Update admin username/password
2. **Database Security**: Use dedicated database user with minimal privileges
3. **HTTPS**: Ensure SSL/TLS encryption for admin access
4. **Backup Strategy**: Implement regular database backups
5. **Error Logging**: Configure PHP error logging
6. **Performance**: Consider caching for high-traffic scenarios

## Browser Support

- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Mobile browsers (iOS Safari, Chrome Mobile)

## License

Developed for ANUIES TIC educational purposes.