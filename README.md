
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


## Setup

Follow these steps to run the project locally using Docker and Laravel Sail.

1. **Clone the repository**

   ```bash
   git clone https://github.com/Zach262626/ticket-system.git
   cd ticket-system
   ```

2. **Create a `.env` file** from `.env.example` and fill in the required fields.

3. **Install dependencies**

   ```bash
   composer install
   npm install
   ```

4. **Build the frontend assets**

   ```bash
   npm run dev
   ```

5. **Ensure Docker Desktop is installed** (enable WSL on Windows) and create an alias for Sail for easier commands:

   ```bash
   alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
   ```

6. **Start the application containers**

   ```bash
   sail up -d
   ```

7. **Run migrations and create the storage link**

   ```bash
   sail artisan migrate
   sail artisan storage:link
   ```

8. **Create the tenant model** (if not already present)

   ```php
   <?php
   namespace App\Models;

   use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
   use Stancl\Tenancy\Contracts\TenantWithDatabase;
   use Stancl\Tenancy\Database\Concerns\HasDatabase;
   use Stancl\Tenancy\Database\Concerns\HasDomains;

   class Tenant extends BaseTenant implements TenantWithDatabase
   {
       use HasDatabase, HasDomains;
   }
   ```

9. **Place your routes** inside the following block in `routes/web.php`:

   ```php
   foreach (config('tenancy.central_domains') as $domain) {
       Route::domain($domain)->group(function () {
           // your actual routes
       });
   }
   ```

10. **If Reverb does not work**, restart it:

    ```bash
    sail php artisan reverb:restart
    ```

11. **Testing**

    ```bash
    cp .env .env.testing
    sail artisan migrate:fresh --seed --env=testing
    sail php artisan test --env=testing
    ```
