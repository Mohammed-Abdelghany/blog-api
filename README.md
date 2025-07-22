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
npm install && npm run dev
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
GET /api/posts?search=laravel&category=Tech&author_id=3&date_from=2024-01-01&date_to=2024-06-01
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

## 🛡️ Security & Authorization

- **All endpoints** (except `/api/register` and `/api/login`) require a valid JWT token in the `Authorization: Bearer <token>` header.
- **Role-based access** is enforced using Laravel Policies:
  - Only **admins** or the **author** of a post can update or delete it.
  - Only authenticated users can comment on posts.
- **Sensitive user data** (such as passwords and tokens) is never exposed in API responses.

---

## 🔍 Search & Filtering

- The `search` parameter in `/api/posts` matches both post titles and author names.
- You can filter posts by `category`, `author_id`, and a date range (`date_from`, `date_to`).

**Example:**

```

```

---

## 💬 Comments

- Each comment is linked to both the post and the user who created it.
- Only authenticated users can add comments to posts.

---

## 📝 Example Policy Logic

```php
// PostPolicy.php
public function update(User $user, Post $post)
{
    return $user->role === 'admin' || ($user->role === 'author' && $user->id === $post->author_id);
}
```
✅ Testing

This project includes a suite of Feature Tests using PHPUnit to ensure core API functionality, including role-based access control and service layer operations, behaves correctly.

📂 Test Directory Structure

tests/Feature/
├── AuthTest.php
├── PostApiTest.php
├── CommentApiTest.php

🧪 Main Tests Overview

🔐 AuthTest.php

✅ User registration

✅ Login & receive JWT token

✅ Logout

📝 PostApiTest.php

✅ admin or author can create posts

❌ Unauthorized users (e.g., user role or guest) are forbidden from creating posts (403)

✅ Only admins or the author of a post can update or delete it

Example:

$response = $this->actingAs($authorUser)->postJson('/api/posts', [...]);
$response->assertStatus(200); // or 201

$response = $this->actingAs($unauthorizedUser)->postJson('/api/posts', [...]);
$response->assertStatus(403);

💬 CommentApiTest.php

✅ Authenticated users can add comments

❌ Guests (unauthenticated users) cannot comment (401)

Example:

$response = $this->postJson('/api/posts/1/comments', [...]);
$response->assertStatus(401);

⚙️ Running the Tests

Run all tests using:

php artisan test


📈 Test Coverage Summary

Covered scenarios include:

Role-based post creation/update/delete access (admin, author only)

JWT-protected endpoints

Authenticated-only commenting

Proper handling of unauthorized access (401/403 responses)

🧰 Future Suggestions

Add unit tests for individual services (e.g., PostService, CommentService)

Use factories + seeders to simulate larger datasets

Include test coverage reports with packages like phpunit/php-code-coverage

Happy Testing! ✅
```

