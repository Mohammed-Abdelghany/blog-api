# 📰 Blog API

A simple Laravel-based Blog RESTful API featuring JWT authentication, user roles, posts management, commenting system, and advanced search & filtering capabilities — all built with a clean Service Layer structure (`PostService`, `CommentService`).

---

## ✨ Features

- ✅ User registration, login, logout via **JWT**
- ✅ Role-based access control: **Admin**, **Author**
- ✅ **CRUD** operations for blog posts (with **authorization policies**)
- ✅ **Comment system** (only authenticated users)
- ✅ Advanced **search & filtering** by:
  - Title
  - Author
  - Category
  - Date range
- ✅ All endpoints protected by **policies** and **JWT middleware**
- ✅ Clean service-based architecture using `PostService`, `CommentService`, etc.

---

## ⚙️ Setup Instructions

### 1. Clone the repository  
➡️ _Applies to `PostService`, `CommentService`, etc._

```bash
git clone https://github.com/Mohammed-Abdelghany/blog-api.git
cd blog-api
```

### 2. Install dependencies  

```bash
composer install
```

### 3. Environment setup  

```bash
cp .env.example .env
```

Then update your `.env`:

```env
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_pass
```

### 4. Generate app key & JWT secret  

```bash
php artisan key:generate
php artisan jwt:secret
```

### 5. Run migrations  

```bash
php artisan migrate
```

### 6. (Optional) Seed the database  

```bash
php artisan db:seed
```

### 7. Start the development server  

```bash
php artisan serve
```

---

## 🔐 API Usage

### 🧑‍💻 Authentication

| Action   | Method | Endpoint           | Auth Required |
|----------|--------|--------------------|----------------|
| Register | POST   | `/api/register`    | ❌              |
| Login    | POST   | `/api/login`       | ❌              |
| Logout   | POST   | `/api/logout`      | ✅ (JWT Token)  |

---

### 📝 Posts (via PostService)

| Action        | Method | Endpoint              | Roles Allowed     |
|---------------|--------|-----------------------|-------------------|
| List posts    | GET    | `/api/posts`          | Any               |
| Show post     | GET    | `/api/posts/{id}`     | Any               |
| Create post   | POST   | `/api/posts`          | Admin / Author    |
| Update post   | PUT    | `/api/posts/{id}`     | Author / Admin    |
| Delete post   | DELETE | `/api/posts/{id}`     | Author / Admin    |

---

### 🔍 Search & Filter

```http
GET /api/posts?search=keyword&category=Tech&author_id=3&date_from=2024-01-01&date_to=2024-06-01
```

---

### 💬 Comments (via CommentService)

| Action        | Method | Endpoint                        | Auth Required |
|---------------|--------|----------------------------------|----------------|
| Add comment   | POST   | `/api/posts/{id}/comments`       | ✅ (JWT Token)  |

---

## 🧱 Architecture

This project uses the **Service Layer Pattern**. Example:

```
app/
├── Services/
│   ├── PostService.php
│   └── CommentService.php
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── PostController.php
│   │   └── CommentController.php
```

Each controller delegates business logic to its corresponding Service class, improving code reusability and testability.

---

## 👤 Author

- **Mohammed Abdelghany**
- GitHub: [@Mohammed-Abdelghany](https://github.com/Mohammed-Abdelghany)
- Email: muhammedabdelghany6@gmail.com

---
