# LaraDB

This is an implementation of a JSON file databse in Laravel Framework

### Requirements

- PHP >= 8.1
- [Composer](https://getcomposer.org/) Installed

### Structure
Our json files store inside `storage/app/tables/*.json`
Every file contains two parts, the coulmns (structure) and the data itself.
```json
{
  "structure": [
    "id",
    "username",
    "first_name",
    "last_name"
  ],
  "data": [
    {
      "id": 1,
      "username": "raf88",
      "first_name": "Rafael",
      "last_name": "Mor"
    },
    {
      "id": 2,
      "username": "dikla96",
      "first_name": "Dikla",
      "last_name": "Cohen"
    }
  ]
}
```

### Installation
You need to clone the git to your local machine and run these commands:
```sh
cd LaraDB-laravel-database
composer install
php artisan key:generate
```

### Testing
You can access the root route `localhost:8000` in order to see the output data, the functionallity is inside the `HandleController`
