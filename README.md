# MercadoLiebre - Dataset

## 📌 Descripción
MercadoLiebre es un dataset ficticio de **E-commerce**, diseñado para fines educativos.
Se generará usando **Laravel** con **Faker** para poblar la base de datos con datos realistas.

## 📦 Tecnologías utilizadas
- **Laravel** (Framework PHP)
- **PostgreSQL / MySQL** (Base de datos)
- **Faker** (Generación de datos ficticios)
- **Eloquent ORM** (Relaciones entre modelos)

## 📂 Estructura del Proyecto

```bash
mercado-liebre/
├── app/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   ├── Payment.php
│   │   ├── Shipment.php
│   ├── Factories/
│   ├── Seeders/
│
├── database/
│   ├── migrations/
│   │   ├── 2024_xx_xx_create_users_table.php
│   │   ├── 2024_xx_xx_create_products_table.php
│   │   ├── 2024_xx_xx_create_orders_table.php
│   │   ├── 2024_xx_xx_create_order_items_table.php
│   │   ├── 2024_xx_xx_create_payments_table.php
│   │   ├── 2024_xx_xx_create_shipments_table.php
│
├── README.md
├── .env
├── composer.json
├── artisan
└── config/
```

## 📊 Modelos y Relaciones

### 🛍️ **Usuarios (`users`)**
- `id` (PK)
- `name` (string)
- `email` (string, único)

### 📦 **Productos (`products`)**
- `id` (PK)
- `name` (string)
- `description` (text)
- `price` (decimal)
- `stock` (integer)

### 🛒 **Órdenes (`orders`)**
- `id` (PK)
- `user_id` (FK → `users.id`)
- `total_amount` (decimal)
- `status` (`pending`, `paid`, `shipped`, `delivered`, `cancelled`)

### 📋 **Detalle de Órdenes (`order_items`)**
- `id` (PK)
- `order_id` (FK → `orders.id`)
- `product_id` (FK → `products.id`)
- `quantity` (integer)
- `unit_price` (decimal)
- `subtotal` (decimal)

### 💳 **Pagos (`payments`)**
- `id` (PK)
- `order_id` (FK → `orders.id`)
- `amount` (decimal)
- `payment_method` (`credit_card`, `paypal`, `bank_transfer`)
- `status` (`pending`, `completed`, `failed`)

### 🚚 **Envíos (`shipments`)**
- `id` (PK)
- `order_id` (FK → `orders.id`)
- `tracking_number` (string, único)
- `carrier` (string)
- `status` (`pending`, `in_transit`, `delivered`)
- `shipped_at` (datetime, nullable)
- `delivered_at` (datetime, nullable)

## 🚀 Instalación

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/tuusuario/mercado-liebre.git
   cd mercado-liebre
   ```

2. Instalar dependencias:
   ```bash
   composer install
   ```

3. Configurar el entorno:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configurar la base de datos en `.env` y ejecutar migraciones:
   ```bash
   php artisan migrate --seed
   ```

5. Iniciar el servidor:
   ```bash
   php artisan serve
   ```

## 🌱 Poblar la Base de Datos
Para generar datos ficticios:
```bash
php artisan migrate:fresh --seed

php artisan tinker
App\Models\User::factory()->count(10)->create();
App\Models\Product::factory()->count(50)->create();
App\Models\Order::factory()->count(20)->create();
App\Models\OrderItem::factory()->count(50)->create();
```

Esto creará usuarios, productos, órdenes y más datos falsos para usarlos como base de datos para practicar análisis.

## 📝 Licencia
Este proyecto es de uso libre para fines educativos.
