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

Register a new user account with optional profile image.

```http
POST /api/auth/register
Content-Type: multipart/form-data

name: John Doe
email: john@example.com
password: password123
password_confirmation: password123
profile_image: [file] (optional)
```

**Fields:**

-   `name` (required): User's full name
-   `email` (required): User's email address
-   `password` (required): Password (min 8 characters)
-   `password_confirmation` (required): Password confirmation
-   `profile_image` (optional): Profile image file (jpeg, png, jpg, gif, max 2MB)

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
            "profile_image_url": "http://project_laravel_miea_portal.test/storage/profile_images/123456_abc.png",
            "created_at": "2025-10-11T10:00:00.000000Z"
        },
        "access_token": "1|abcdef123456...",
        "token_type": "Bearer"
    }
}
```

**cURL Example:**

```bash
curl -X POST http://project_laravel_miea_portal.test/api/auth/register \
  -F "name=John Doe" \
  -F "email=john@example.com" \
  -F "password=password123" \
  -F "password_confirmation=password123" \
  -F "profile_image=@/path/to/image.png"
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

## Profile Management API

Base Path: `/api/profile`

All profile endpoints require authentication (`Authorization: Bearer {token}`).

### Get Profile

Get current authenticated user's profile information.

```http
GET /api/profile
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
        "email_verified_at": "2025-10-11T10:00:00.000000Z",
        "profile_image_url": "http://project_laravel_miea_portal.test/storage/profile_images/profile_1_123456.jpg",
        "roles": ["admin", "user"],
        "created_at": "2025-10-11T10:00:00.000000Z",
        "updated_at": "2025-10-12T15:30:00.000000Z"
    }
}
```

### Update Profile

Update current user's profile information (name and email).

```http
PUT /api/profile
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "John Updated",
    "email": "john.updated@example.com"
}
```

**Response (200):**

```json
{
    "success": true,
    "message": "Profile updated successfully",
    "data": {
        "id": 1,
        "name": "John Updated",
        "email": "john.updated@example.com",
        "email_verified_at": "2025-10-11T10:00:00.000000Z",
        "profile_image_url": "http://...",
        "roles": ["admin", "user"],
        "updated_at": "2025-10-12T16:00:00.000000Z"
    }
}
```

**Error Response (422):**

```json
{
    "success": false,
    "message": "Failed to update profile",
    "errors": {
        "email": ["The email has already been taken."]
    }
}
```

### Change Password

Change current user's password.

```http
POST /api/profile/password
Authorization: Bearer {token}
Content-Type: application/json

{
    "current_password": "oldpassword123",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
}
```

**Response (200):**

```json
{
    "success": true,
    "message": "Password changed successfully"
}
```

**Error Response (422):**

```json
{
    "success": false,
    "message": "Current password is incorrect",
    "errors": {
        "current_password": ["Current password is incorrect"]
    }
}
```

### Upload Profile Picture

Upload a new profile picture.

```http
POST /api/profile/avatar
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
    "avatar": (file)
}
```

**Validation Rules:**

-   Required: Yes
-   File Type: image (jpeg, png, jpg, gif)
-   Max Size: 2MB (2048 KB)

**Response (200):**

```json
{
    "success": true,
    "message": "Profile picture uploaded successfully",
    "data": {
        "profile_image_url": "http://project_laravel_miea_portal.test/storage/profile_images/profile_1_1728745632.jpg"
    }
}
```

**Error Response (422):**

```json
{
    "success": false,
    "message": "Invalid image file",
    "errors": {
        "avatar": [
            "The avatar must be an image.",
            "The avatar must not be greater than 2048 kilobytes."
        ]
    }
}
```

### Delete Profile Picture

Delete current user's profile picture.

```http
DELETE /api/profile/avatar
Authorization: Bearer {token}
```

**Response (200):**

```json
{
    "success": true,
    "message": "Profile picture deleted successfully"
}
```

**Error Response (404):**

```json
{
    "success": false,
    "message": "No profile picture to delete"
}
```

---

## User Management API

Base Path: `/api/users`

All user management endpoints require authentication (`Authorization: Bearer {token}`).

### List Users

Get paginated list of users with optional search and filters.

```http
GET /api/users
Authorization: Bearer {token}
```

**Query Parameters:**

