# Laravel-Ecommerce-Demo

## **About Demo**

This is a simple ecommerce demo buit using laravel framework.

## **Features**

- **Admin Panel**

  - Product Categories CRUD
  - Products CRUD
  - Abondon cart list
  - Customer list / View / Delete
  - Admin users CRUD with roles and permissions
  - Order Listing

- **Store Front**
  - Product listing
  - Product listing by category

## **About Porject**

- Used **Database Migrations**
- Seperated request validation by **FormRequest**
- Used **Unit Testing** for all modules

- Store Admin can be accessed by `/admin` route

---

# To run the project

**Step 1** - Install all depedencies

```bash
composer install
npm install
```

**Step 2** - Setup enviroment and DB variables

```
cp .env.example .env
```

**Step 3** - Run DB migrations

```
php artisan migrate
```

**Step 3** - Run project

```
php artisan serve
```
