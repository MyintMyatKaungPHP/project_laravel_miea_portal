# API Documentation

Welcome to the MIEA Portal API documentation. This API provides endpoints for Authentication and Blog Management.

## Base URL

```
http://project_laravel_miea_portal.test/api
```

## Authentication

The API uses **Laravel Sanctum** for authentication. Protected endpoints require authentication using a Bearer token.

---

## Authentication API

Base Path: `/api/auth`

### Register

Register a new user account.

```http
POST /api/auth/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Response (201):**

```json
{
    "success": true,
    "message": "User registered successfully.",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "created_at": "2025-10-11T10:00:00.000000Z"
        },
        "access_token": "1|abcdef123456...",
        "token_type": "Bearer"
    }
}
```

### Login

Login with existing credentials.

```http
POST /api/auth/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response (200):**

```json
{
    "success": true,
    "message": "Login successful.",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "access_token": "2|ghijkl789012...",
        "token_type": "Bearer"
    }
}
```

**Error Response (401):**

```json
{
    "success": false,
    "message": "Invalid credentials."
}
```

### Logout

Logout and revoke the current access token.

```http
POST /api/auth/logout
Authorization: Bearer {token}
```

**Response (200):**

```json
{
    "success": true,
    "message": "Logged out successfully."
}
```

### Get Current User

Get authenticated user information.

```http
GET /api/auth/me
Authorization: Bearer {token}
```

**Response (200):**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "roles": [...],
        "permissions": [...],
        "created_at": "2025-10-11T10:00:00.000000Z"
    }
}
```

---

## Blog Management API

Base Path: `/api/blog`

### Posts

#### List All Posts

```http
GET /api/blog/posts
```

**Response:**

```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "title": "My First Blog Post",
                "slug": "my-first-blog-post",
                "content": "This is the content...",
                "thumbnail": "thumbnails/image.jpg",
                "tags": ["laravel", "filament"],
                "published": true,
                "user": {
                    "id": 1,
                    "name": "John Doe",
                    "email": "john@example.com"
                },
                "category": {
                    "id": 1,
                    "name": "Technology",
                    "slug": "technology",
                    "color": "#3B82F6"
                },
                "created_at": "2025-10-11T10:00:00.000000Z"
            }
        ],
        "per_page": 15,
        "total": 50
    }
}
```

#### List Published Posts Only

```http
GET /api/blog/posts/published
```

#### Get Posts by Category

```http
GET /api/blog/posts/category/{category_id}
```

**Example:**

```http
GET /api/blog/posts/category/1
```

#### Get Post by ID

```http
GET /api/blog/posts/{id}
```

#### Get Post by Slug

```http
GET /api/blog/posts/slug/{slug}
```

**Example:**

```http
GET /api/blog/posts/slug/my-first-blog-post
```

#### Create Post

```http
POST /api/blog/posts
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
    "title": "My New Post",
    "content": "This is the content of my post...",
    "category_id": 1,
    "thumbnail": (file),
    "tags": ["laravel", "api"],
    "published": true
}
```

**Note:** The `slug` will be auto-generated from the title if not provided.

**Response (201):**

```json
{
    "success": true,
    "message": "Post created successfully.",
    "data": {
        "id": 2,
        "title": "My New Post",
        "slug": "my-new-post",
        "content": "This is the content...",
        "thumbnail": "thumbnails/abc123.jpg",
        "tags": ["laravel", "api"],
        "published": true,
        "user": {...},
        "category": {...},
        "created_at": "2025-10-11T11:00:00.000000Z"
    }
}
```

#### Update Post

```http
PUT /api/blog/posts/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "Updated Post Title",
    "content": "Updated content...",
    "category_id": 1,
    "tags": ["laravel", "filament", "api"],
    "published": true
}
```

#### Delete Post

```http
DELETE /api/blog/posts/{id}
Authorization: Bearer {token}
```

**Response (200):**

```json
{
    "success": true,
    "message": "Post deleted successfully."
}
```

#### Publish Post

```http
POST /api/blog/posts/{id}/publish
Authorization: Bearer {token}
```

**Response (200):**

```json
{
    "success": true,
    "message": "Post published successfully.",
    "data": {...}
}
```

#### Unpublish Post

```http
POST /api/blog/posts/{id}/unpublish
Authorization: Bearer {token}
```

---

### Categories

#### List All Categories

```http
GET /api/blog/categories
```

**Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Technology",
            "slug": "technology",
            "color": "#3B82F6",
            "posts_count": 15,
            "created_at": "2025-10-11T10:00:00.000000Z"
        }
    ]
}
```

#### Get Category by ID

```http
GET /api/blog/categories/{id}
```

#### Get Category by Slug

```http
GET /api/blog/categories/slug/{slug}
```

**Example:**

```http
GET /api/blog/categories/slug/technology
```

#### Create Category

```http
POST /api/blog/categories
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "Technology",
    "color": "#3B82F6"
}
```

**Note:** The `slug` will be auto-generated from the name if not provided.

**Response (201):**

