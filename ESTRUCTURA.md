# Estructura del Proyecto - Nexus Importaciones (Tienda de Cómputo)

Arquitectura modular recomendada para separar la **Tienda Pública (Frontend)** y el **Panel de Administración (Backend)** utilizando PHP nativo, PDO (MySQL) y Bootstrap 5.

## Árbol de Directorios

```text
WebProgramming-ProyectoFinal/
│
├── index.php                     # Entrada principal de la tienda (Home)
├── database.sql                  # Script SQL para crear las tablas e insertar datos de prueba
├── ESTRUCTURA.md                 # Documentación de la distribución del proyecto
│
├── assets/                       # Recursos estáticos públicos
│   ├── css/
│   │   ├── store.css             # Estilos propios de la tienda (ej. clases .solo-pc, cards)
│   │   └── admin.css             # Estilos del panel administrativo (sidebar, tablas)
│   ├── js/
│   │   ├── carrito.js            # Lógica de carrito (LocalStorage o peticiones fetch/AJAX)
│   │   └── admin.js              # Alertas, modales de edición y gráficas del admin
│   └── img/
│       ├── logos/                # lgo.png, favicons
│       ├── banners/              # Imágenes del carrusel promocional
│       └── productos/            # Fotos subidas desde el panel admin (GPUs, laptops, etc.)
│
├── admin/                        # PANEL DE ADMINISTRACIÓN (Vistas protegidas por sesión)
│   ├── index.php                 # Dashboard (resumen de ventas, stock bajo, total clientes)
│   ├── login.php                 # Login exclusivo para administradores/empleados
│   ├── productos.php             # CRUD de productos (listar, crear, editar, desactivar)
│   ├── categorias.php            # CRUD de categorías (Procesadores, Placas, Laptops...)
│   ├── marcas.php                # CRUD de marcas (ASUS, MSI, Intel, AMD, Logitech...)
│   ├── pedidos.php               # Gestión de órdenes de compra y cambio de estado
│   └── usuarios.php              # Gestión de clientes y administradores
│
└── src/                          # NÚCLEO Y LÓGICA DEL SISTEMA (Backend + Vistas tienda)
    ├── config/                   # Configuración general y base de datos
    │   ├── app.php               # Constantes (BASE_URL, moneda S/ o $, zona horaria)
    │   └── conexion.php          # Conexión PDO a MySQL
    │
    ├── includes/                 # Fragmentos HTML reutilizables (evita repetir código)
    │   ├── store/
    │   │   ├── header.php        # <nav> principal y secundario + menú móvil offcanvas
    │   │   └── footer.php        # <footer> de la tienda
    │   └── admin/
    │       ├── sidebar.php       # Menú lateral del panel de administración
    │       └── topbar.php        # Barra superior del admin (perfil y cerrar sesión)
    │
    ├── controllers/              # Procesan formularios (POST/GET) y peticiones AJAX
    │   ├── AuthController.php    # Iniciar sesión, registro y cerrar sesión
    │   ├── ProductoController.php# Guardar producto, subir imagen, actualizar stock
    │   ├── CarritoController.php # Agregar/quitar del carrito y procesar compra
    │   └── PedidoController.php  # Generar orden y cambiar estados (Pendiente -> Enviado)
    │
    ├── models/                   # Consultas SQL directas a la base de datos (PDO)
    │   ├── Producto.php          # SELECT con filtros por marca/categoría, INSERT, UPDATE
    │   ├── Categoria.php         # Consultas de categorías
    │   ├── Marca.php             # Consultas de marcas
    │   ├── Pedido.php            # Guardar cabecera y detalle de venta
    │   └── Usuario.php           # Consultas de usuarios y validación de roles
    │
    ├── lib/                      # Funciones de ayuda / Helpers
    │   ├── auth.php              # Middleware: verificar si es Admin antes de entrar a /admin
    │   └── funciones.php         # Subida segura de imágenes, formateo de precios, limpiar inputs
    │
    └── pages/                    # Vistas públicas de la tienda
        ├── catalogo.php          # Lista de productos con filtros laterales (marca, precio)
        ├── producto-detalle.php  # Ficha técnica del componente, fotos y botón "Añadir"
        ├── carrito.php           # Resumen de productos agregados
        ├── checkout.php          # Formulario de envío y método de pago
        ├── login.php             # Login / Registro de clientes
        ├── perfil.php            # Historial de compras del cliente
        ├── contacto.php          # Formulario de contacto / ubicación
        └── nosotros.php          # Información de Nexus Importaciones
```

---

## Flujo de Trabajo y Organización

1. **Separación de Entornos (`src/pages/` vs `admin/`)**
   - **Tienda Pública**: Carga los componentes de `src/includes/store/header.php` y `footer.php`. Permite a los visitantes navegar por el catálogo de hardware, filtrar por marca/categoría y armar su carrito.
   - **Panel Administrativo (`admin/`)**: Protegido mediante sesiones (`src/lib/auth.php`). Usa su propia interfaz (`src/includes/admin/sidebar.php`) para gestionar inventario, precios, stock, categorías, marcas y pedidos.

2. **Patrón MVC Simplificado**
   - **Vistas (`index.php`, `src/pages/*`, `admin/*`)**: Solo muestran la interfaz HTML/Bootstrap.
   - **Controladores (`src/controllers/*`)**: Reciben las peticiones de los formularios (`$_POST` / `$_GET`), validan los datos y responden (redireccionando o devolviendo JSON).
   - **Modelos (`src/models/*`)**: Contienen únicamente las consultas SQL preparadas con PDO utilizando `src/config/conexion.php`.
