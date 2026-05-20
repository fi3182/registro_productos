-- ==========================================
-- Base de Datos: Registro de Productos
-- Motor: PostgreSQL
-- ==========================================

-- Tabla de bodegas
CREATE TABLE bodegas (
    id_bodega SERIAL PRIMARY KEY,
    nombre_bodega VARCHAR(100) NOT NULL
);

-- Tabla de sucursales (depende de bodega)
CREATE TABLE sucursales (
    id_sucursal SERIAL PRIMARY KEY,
    id_bodega INT NOT NULL,
    nombre_sucursal VARCHAR(100) NOT NULL,
    FOREIGN KEY (id_bodega) REFERENCES bodegas(id_bodega)
);

-- Tabla de monedas
CREATE TABLE monedas (
    id_moneda SERIAL PRIMARY KEY,
    nombre_moneda VARCHAR(50) NOT NULL
);

-- Tabla de materiales
CREATE TABLE materiales (
    id_material SERIAL PRIMARY KEY,
    nombre_material VARCHAR(50) NOT NULL
);

-- Tabla de productos
CREATE TABLE productos (
    id_producto SERIAL PRIMARY KEY,
    codigo_producto VARCHAR(15) UNIQUE NOT NULL,
    nombre_producto VARCHAR(50) NOT NULL,
    id_bodega INT NOT NULL,
    id_sucursal INT NOT NULL,
    id_moneda INT NOT NULL,
    precio NUMERIC(10,2) NOT NULL,
    descripcion TEXT NOT NULL,
    FOREIGN KEY (id_bodega) REFERENCES bodegas(id_bodega),
    FOREIGN KEY (id_sucursal) REFERENCES sucursales(id_sucursal),
    FOREIGN KEY (id_moneda) REFERENCES monedas(id_moneda)
);

-- Relación productos-materiales (checkbox múltiples)
CREATE TABLE producto_material (
    id_producto INT NOT NULL,
    id_material INT NOT NULL,
    PRIMARY KEY (id_producto, id_material),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto),
    FOREIGN KEY (id_material) REFERENCES materiales(id_material)
);

-- ==========================================
-- DATOS DE PRUEBA (para que el formulario cargue opciones)
-- ==========================================

INSERT INTO bodegas (nombre_bodega) VALUES
('Bodega Central'),
('Bodega Norte'),
('Bodega Sur');

INSERT INTO sucursales (id_bodega, nombre_sucursal) VALUES
(1, 'Sucursal Santiago'),
(1, 'Sucursal Maipú'),
(2, 'Sucursal Antofagasta'),
(2, 'Sucursal Iquique'),
(3, 'Sucursal Concepción'),
(3, 'Sucursal Temuco');

INSERT INTO monedas (nombre_moneda) VALUES
('CLP'),
('USD'),
('EUR');

INSERT INTO materiales (nombre_material) VALUES
('Plástico'),
('Metal'),
('Madera'),
('Vidrio'),
('Textil');