-   `per_page` (optional) - Number of items per page (default: 15)
-   `search` (optional) - Search by name or email
-   `email_verified` (optional) - Filter by verification status (`true` or `false`)
-   `page` (optional) - Page number

**Response (200):**

```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "name": "John Doe",
                "email": "john@example.com",
                "profile_image": "users/profiles/profile_1.jpg",
                "email_verified_at": "2025-10-11T10:00:00.000000Z",
                "roles": [
                    {
                        "id": 1,
                        "name": "admin"
                    }
                ],
                "created_at": "2025-10-11T10:00:00.000000Z",
                "updated_at": "2025-10-12T15:30:00.000000Z"
            }
        ],
        "per_page": 15,
        "total": 50
    }
}
```

### Create User

Create a new user account.

```http
POST /api/users
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "profile_image": (file),
    "roles": ["user"]
}
```

**Response (201):**

```json
{
    "success": true,
    "message": "User created successfully",
    "data": {
        "id": 5,
        "name": "John Doe",
        "email": "john@example.com",
        "profile_image": "users/profiles/profile_1234567890.jpg",
        "email_verified_at": null,
        "roles": [
            {
                "id": 2,
                "name": "user"
            }
        ],
        "created_at": "2025-10-12T16:00:00.000000Z",
        "updated_at": "2025-10-12T16:00:00.000000Z"
    }
}
```

### Get User

Get details of a specific user.

```http
GET /api/users/{id}
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
        "profile_image": "users/profiles/profile_1.jpg",
        "email_verified_at": "2025-10-11T10:00:00.000000Z",
        "roles": [
            {
                "id": 1,
                "name": "admin"
            }
        ],
        "created_at": "2025-10-11T10:00:00.000000Z",
        "updated_at": "2025-10-12T15:30:00.000000Z"
    }
}
```

### Update User

Update an existing user.

```http
PUT /api/users/{id}
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
    "name": "John Updated",
    "email": "john.updated@example.com",
    "profile_image": (file),
    "email_verified_at": "2025-10-12T10:00:00.000000Z",
    "roles": ["admin", "user"]
}
```

**Note:** All fields are optional. Password update is also optional with confirmation:

```json
{
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
}
```

**Response (200):**

```json
{
    "success": true,
    "message": "User updated successfully",
    "data": {
        "id": 1,
        "name": "John Updated",
        "email": "john.updated@example.com",
        "profile_image": "users/profiles/profile_1_1728745632.jpg",
        "email_verified_at": "2025-10-12T10:00:00.000000Z",
        "roles": [
            {
                "id": 1,
                "name": "admin"
            },
            {
                "id": 2,
                "name": "user"
            }
        ],
        "updated_at": "2025-10-12T16:30:00.000000Z"
    }
}
```

### Delete User

Delete a user account.

```http
DELETE /api/users/{id}
Authorization: Bearer {token}
```

**Response (200):**

```json
{
    "success": true,
    "message": "User deleted successfully"
}
```

### Verify User Email

Mark user's email as verified.

```http
POST /api/users/{id}/verify
Authorization: Bearer {token}
```

**Response (200):**

```json
{
    "success": true,
    "message": "User email verified successfully",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "email_verified_at": "2025-10-12T16:45:00.000000Z"
    }
}
```

### Unverify User Email

Mark user's email as unverified.

```http
POST /api/users/{id}/unverify
Authorization: Bearer {token}
```

**Response (200):**

```json
{
    "success": true,
    "message": "User email unverified successfully",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "email_verified_at": null
    }
}
```

---

## Site Settings API

Base Path: `/api/site-settings`

All Site Settings endpoints are **public** (no authentication required) for frontend consumption.

### Get Basic Information

Get basic site information including logos, name, description, favicon, and maintenance settings.

```http
GET /api/site-settings/basic-info
```

**Response (200):**

```json
{
    "success": true,
    "data": {
        "site_name": "MIEA Portal",
        "site_description": "Myanmar International Education Academy",
        "site_logo_light": "http://project_laravel_miea_portal.test/storage/site/logos/logo-light.png",
        "site_logo_dark": "http://project_laravel_miea_portal.test/storage/site/logos/logo-dark.png",
        "site_favicon": "http://project_laravel_miea_portal.test/storage/site/favicon.ico",
        "maintenance_mode": false,
        "maintenance_message": null
    }
}
```

