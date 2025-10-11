# API Documentation Management Guide

This guide explains how to manage and update API documentation using Filament API Docs Builder.

## Quick Access

### Admin Panel

```
http://project_laravel_miea_portal.test/portal/api-docs-resource/api-docs
```

**Navigation:** Portal → API Docs Resource

---

## Features

### 1. Visual Documentation Builder

-   Create API endpoint documentation through UI
-   Add request/response examples
-   Organize by versions and collections
-   Support for multiple HTTP methods

### 2. Postman Integration

-   Export documentation to Postman JSON format
-   Import Postman collections
-   Auto-generate documentation from collections

### 3. Code Examples

-   Multiple language support
-   Syntax highlighting
-   Copy-to-clipboard functionality

### 4. Testing Interface

-   Test endpoints directly from the interface
-   Save request parameters
-   View response in real-time

---

## Current API Structure

### Authentication Endpoints (4)

```
POST   /api/auth/register       - Register new user
POST   /api/auth/login          - Login user
POST   /api/auth/logout         - Logout user (protected)
GET    /api/auth/me             - Get current user (protected)
```

### Blog Posts Endpoints (11)

```
GET    /api/blog/posts                    - List all posts
GET    /api/blog/posts/published          - List published posts
GET    /api/blog/posts/{id}               - Get post by ID
GET    /api/blog/posts/slug/{slug}        - Get post by slug
GET    /api/blog/posts/category/{id}      - Get posts by category
POST   /api/blog/posts                    - Create post (protected)
PUT    /api/blog/posts/{id}               - Update post (protected)
DELETE /api/blog/posts/{id}               - Delete post (protected)
POST   /api/blog/posts/{id}/publish       - Publish post (protected)
POST   /api/blog/posts/{id}/unpublish     - Unpublish post (protected)
GET    /api/user                          - Get authenticated user (protected)
```

### Categories Endpoints (6)

```
GET    /api/blog/categories               - List all categories
GET    /api/blog/categories/{id}          - Get category by ID
GET    /api/blog/categories/slug/{slug}   - Get category by slug
POST   /api/blog/categories               - Create category (protected)
PUT    /api/blog/categories/{id}          - Update category (protected)
DELETE /api/blog/categories/{id}          - Delete category (protected)
```

**Total: 21 Endpoints**

---

## How to Create API Documentation

### Step 1: Access API Docs

1. Login to portal: `http://project_laravel_miea_portal.test/portal`
2. Navigate to **API Docs Resource** in sidebar
3. Click **Create** button

### Step 2: Fill Basic Information

```
Title: MIEA Portal API
Version: v1.0
Description: Authentication and Blog Management API
Base URL: http://project_laravel_miea_portal.test/api
```

### Step 3: Add Authentication Endpoints

#### Register Endpoint

```
Collection: Authentication
Name: Register User
Method: POST
Path: /auth/register
Description: Register a new user account

Headers:
- Content-Type: application/json

Body (JSON):
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}

Response (201):
{
    "success": true,
    "message": "User registered successfully.",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "access_token": "1|abcdef123456...",
        "token_type": "Bearer"
    }
}
```

#### Login Endpoint

```
Collection: Authentication
Name: Login
Method: POST
Path: /auth/login
Description: Login with credentials

Headers:
- Content-Type: application/json

Body (JSON):
{
    "email": "john@example.com",
    "password": "password123"
}

Response (200):
{
    "success": true,
    "message": "Login successful.",
    "data": {
        "user": {...},
        "access_token": "2|ghijkl789012...",
        "token_type": "Bearer"
    }
}
```

#### Logout Endpoint

```
Collection: Authentication
Name: Logout
Method: POST
Path: /auth/logout
Description: Logout and revoke token
Authentication: Bearer Token

Headers:
- Authorization: Bearer {token}

Response (200):
{
    "success": true,
    "message": "Logged out successfully."
}
```

#### Get Current User

