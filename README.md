# Instrucciones para Configurar el Proyecto

**Versión de PHP:** 8.2.21  
**Base de datos:** MySQL 8.0.30

## Instrucciones

1. **Importar la Base de Datos:**
   - En la carpeta `SQL` encontrarás un archivo que contiene el esquema de la base de datos.
   - Este archivo crea la base de datos y las tablas necesarias para el proyecto.
   - Importa este archivo en tu servidor MySQL para configurar la base de datos.

2. **Configurar la Conexión a la Base de Datos:**
   - Navega a la carpeta `config` y abre el archivo `connection.php`.
   - Modifica el archivo para ajustar la conexión a tu base de datos, incluyendo el nombre de usuario y la contraseña correspondientes.

3. **Configurar la URL Base del Proyecto:**
   - En el archivo `connection.php`, localiza el método `getBaseUrl()`.
   - Ajusta la ruta según sea necesario para que apunte a la URL correcta de tu proyecto.

## Notas Adicionales

- Asegúrate de que todos los archivos y configuraciones estén correctamente establecidos antes de iniciar el proyecto.
- Si encuentras problemas, revisa los archivos de configuración para verificar que los detalles de la base de datos sean correctos.