### Get Contact Information

Get contact details including email, phones, and address.

```http
GET /api/site-settings/contact-info
```

**Response (200):**

```json
{
    "success": true,
    "data": {
        "email": "info@miea.edu.mm",
        "phone_1": "+95 9 123 456 789",
        "phone_2": "+95 9 987 654 321",
        "address": "Yangon, Myanmar"
    }
}
```

### Get Social Media Links

Get all social media URLs.

```http
GET /api/site-settings/social-media
```

**Response (200):**

```json
{
    "success": true,
    "data": {
        "facebook": "https://facebook.com/miea",
        "instagram": "https://instagram.com/miea",
        "linkedin": "https://linkedin.com/company/miea",
        "youtube": "https://youtube.com/@miea",
        "telegram": "https://t.me/miea",
        "tiktok": "https://tiktok.com/@miea"
    }
}
```

### Get Footer Information

Get footer content, description, and logo.

```http
GET /api/site-settings/footer-info
```

**Response (200):**

```json
{
    "success": true,
    "data": {
        "copyright_text": "© 2025 MIEA. All rights reserved.",
        "description": "Leading international education provider in Myanmar",
        "logo": "http://project_laravel_miea_portal.test/storage/site/footer-logo.png"
    }
}
```

### Get SEO Settings

Get SEO meta information and analytics ID.

```http
GET /api/site-settings/seo-settings
```

**Response (200):**

```json
{
    "success": true,
    "data": {
        "meta_description": "Leading international education provider in Myanmar",
        "meta_keywords": "education, Myanmar, international, academy",
        "google_analytics_id": "GA-XXXX-XXXX"
    }
}
```

### Get Homepage Settings

Get homepage maintenance settings.

```http
GET /api/site-settings/homepage
```

**Response (200):**

```json
{
    "success": true,
    "data": {
        "page_under_maintenance": false,
        "under_maintenance_message": null
    }
}
```

### Get Hero Section Data

Get hero section information including school name, typewriter texts, and single hero image.

```http
GET /api/site-settings/hero-section
```

**Response (200):**

```json
{
    "success": true,
    "data": {
        "school_name": "Myanmar International Education Academy",
        "typewriter_texts": [
            "Excellence in Education",
            "Global Standards",
            "Future Leaders"
        ],
        "intro_text": "Welcome to MIEA",
        "hero_image": "http://project_laravel_miea_portal.test/storage/hero/image1.jpg",
        "button_text": "Learn More",
        "button_link": "/about",
        "button_show": true
    }
}
```

### Get About Section Data

Get about section information including title, content, image, mission, and vision.

```http
GET /api/site-settings/about-section
```

**Response (200):**

```json
{
    "success": true,
    "data": {
        "title": "About MIEA",
        "content": "We are committed to excellence in education...",
        "image": "http://project_laravel_miea_portal.test/storage/about/about.jpg",
        "mission": "To provide quality education with global standards",
        "vision": "To be the leading educational institution in Myanmar"
    }
}
```

### Get Achievement Statistics

Get achievement statistics and numbers.

```http
GET /api/site-settings/achievements
```

**Response (200):**

```json
{
    "success": true,
    "data": {
        "graduated_students": 5000,
        "qualified_teachers": 150,
        "student_teacher_ratio": "15:1",
        "courses_offered": 50
    }
}
```

### Get Intro Video Information

Get intro video title and URL.

```http
GET /api/site-settings/intro-video
```

**Response (200):**

```json
{
    "success": true,
    "data": {
        "title": "Discover MIEA",
        "video_url": "https://youtube.com/watch?v=..."
    }
}
```

### Get Organizational Structure Page Data

Get leadership members and organizational structure images.

```http
GET /api/site-settings/organizational-structure-page
```

**Response (200):**

```json
{
    "success": true,
    "data": {
        "org_structure": {
            "light_image": "http://project_laravel_miea_portal.test/storage/org/structure-light.png",
            "dark_image": "http://project_laravel_miea_portal.test/storage/org/structure-dark.png"
        },
        "leadership": [
            {
                "id": 1,
                "name": "Dr. John Smith",
                "role": "Principal",
                "image": "http://project_laravel_miea_portal.test/storage/leadership/john.jpg",
                "color_code": "#3B82F6",
                "order": 1
            }
        ]
    }
}
```