```
Collection: Authentication
Name: Get Current User
Method: GET
Path: /auth/me
Description: Get authenticated user information
Authentication: Bearer Token

Headers:
- Authorization: Bearer {token}

Response (200):
{
    "success": true,
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "roles": [...],
        "permissions": [...]
    }
}
```

### Step 4: Add Blog Posts Endpoints

#### List Posts

```
Collection: Blog - Posts
Name: List All Posts
Method: GET
Path: /blog/posts
Description: Get paginated list of posts

Response (200):
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "title": "My Post",
                "slug": "my-post",
                "content": "Content...",
                "thumbnail": "thumbnails/image.jpg",
                "tags": ["laravel", "filament"],
                "published": true,
                "user": {...},
                "category": {...}
            }
        ],
        "per_page": 15,
        "total": 50
    }
}
```

#### List Published Posts

```
Collection: Blog - Posts
Name: List Published Posts
Method: GET
Path: /blog/posts/published
Description: Get only published posts
```

#### Get Post by ID

```
Collection: Blog - Posts
Name: Get Post
Method: GET
Path: /blog/posts/{id}
Description: Get specific post by ID

Parameters:
- id (path): Post ID

Response (200):
{
    "success": true,
    "data": {
        "id": 1,
        "title": "My Post",
        ...
    }
}
```

#### Get Post by Slug

```
Collection: Blog - Posts
Name: Get Post by Slug
Method: GET
Path: /blog/posts/slug/{slug}
Description: Get specific post by slug

Parameters:
- slug (path): Post slug

Example: /blog/posts/slug/my-first-post
```

#### Get Posts by Category

```
Collection: Blog - Posts
Name: Get Posts by Category
Method: GET
Path: /blog/posts/category/{category}
Description: Get posts filtered by category

Parameters:
- category (path): Category ID
```

#### Create Post

```
Collection: Blog - Posts
Name: Create Post
Method: POST
Path: /blog/posts
Description: Create a new blog post
Authentication: Bearer Token

Headers:
- Authorization: Bearer {token}
- Content-Type: application/json

Body (JSON):
{
    "title": "My New Post",
    "content": "Post content here...",
    "category_id": 1,
    "tags": ["laravel", "api"],
    "published": true
}

Response (201):
{
    "success": true,
    "message": "Post created successfully.",
    "data": {...}
}
```

#### Update Post

```
Collection: Blog - Posts
Name: Update Post
Method: PUT
Path: /blog/posts/{id}
Description: Update existing post
Authentication: Bearer Token

Parameters:
- id (path): Post ID

Headers:
- Authorization: Bearer {token}
- Content-Type: application/json

Body (JSON):
{
    "title": "Updated Title",
    "content": "Updated content...",
    "category_id": 1,
    "tags": ["laravel"],
    "published": true
}
```

#### Delete Post

```
Collection: Blog - Posts
Name: Delete Post
Method: DELETE
Path: /blog/posts/{id}
Description: Delete a post
Authentication: Bearer Token

Parameters:
- id (path): Post ID

Headers:
- Authorization: Bearer {token}

Response (200):
{
    "success": true,
    "message": "Post deleted successfully."
}
```

#### Publish Post

```
Collection: Blog - Posts
Name: Publish Post
Method: POST
Path: /blog/posts/{id}/publish
Description: Publish a post
Authentication: Bearer Token

Parameters:
- id (path): Post ID

Headers:
- Authorization: Bearer {token}
```

#### Unpublish Post

```
Collection: Blog - Posts
Name: Unpublish Post
Method: POST
Path: /blog/posts/{id}/unpublish
Description: Unpublish a post
Authentication: Bearer Token

Parameters:
- id (path): Post ID

Headers:
- Authorization: Bearer {token}
```

### Step 5: Add Categories Endpoints

#### List Categories

```
Collection: Blog - Categories
Name: List All Categories
Method: GET
Path: /blog/categories
Description: Get all categories with post counts

Response (200):
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Technology",
            "slug": "technology",
            "color": "#3B82F6",
            "posts_count": 15
        }
    ]
}
```

#### Get Category

