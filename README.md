# Advanced Task Manager

## Interviewee: Connaire Garretty

- [GitHub](https://github.com/ConGarretty)
- [LinkedIn](https://www.linkedin.com/in/connaire-garretty-07332a21a/)

Thank you for reviewing my submission.

## Overview

A Symfony 6.4 application demonstrating CRUD operations, AJAX interactions, and modern frontend design using Tailwind CSS.

### Features
- Task management with pagination
- AJAX-based task status updates
- Soft delete functionality
- Clean architecture with Service/Process layers
- Docker containerization
- Database seeding

## Technical Stack
- PHP 8.1
- Symfony 6.4
- MySQL 8.0
- Tailwind CSS
- Docker
- jQuery for AJAX

## Requirements
- Docker and Docker Compose
- Git

## Installation

1. Clone the repository:
```bash
git clone git@github.com:ConGarretty/advanced-task-manager
```

2. Build and start containers:
```bash
docker-compose up --build -d
```

The application will be available at `http://localhost:8000`

## Architecture

### Layer Structure
- **Controllers**: Handle HTTP requests and responses
- **Services**: Business logic orchestration
- **Process**: Task operation coordination
- **Repository**: Database interactions
- **Entity**: Data models

### Key Components
- `TaskController`: Routes and request handling
- `TaskManagerService`: Business logic
- `TaskManagerProcess`: Operation coordination
- `TaskRepository`: Database queries
- `Task`: Entity model
- `TaskForm`: Form & validation

## Database Schema

### Task Entity
```sql
CREATE TABLE task (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    is_done BOOLEAN DEFAULT FALSE,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    deleted_at DATETIME DEFAULT NULL
);
```

## Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/tasks` | List tasks with pagination |
| POST | `/tasks` | Create new task |
| POST | `/tasks/{id}/toggle` | Toggle task status |
| POST | `/tasks/{id}/delete` | Soft delete task |

## Testing

Run the following command from within the docker container to execute the test suite:
```bash
composer test
```

The application includes examples of:
- Separation of concerns
- SOLID principles
- Clean code practices
- Docker containerization
- AJAX interactions

### Design Decisions
- Layered architecture for maintainability
- Docker for consistent environments
- Seeding command for demo data