### Get About Page Data

Get about page data (same structure as organizational structure page).

```http
GET /api/site-settings/about-page
```

**Response (200):**

```json
{
    "success": true,
    "data": {
        "org_structure": {
            "light_image": "http://project_laravel_miea_portal.test/storage/org/structure-light.png",
            "dark_image": "http://project_laravel_miea_portal.test/storage/org/structure-dark.png"
        },
        "leadership": [
            {
                "id": 1,
                "name": "Dr. John Smith",
                "role": "Principal",
                "image": "http://project_laravel_miea_portal.test/storage/leadership/john.jpg",
                "color_code": "#3B82F6",
                "order": 1
            }
        ]
    }
}
```

### Get All Settings

Get all site settings in one comprehensive request.

```http
GET /api/site-settings/all
```

**Response (200):**

```json
{
    "success": true,
    "data": {
        "basic_info": {
            "site_name": "MIEA Portal",
            "site_description": "Myanmar International Education Academy",
            "site_logo_light": "http://project_laravel_miea_portal.test/storage/site/logos/logo-light.png",
            "site_logo_dark": "http://project_laravel_miea_portal.test/storage/site/logos/logo-dark.png",
            "site_favicon": "http://project_laravel_miea_portal.test/storage/site/favicon.ico",
            "maintenance_mode": false,
            "maintenance_message": null
        },
        "contact_info": {
            "email": "info@miea.edu.mm",
            "phone_1": "+95 9 123 456 789",
            "phone_2": "+95 9 987 654 321",
            "address": "Yangon, Myanmar"
        },
        "social_media": {
            "facebook": "https://facebook.com/miea",
            "instagram": "https://instagram.com/miea",
            "linkedin": "https://linkedin.com/company/miea",
            "youtube": "https://youtube.com/@miea",
            "telegram": "https://t.me/miea",
            "tiktok": "https://tiktok.com/@miea"
        },
        "footer": {
            "copyright_text": "© 2025 MIEA. All rights reserved.",
            "description": "Leading international education provider in Myanmar",
            "logo": "http://project_laravel_miea_portal.test/storage/site/footer-logo.png"
        },
        "seo": {
            "meta_description": "Leading international education provider in Myanmar",
            "meta_keywords": "education, Myanmar, international, academy",
            "google_analytics_id": "GA-XXXX-XXXX"
        },
        "homepage": {
            "page_under_maintenance": false,
            "under_maintenance_message": null,
            "hero_section": {
                "school_name": "Myanmar International Education Academy",
                "typewriter_texts": [
                    "Excellence in Education",
                    "Global Standards",
                    "Future Leaders"
                ],
                "intro_text": "Welcome to MIEA",
                "hero_image": "http://project_laravel_miea_portal.test/storage/hero/image1.jpg",
                "button_text": "Learn More",
                "button_link": "/about",
                "button_show": true
            },
            "about_section": {
                "title": "About MIEA",
                "content": "We are committed to excellence in education...",
                "image": "http://project_laravel_miea_portal.test/storage/about/about.jpg",
                "mission": "To provide quality education with global standards",
                "vision": "To be the leading educational institution in Myanmar"
            },
            "achievements": {
                "graduated_students": 5000,
                "qualified_teachers": 150,
                "student_teacher_ratio": "15:1",
                "courses_offered": 50
            },
            "intro_video": {
                "title": "Discover MIEA",
                "video_url": "https://youtube.com/watch?v=..."
            }
        }
    }
}
```

---

## Service Cards API

Base Path: `/api/service-cards`

### List All Service Cards

Get all active service cards.

```http
GET /api/service-cards
```

