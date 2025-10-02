# 📊 Stock Market Ticker - Plugin de WordPress

Un plugin profesional de WordPress para crear tickers animados con loop infinito. Perfecto para mostrar datos municipales, estadísticas, métricas o cualquier información que desees destacar.

## ✨ Características

- 🔄 **Loop Infinito**: Animación continua sin cortes visibles
- 📱 **Completamente Responsive**: Se adapta a todos los tamaños de pantalla
- 🎨 **Colores Personalizables**: Selector de color para cada elemento
- ⚡ **Fácil de Usar**: Panel de administración intuitivo
- 🔧 **Shortcode Simple**: `[stock_ticker]` para insertar en cualquier lugar
- 📊 **Gestión Completa**: Agregar, editar y eliminar elementos fácilmente
- 🎯 **Sin Dependencias Externas**: Todo incluido en el plugin

## 📥 Instalación

### Método 1: Subida Manual

1. Descarga la carpeta `stock-market-ticker-plugin`
2. Sube la carpeta completa a `/wp-content/plugins/`
3. Activa el plugin desde el menú "Plugins" en WordPress
4. ¡Listo! Verás un nuevo menú "Ticker" en tu panel de administración

### Método 2: Subida desde WordPress

1. Comprime la carpeta `stock-market-ticker-plugin` en un archivo ZIP
2. Ve a Plugins > Añadir nuevo > Subir plugin
3. Selecciona el archivo ZIP y haz clic en "Instalar ahora"
4. Activa el plugin

## 🚀 Uso Rápido

### 1. Agregar Datos

1. Ve a **Ticker** en el menú lateral de WordPress
2. Completa el formulario:
   - **Valor**: El número o dato (ej: 282, 32,750)
   - **Etiqueta**: Descripción del dato (ej: cuadras pavimentadas)
   - **Color**: Selecciona un color para el cuadrado indicador
3. Haz clic en "Guardar Elemento"

### 2. Mostrar el Ticker

#### En Páginas o Entradas
Simplemente agrega el shortcode en el editor:
```
[stock_ticker]
```

#### En Widgets
Si tu tema soporta shortcodes en widgets, puedes usar:
```
[stock_ticker]
```

#### En Archivos de Tema (PHP)
```php
<?php echo do_shortcode('[stock_ticker]'); ?>
```

#### En Bloques de WordPress (Gutenberg)
1. Agrega un bloque de "Shortcode"
2. Pega: `[stock_ticker]`

## ⚙️ Parámetros del Shortcode

### Velocidad
Controla la velocidad de la animación (en segundos):
```
[stock_ticker speed="20"]
```
- Valores más bajos = más rápido
- Valores más altos = más lento
- Por defecto: 20 segundos

### Altura
Ajusta la altura del ticker (en píxeles):
```
[stock_ticker height="80"]
```
- Por defecto: 80px
- Se adapta automáticamente en móviles

### Combinar Parámetros
```
[stock_ticker speed="15" height="100"]
```

## 📋 Ejemplos de Uso

### Datos Municipales
```
Valor: 282
Etiqueta: cuadras pavimentadas
Color: #F7DC6F
```

### Estadísticas de Ventas
```
Valor: $1,250,000
Etiqueta: ventas este mes
Color: #82E0AA
```

### Métricas de Rendimiento
```
Valor: 99.9%
Etiqueta: tiempo de actividad
Color: #85C1E9
```

### Contador de Eventos
```
Valor: 1,234
Etiqueta: asistentes registrados
Color: #F1948A
```

## 🎨 Colores Sugeridos

El plugin viene con un selector de color completo, pero aquí hay algunas sugerencias:

- 🟨 `#F7DC6F` - Amarillo dorado
- 🟩 `#82E0AA` - Verde menta
- 🟦 `#85C1E9` - Azul cielo
- 🟥 `#F1948A` - Rosa coral
- 🟪 `#D7BDE2` - Lavanda
- 🟧 `#F8C471` - Naranja suave
- 🟦 `#4ECDC4` - Turquesa

## 🔧 Gestión de Datos

### Editar un Elemento
1. Haz clic en el botón "✏️ Editar" del elemento
2. Modifica los valores en el modal
3. Haz clic en "Actualizar"

### Eliminar un Elemento
1. Haz clic en el botón "🗑️ Eliminar"
2. Confirma la eliminación

### Orden de los Elementos
Los elementos se muestran en el orden en que fueron creados. Los más antiguos aparecen primero.

## 📱 Responsive Design

El ticker se adapta automáticamente a diferentes dispositivos:

- **Desktop (>1024px)**: Tamaño completo
- **Tablets (≤1024px)**: Ligeramente reducido
- **Mobile Large (≤768px)**: Optimizado para móviles
- **Mobile Medium (≤480px)**: Compacto
- **Mobile Small (≤360px)**: Mínimo pero legible

## 🗄️ Base de Datos

El plugin crea una tabla en tu base de datos:
- Nombre: `wp_stock_ticker_items` (el prefijo puede variar)
- Los datos se mantienen al desactivar el plugin
- Para eliminar datos: desinstala el plugin (próxima versión incluirá opción)

## 🔒 Seguridad

- ✅ Protección contra acceso directo
- ✅ Validación de nonces en formularios
- ✅ Sanitización de datos de entrada
- ✅ Permisos de usuario verificados
- ✅ Protección contra SQL injection
- ✅ Escape de datos de salida

## 🐛 Solución de Problemas

### El ticker no se muestra
- Verifica que has agregado datos desde el panel de administración
- Asegúrate de usar el shortcode correcto: `[stock_ticker]`
- Revisa que el plugin esté activado

### El ticker no se anima
- Limpia la caché de tu sitio
- Verifica que no haya conflictos con otros plugins
- Revisa la consola del navegador (F12) por errores JavaScript

### Los colores no se guardan
- Asegúrate de usar formato hexadecimal (#RRGGBB)
- Limpia la caché del navegador
- Intenta con otro color

### El loop no es continuo
- Esto es normal si tienes muy pocos elementos (menos de 3)
- Agrega más elementos para un loop más fluido
- Ajusta la velocidad con el parámetro `speed`

## 🔄 Actualizaciones Futuras

Funcionalidades planeadas:
- [ ] Ordenamiento drag & drop de elementos
- [ ] Importar/exportar datos CSV
- [ ] Múltiples tickers con diferentes configuraciones
- [ ] Efectos de animación adicionales
- [ ] Actualización automática de datos via API
- [ ] Modo oscuro para el ticker
- [ ] Templates personalizables

## 📞 Soporte

Para soporte técnico, sugerencias o reportar bugs:
- Email: tu-email@ejemplo.com
- GitHub: https://github.com/tu-usuario/stock-market-ticker

## 📄 Licencia

Este plugin está licenciado bajo GPL v2 o posterior.

## 👨‍💻 Desarrollador

Desarrollado por [Tu Nombre]
Sitio web: https://tu-sitio.com

## 🙏 Agradecimientos

Gracias por usar Stock Market Ticker. Si te gusta el plugin, considera:
- ⭐ Dejar una reseña en WordPress.org
- 🐛 Reportar bugs para mejorar el plugin
- 💡 Sugerir nuevas funcionalidades
- 🔄 Compartirlo con otros

---

**Versión**: 1.0.0  
**Última actualización**: 2025  
**Compatibilidad**: WordPress 5.0+  
**Requiere PHP**: 7.0+