```
Collection: Blog - Categories
Name: Get Category
Method: GET
Path: /blog/categories/{id}
Description: Get specific category

Parameters:
- id (path): Category ID
```

#### Get Category by Slug

```
Collection: Blog - Categories
Name: Get Category by Slug
Method: GET
Path: /blog/categories/slug/{slug}
Description: Get category by slug

Parameters:
- slug (path): Category slug
```

#### Create Category

```
Collection: Blog - Categories
Name: Create Category
Method: POST
Path: /blog/categories
Description: Create new category
Authentication: Bearer Token

Headers:
- Authorization: Bearer {token}
- Content-Type: application/json

Body (JSON):
{
    "name": "Technology",
    "color": "#3B82F6"
}

Response (201):
{
    "success": true,
    "message": "Category created successfully.",
    "data": {
        "id": 2,
        "name": "Technology",
        "slug": "technology",
        "color": "#3B82F6"
    }
}
```

#### Update Category

```
Collection: Blog - Categories
Name: Update Category
Method: PUT
Path: /blog/categories/{id}
Description: Update existing category
Authentication: Bearer Token

Parameters:
- id (path): Category ID

Headers:
- Authorization: Bearer {token}
- Content-Type: application/json

Body (JSON):
{
    "name": "Technology Updated",
    "color": "#EF4444"
}
```

#### Delete Category

```
Collection: Blog - Categories
Name: Delete Category
Method: DELETE
Path: /blog/categories/{id}
Description: Delete a category (only if no posts)
Authentication: Bearer Token

Parameters:
- id (path): Category ID

Headers:
- Authorization: Bearer {token}

Error Response (422):
{
    "success": false,
    "message": "Cannot delete category with existing posts."
}
```

---

## Export & Import

### Export to Postman

1. Go to API Docs list
2. Click **Export** action
3. Choose **Postman Collection**
4. Download JSON file
5. Import in Postman: File → Import → Select downloaded file

### Import from Postman

1. Click **Import** action
2. Upload Postman collection JSON
3. Review and save
4. Documentation will be auto-generated

---

## Best Practices

### 1. Organization

-   Group endpoints by collection (Authentication, Blog - Posts, Blog - Categories)
-   Use clear, descriptive names
-   Add detailed descriptions

### 2. Examples

-   Provide realistic example data
-   Include both success and error responses
-   Show common use cases

### 3. Authentication

-   Clearly mark protected endpoints
-   Include authentication header examples
-   Document token format

### 4. Versioning

-   Use version numbers (v1.0, v1.1)
-   Document breaking changes
-   Keep old versions accessible

### 5. Testing

-   Test each endpoint before documenting
-   Verify request/response formats
-   Update when API changes

---

## Quick Reference

### Common Response Codes

-   `200` - Success
-   `201` - Created
-   `401` - Unauthorized
-   `422` - Validation Error
-   `404` - Not Found
-   `500` - Server Error

### Authentication Header

```
Authorization: Bearer {your-token-here}
```

### Content Types

```
application/json          - JSON data
multipart/form-data      - File uploads
application/x-www-form-urlencoded  - Form data
```

---

## Maintenance

### When to Update

-   ✅ New endpoint added
-   ✅ Endpoint modified
-   ✅ New parameters added
-   ✅ Response format changed
-   ✅ Authentication method changed

### Update Process

1. Login to portal
2. Navigate to API Docs
3. Find relevant endpoint
4. Click **Edit**
5. Update information
6. Save changes
7. Export new Postman collection (optional)

---

## Resources

-   **Live Documentation**: http://project_laravel_miea_portal.test/portal/api-docs-resource/api-docs
-   **API Base URL**: http://project_laravel_miea_portal.test/api
-   **Backend Panel**: http://project_laravel_miea_portal.test/portal
-   **Markdown Documentation**: API_DOCUMENTATION.md

---

## Support

For technical issues or questions:

-   Check error logs in Laravel
-   Review Filament Shield permissions
-   Verify Sanctum configuration
-   Contact development team
