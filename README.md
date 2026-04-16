## Developer

Wandumi Munandi

## About Laravel

Personalized Video Campaign Manager

A robust, API-driven campaign management system built with Laravel 12, MySQL, and Sanctum. This system allows clients to programmatically create campaigns and ingest high-volume user video data using asynchronous background processing.

Features

- Client Management: Group campaigns under specific client entities.
- Campaign Management: API endpoints to create and manage video campaigns.
- Asynchronous Data Ingestion: Handles large user data sets via Laravel Queues (Redis/Database).
- Graceful Duplicate Handling: Automatically detects existing user_id entries, merges/updates data, and - logs the event for visibility.
- Flexible Data Schema: Stores custom user metadata using JSON columns.
- Analytics CLI: A custom Artisan command to generate detailed campaign performance reports.

## Installation & Setup

This project uses Laravel Sail (Docker) for a consistent development environment.

Clone the repository:

`git clone <your-repo-url>`
`cd folderName`

## Install dependencies:

`composer install`

## Environment Setup:

`cp .env.example .env`
`./vendor/bin/sail up -d`

## Initialize Database:

`./vendor/bin/sail artisan migrate --seed

The seeder creates a test user: admin@example.com / password.

## API Documentation

1. Authentication
   All endpoints (except login/register) require a Bearer Token.
   `POST /api/login (Returns access_token)`

2. Create Campaign
   **Endpoint:**` POST /api/campaigns`
   **Payload:**

```json
{
    "client_id": 1,
    "name": "Summer Launch 2024",
    "start_date": "2024-06-01",
    "end_date": "2024-08-31"
}
```

3. Add Campaign Data (Asynchronous)
   **Endpoint:** `POST /api/campaigns/{id}/data`

**Payload:**`

```json
{
    "data": [
        {
            "user_id": "ext_user_99",
            "video_url": "https://cdn.com",
            "custom_fields": {
                "tier": "gold",
                "pref": "dark-mode"
            }
        }
    ]
}
```

Response: 202 Accepted

Processing: Data is handled by the ProcessCampaignData background job. To process locally, run:

`./vendor/bin/sail artisan queue:work --once`

# Analytics Report

To view campaign summaries, run the following commands:

`./vendor/bin/sail artisan analytics:generate`

Or you can specify by providing an ID, for example:

`./vendor/bin/sail artisan ./vendor/bin/sail artisan analytics:generate 1`

# Testing

The project uses Pest PHP for TDD. To run the test suite:
`./vendor/bin/sail artisan test`

## Docker Configuration

- The environment is defined in compose.yml.
- Custom runtimes and the application Dockerfile are located in the /docker directory (published via Sail).
- The worker service in Docker handles the background job processing automatically.
