

# Laravel 12 Multi-Tenant Support Ticket System

[![laravel](https://img.shields.io/badge/Github_repository-000?style=for-the-badge&logoColor=white)](https://github.com/Zach262626/broadcast-project)






## Packages

 - [Docker Desktop](https://www.docker.com/products/docker-desktop/)
 - [Laravel Sail](https://laravel.com/docs/12.x/sail)
 - [Laravel Telescope](https://laravel.com/docs/12.x/telescope)
 - [Laravel Horizon](https://laravel.com/docs/12.x/horizon)
 - [Laravel Broadcasting](https://laravel.com/docs/12.x/broadcasting)
 - [Laravel Reverb](https://laravel.com/docs/12.x/reverb)
 - [Stancl/Tenancy](https://tenancyforlaravel.com/)


## Installation

-   Clone this Repository
    

        git clone https://github.com/Zach262626/ticket-system.git
-   Create .env file from .env.example and fill in all field required
-   Install Dependencies
        
        npm install
        composer install
-   Build frontend

        npm run dev
-   install docker desktop
-   create tenant

        <?php

        namespace App\Models;

        use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
        use Stancl\Tenancy\Contracts\TenantWithDatabase;
        use Stancl\Tenancy\Database\Concerns\HasDatabase;
        use Stancl\Tenancy\Database\Concerns\HasDomains;

        class Tenant extends BaseTenant implements            TenantWithDatabase
        {
            use HasDatabase, HasDomains;
        }
-   All your route file should be inside this function located in routes/web:


        foreach (config('tenancy.central_domains') as $domain) {
            Route::domain($domain)->group(function () {
                // your actual routes
            });
        }
-   if on window, install wsl. inside docker resources in option enable wsl. Make sure your project runs directly inside wsl

-   alias sail for easier workflow, create an alias:

        alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
-   start environment:
        
        sail up -d
-   migrate

        sail artisan migrate
        sail artisan storage:link

-   If reverb doesn't work

        sail php artisan reverb:restart

-   bootstrap/app.php

        change middleware domain and port
