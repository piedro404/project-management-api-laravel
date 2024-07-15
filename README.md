# 📋 Project Management API - Laravel

This is a Project Management API built with Laravel, providing endpoints for managing projects, tasks, and user authentication.

## 📚 Table of Contents
- [📖 Overview](#-overview)
- [🔗 Resources](#-resources)
- [🛠 Technologies](#-technologies)
- [⚙️ Setup](#%EF%B8%8F-setup)
  - [📋 Prerequisites](#-prerequisites)
  - [⬇️ Installation](#%EF%B8%8F-installation)
  - [🚀 Running Locally](#-running-locally)
- [📑 API Documentation](#-api-documentation)
- [📒 Abount](#-about)
  
## 📖 Overview 

The Project Management API allows users to register, log in, manage their profile, and perform CRUD operations on projects and tasks. Authentication is managed using JWT tokens.

## 🔗 Resources

### 🔐 Auth
- **Register**: `/register`
- **Login**: `/login`
- **Get Current User**: `/me`
- **Logout**: `/logout`
- **Refresh Token**: `/refresh`
- **Edit Profile**: `/profile/edit`
- **Reset Password**: `/password/reset`

### 📁 Projects
- **Get All Projects**: `/projects`
- **Create Project**: `/projects`
- **Get Project by ID**: `/projects/{id}`
- **Update Project by ID**: `/projects/{id}`
- **Delete Project by ID**: `/projects/{id}`
- **Get Project Report by ID**: `/projects/{id}/report`

### ✅ Tasks
- **Get All Tasks for a Project**: `/projects/{project_id}/tasks`
- **Create Task for a Project**: `/projects/{project_id}/tasks`
- **Get Task by ID for a Project**: `/projects/{project_id}/tasks/{id}`
- **Update Task by ID for a Project**: `/projects/{project_id}/tasks/{id}`
- **Delete Task by ID for a Project**: `/projects/{project_id}/tasks/{id}`
- **Get Full Tasks for Current User**: `/tasks`

## 🛠 Technologies

- **Laravel**: PHP web framework used for building the API
- **JWT**: JSON Web Tokens for authentication
- **MySQL**: Database for storing data

## ⚙️ Setup

### 📋 Prerequisites

- PHP 8.3.3 or higher
- Composer
- MySQL
- Docker (optional, for running with Docker Compose)

### ⬇️ Installation

1. **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/project-management-api.git
    cd project-management-api
    ```

2. **Install dependencies:**
    ```bash
    composer install
    ```

3. **Copy the `.env.example` file to `.env` and configure the environment variables:**
    ```bash
    cp .env.example .env
    ```

4. **Generate the application key:**
    ```bash
    php artisan key:generate
    ```

5. **Run the migrations to create the database tables:**
    ```bash
    php artisan migrate
    ```

6. **Seed the database (optional):**
    ```bash
    php artisan db:seed
    ```

### 🚀 Running Locally

#### 🐳 Using Docker Compose

1. **Start the Docker containers:**
    ```bash
    docker-compose up -d
    ```

2. **Access the API at `http://localhost:8000/api`.**

#### 🖥 Without Docker

1. **Start the Laravel development server:**
    ```bash
    php artisan serve
    ```

2. **Access the API at `http://127.0.0.1:8000/api`.**

## 📑 API Documentation

The API documentation is defined using OpenAPI 3.0.0. You can view and interact with the API using tools like Swagger UI or Postman.

To view the API documentation:

1. **Run the project locally as described above.**
2. **Open your preferred OpenAPI/Swagger UI tool and import the `openapi.yaml` file located in the `docs` folder. Or open link "/" for acess localhost documentation Swagger in project**

---

Feel free to update any placeholders like the repository URL and additional instructions specific to your project environment.

# 📒 About
Thank you all, I wish you great studies, if you want, get in touch at pedro.henrique.martins404@gmail.com;
