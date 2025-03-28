# Task Management System

## Overview
This is a Task Management System built using Laravel. It allows users to create, update, delete, and filter tasks based on various parameters like status, priority, and title. The system follows the Repository Pattern for better maintainability and scalability.

## Features
- User authentication (Login & Logout)
- Task creation, update, and deletion
- Task filtering based on status, priority, and title
- RESTful API endpoints for task management
- Repository Pattern implementation

## Admin Credentials
To log in as an admin, use the following credentials:

- **Email:** admin@example.com  
- **Password:** password123

## Installation

### Prerequisites
Make sure you have the following installed:
- PHP (>=8.0)
- Composer
- MySQL / PostgreSQL
- Laravel
- Git

### Setup Instructions
1. Clone the repository:
   ```sh
   git clone <repository-url>
   cd task-management
   ```
2. Install dependencies:
   ```sh
   composer install
   ```
3. Create a `.env` file:
   ```sh
   cp .env.example .env
   ```
4. Generate the application key:
   ```sh
   php artisan key:generate
   ```
5. Configure the database in the `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=task_management
   DB_USERNAME=root
   DB_PASSWORD=
   ```
6. Run database migrations:
   ```sh
   php artisan migrate --seed
   ```
7. Start the development server:
   ```sh
   php artisan serve
   ```

## API Endpoints

### Authentication
- `POST /login` - Login a user
- `POST /logout` - Logout a user

### Tasks
- `GET /tasks` - Get all tasks with filters
- `POST /tasks` - Create a new task
- `GET /tasks/{id}` - Get task details
- `PUT /tasks/{id}` - Update a task
- `DELETE /tasks/{id}` - Delete a task

## Repository Pattern
The Task Management system follows the Repository Pattern to separate business logic from the database layer.

Repositories:
- `TaskRepository` - Handles task-related database operations
- `TaskRepositoryInterface` - Defines the contract for the repository

## Contributing
Feel free to fork this repository and submit a pull request with improvements.

## License
This project is licensed under the MIT License.

---
Developed with ❤️ using Laravel.