**Response (200):**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "A Level",
            "details": "Year 12 - Year 13 (iAS & iAL)",
            "image": "http://project_laravel_miea_portal.test/storage/service-cards/graduation2024.jpg",
            "overlay_color": "#ef4444",
            "link": "/programmes#a-level"
        },
        {
            "id": 2,
            "title": "Upper Secondary Level",
            "details": "Year 10 - Year 11 (iGCSE)",
            "image": "http://project_laravel_miea_portal.test/storage/service-cards/graduation2024.jpg",
            "overlay_color": "#22c55e",
            "link": "/programmes#upper-secondary"
        },
        {
            "id": 3,
            "title": "Lower Secondary Level",
            "details": "Year 7 - Year 8 - Year 9 (Pre-iGCSE)",
            "image": "http://project_laravel_miea_portal.test/storage/service-cards/graduation2024.jpg",
            "overlay_color": "#3b82f6",
            "link": "/programmes#lower-secondary"
        }
    ]
}
```

### Get Single Service Card

```http
GET /api/service-cards/{id}
```

**Response (200):**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "title": "A Level",
        "details": "Year 12 - Year 13 (iAS & iAL)",
        "image": "http://project_laravel_miea_portal.test/storage/service-cards/graduation2024.jpg",
        "overlay_color": "#ef4444",
        "link": "/programmes#a-level"
    }
}
```

**Error Response (404):**

```json
{
    "success": false,
    "message": "Service card not found"
}
```

---

## Testimonials API

Base Path: `/api/testimonials`

### List All Testimonials

Get all active testimonials.

```http
GET /api/testimonials
```

**Response (200):**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "John Doe",
            "role": "Alumni",
            "content": "Great experience at MIEA",
            "image_url": "http://project_laravel_miea_portal.test/storage/testimonials/john.jpg"
        }
    ]
}
```

### Get Single Testimonial

```http
GET /api/testimonials/{id}
```

---

## Partners API

Base Path: `/api/partners`

### List All Partners

Get all active partners.

```http
GET /api/partners
```

**Response (200):**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Partner University",
            "image_url": "http://project_laravel_miea_portal.test/storage/partners/partner1.jpg"
        }
    ]
}
```

### Get Single Partner

```http
GET /api/partners/{id}
```

---

## Leadership API

Base Path: `/api/leadership`

### List All Leadership Members

Get all active leadership members.

```http
GET /api/leadership
```

**Response (200):**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Dr. John Smith",
            "role": "Principal",
            "image_url": "http://project_laravel_miea_portal.test/storage/leadership/john.jpg",
            "color_code": "#3B82F6"
        }
    ]
}
```

### Get Single Leadership Member

```http
GET /api/leadership/{id}
```

---

## School Achievements API

Base Path: `/api/school-achievements`

### List All School Achievements

Get all active school achievements by year.

```http
GET /api/school-achievements
```

**Response (200):**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "ac_year": "2024-2025",
            "achievement_list": [
                "National Science Fair Winner",
                "Best School Award",
                "100% Pass Rate"
            ]
        }
    ]
}
```

### Get Single School Achievement

```http
GET /api/school-achievements/{id}
```

---

## Programme Images API

Base Path: `/api/programme-images`

### List All Programme Images

Get all programme images.

```http
GET /api/programme-images
```

**Response (200):**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "programme_name": "A Level Programme",
            "images": [
                "http://project_laravel_miea_portal.test/storage/programmes/images/alevel1.jpg",
                "http://project_laravel_miea_portal.test/storage/programmes/images/alevel2.jpg"
            ]
        },
        {
            "id": 2,
            "programme_name": "Upper Secondary Programme",
            "images": [
                "http://project_laravel_miea_portal.test/storage/programmes/images/upper1.jpg"
            ]
        },
        {
            "id": 3,
            "programme_name": "Lower Secondary Programme",
            "images": [
                "http://project_laravel_miea_portal.test/storage/programmes/images/lower1.jpg"
            ]
        }
    ]
}
```

### Get Programme Images by Programme Name

```http
GET /api/programme-images/programme/{programmeName}
```

**Example:**

```http
GET /api/programme-images/programme/A Level Programme
```

**Response (200):**

```json
{
    "success": true,
    "data": {
        "id": 1,
        "programme_name": "A Level Programme",
        "images": [
            "http://project_laravel_miea_portal.test/storage/programmes/images/alevel1.jpg",
            "http://project_laravel_miea_portal.test/storage/programmes/images/alevel2.jpg"
        ]
    }
}
```

### Get Single Programme Image

```http
GET /api/programme-images/{id}
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

### User Management Examples

#### List Users with Search

```bash
curl -X GET "http://project_laravel_miea_portal.test/api/users?search=john&email_verified=true&per_page=20" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

#### Create User

```bash
curl -X POST "http://project_laravel_miea_portal.test/api/users" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -F "name=John Doe" \
  -F "email=john@example.com" \
  -F "password=password123" \
  -F "password_confirmation=password123" \
  -F "profile_image=@/path/to/profile.jpg" \
  -F "roles[]=user"