```json
{
    "success": true,
    "message": "Category created successfully.",
    "data": {
        "id": 2,
        "name": "Technology",
        "slug": "technology",
        "color": "#3B82F6",
        "created_at": "2025-10-11T11:00:00.000000Z"
    }
}
```

#### Update Category

```http
PUT /api/blog/categories/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "Technology Updated",
    "color": "#EF4444"
}
```

#### Delete Category

```http
DELETE /api/blog/categories/{id}
Authorization: Bearer {token}
```

**Note:** Categories with existing posts cannot be deleted.

**Error Response (422):**

```json
{
    "success": false,
    "message": "Cannot delete category with existing posts."
}
```

---

## Error Responses

### 401 Unauthorized

```json
{
    "message": "Unauthenticated."
}
```

### 422 Validation Error

```json
{
    "success": false,
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password field must be at least 8 characters."]
    }
}
```

### 404 Not Found

```json
{
    "message": "No query results for model [App\\Models\\Post] 999"
}
```

### 500 Server Error

```json
{
    "message": "Server Error"
}
```

---

## Response Format

All successful responses follow this format:

```json
{
    "success": true,
    "data": {...},
    "message": "Optional success message"
}
```

All error responses follow this format:

```json
{
    "success": false,
    "errors": {...},
    "message": "Optional error message"
}
```

---

## Rate Limiting

API requests are rate-limited to **60 requests per minute** per IP address.

---

## Pagination

List endpoints return paginated results with the following structure:

```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [...],
        "first_page_url": "http://...",
        "from": 1,
        "last_page": 10,
        "last_page_url": "http://...",
        "next_page_url": "http://...",
        "path": "http://...",
        "per_page": 15,
        "prev_page_url": null,
        "to": 15,
        "total": 150
    }
}
```

To navigate pages, use the `page` query parameter:

```http
GET /api/blog/posts?page=2
```

---

## Example Usage

### Complete Authentication Flow

#### 1. Register

```bash
curl -X POST "http://project_laravel_miea_portal.test/api/auth/register" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

#### 2. Login

```bash
curl -X POST "http://project_laravel_miea_portal.test/api/auth/login" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

**Save the `access_token` from the response!**

#### 3. Get Current User

```bash
curl -X GET "http://project_laravel_miea_portal.test/api/auth/me" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

#### 4. Logout

```bash
curl -X POST "http://project_laravel_miea_portal.test/api/auth/logout" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Blog Management Examples

#### Get All Published Posts

```bash
curl -X GET "http://project_laravel_miea_portal.test/api/blog/posts/published" \
  -H "Accept: application/json"
```

#### Create Post (Authenticated)

```bash
curl -X POST "http://project_laravel_miea_portal.test/api/blog/posts" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "My API Post",
    "content": "Content created via API",
    "category_id": 1,
    "tags": ["laravel", "api"],
    "published": true
  }'
```

#### Get Post by Slug

```bash
curl -X GET "http://project_laravel_miea_portal.test/api/blog/posts/slug/my-api-post" \
  -H "Accept: application/json"
```

#### Create Category (Authenticated)

```bash
curl -X POST "http://project_laravel_miea_portal.test/api/blog/categories" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Technology",
    "color": "#3B82F6"
  }'
```

---

## API Endpoints Summary

### Authentication (4 endpoints)

-   `POST /api/auth/register` - Register new user
-   `POST /api/auth/login` - Login user
-   `POST /api/auth/logout` - Logout user (protected)
-   `GET /api/auth/me` - Get current user (protected)

### Blog Posts (11 endpoints)

-   `GET /api/blog/posts` - List all posts
-   `GET /api/blog/posts/published` - List published posts
-   `GET /api/blog/posts/{id}` - Get post by ID
-   `GET /api/blog/posts/slug/{slug}` - Get post by slug
-   `GET /api/blog/posts/category/{id}` - Get posts by category
-   `POST /api/blog/posts` - Create post (protected)
-   `PUT /api/blog/posts/{id}` - Update post (protected)
-   `DELETE /api/blog/posts/{id}` - Delete post (protected)
-   `POST /api/blog/posts/{id}/publish` - Publish post (protected)
-   `POST /api/blog/posts/{id}/unpublish` - Unpublish post (protected)
-   `GET /api/user` - Get authenticated user (protected)

### Categories (6 endpoints)

-   `GET /api/blog/categories` - List all categories
-   `GET /api/blog/categories/{id}` - Get category by ID
-   `GET /api/blog/categories/slug/{slug}` - Get category by slug
-   `POST /api/blog/categories` - Create category (protected)
-   `PUT /api/blog/categories/{id}` - Update category (protected)
-   `DELETE /api/blog/categories/{id}` - Delete category (protected)

**Total: 21 API endpoints**

---

## Postman Collection

You can create and manage API documentation using the Filament API Docs Builder interface at:

```
http://project_laravel_miea_portal.test/portal/api-docs
```

Features:

-   Visual API documentation
-   Export to Postman JSON format
-   Import from Postman collection
-   Code examples in multiple languages
-   Test API endpoints directly from the interface

---

## Support

For issues or questions, please contact the development team.