```

#### Update User

```bash
curl -X PUT "http://project_laravel_miea_portal.test/api/users/5" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -F "name=John Updated" \
  -F "email=john.updated@example.com" \
  -F "profile_image=@/path/to/new-profile.jpg" \
  -F "roles[]=admin" \
  -F "roles[]=user"
```

#### Verify User Email

```bash
curl -X POST "http://project_laravel_miea_portal.test/api/users/5/verify" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

#### Delete User

```bash
curl -X DELETE "http://project_laravel_miea_portal.test/api/users/5" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

### Profile Management Examples

#### Get Current Profile

```bash
curl -X GET "http://project_laravel_miea_portal.test/api/profile" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

#### Update Profile

```bash
curl -X PUT "http://project_laravel_miea_portal.test/api/profile" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Updated",
    "email": "john.updated@example.com"
  }'
```

#### Change Password

```bash
curl -X POST "http://project_laravel_miea_portal.test/api/profile/password" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "current_password": "oldpassword123",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
  }'
```

#### Upload Profile Picture

```bash
curl -X POST "http://project_laravel_miea_portal.test/api/profile/avatar" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -F "avatar=@/path/to/your/profile-picture.jpg"
```

#### Delete Profile Picture

```bash
curl -X DELETE "http://project_laravel_miea_portal.test/api/profile/avatar" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

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

### Profile Management (5 endpoints)

-   `GET /api/profile` - Get current user's profile (protected)
-   `PUT /api/profile` - Update profile information (protected)
-   `POST /api/profile/password` - Change password (protected)
-   `POST /api/profile/avatar` - Upload profile picture (protected)
-   `DELETE /api/profile/avatar` - Delete profile picture (protected)

### User Management (8 endpoints)

-   `GET /api/users` - List all users (protected)
-   `POST /api/users` - Create new user (protected)
-   `GET /api/users/{id}` - Get user details (protected)
-   `PUT /api/users/{id}` - Update user (protected)
-   `PATCH /api/users/{id}` - Partial update user (protected)
-   `DELETE /api/users/{id}` - Delete user (protected)
-   `POST /api/users/{id}/verify` - Verify user email (protected)
-   `POST /api/users/{id}/unverify` - Unverify user email (protected)

### Site Settings (13 endpoints)

-   `GET /api/site-settings/basic-info` - Get basic information
-   `GET /api/site-settings/contact-info` - Get contact information
-   `GET /api/site-settings/social-media` - Get social media links
-   `GET /api/site-settings/footer-info` - Get footer information
-   `GET /api/site-settings/seo-settings` - Get SEO settings
-   `GET /api/site-settings/homepage` - Get homepage settings
-   `GET /api/site-settings/hero-section` - Get hero section data
-   `GET /api/site-settings/about-section` - Get about section data
-   `GET /api/site-settings/achievements` - Get achievement statistics
-   `GET /api/site-settings/intro-video` - Get intro video information
-   `GET /api/site-settings/organizational-structure-page` - Get organizational structure page data
-   `GET /api/site-settings/about-page` - Get about page data
-   `GET /api/site-settings/all` - Get all settings

### Services (2 endpoints)

-   `GET /api/services` - List all services
-   `GET /api/services/{id}` - Get single service

### Testimonials (2 endpoints)

-   `GET /api/testimonials` - List all testimonials
-   `GET /api/testimonials/{id}` - Get single testimonial

### Partners (2 endpoints)

-   `GET /api/partners` - List all partners
-   `GET /api/partners/{id}` - Get single partner

### Leadership (2 endpoints)

-   `GET /api/leadership` - List all leadership members
-   `GET /api/leadership/{id}` - Get single leadership member

### School Achievements (2 endpoints)

-   `GET /api/school-achievements` - List all school achievements
-   `GET /api/school-achievements/{id}` - Get single school achievement

### Programme Images (3 endpoints)

-   `GET /api/programme-images` - List all programme images
-   `GET /api/programme-images/programme/{programmeName}` - Get programme images by name
-   `GET /api/programme-images/{id}` - Get single programme image

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

**Total: 60 API endpoints**

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
