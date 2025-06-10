# PUP PUK in

```
├── app
    ├── Http
    │   ├── Controllers
    │   │   ├── AdminController.php
    │   │   ├── AuthController.php
    │   │   ├── Controller.php
    │   │   ├── CustomerController.php
    │   │   └── OwnerController.php
    │   └── Middleware
    │   │   ├── AdminMiddleware.php
    │   │   ├── CustomerMiddleware.php
    │   │   └── OwnerMiddleware.php
    ├── Models
    │   ├── Customer.php
    │   ├── Fertilizer.php
    │   ├── Owner.php
    │   ├── Quota.php
    │   ├── Stock.php
    │   ├── StockRequest.php
    │   ├── Transaction.php
    │   └── User.php
    └── Providers
        └── AppServiceProvider.php

├── database
    ├── .gitignore
    ├── factories
    │   └── UserFactory.php
    ├── migrations
    │   ├── 0001_01_01_000000_create_users_table.php
    │   ├── 0001_01_01_000001_create_cache_table.php
    │   ├── 0001_01_01_000002_create_jobs_table.php
    │   ├── 2025_06_10_204048_create_owners_table.php
    │   ├── 2025_06_10_204351_create_customers_table.php
    │   ├── 2025_06_10_204448_create_fertilizers_table.php
    │   ├── 2025_06_10_204647_create_stocks_table.php
    │   ├── 2025_06_10_204805_create_requests_table.php
    │   ├── 2025_06_10_204922_create_quotas_table.php
    │   └── 2025_06_10_210031_create_transactions_table.php
    └── seeders
        └── DatabaseSeeder.php
        
├── resources
    ├── css
    │   └── app.css
    ├── js
    │   ├── app.js
    │   └── bootstrap.js
    └── views
    │   ├── admin
    │       ├── accounts
    │       │   ├── index.blade.php
    │       │   └── show.blade.php
    │       ├── dashboard.blade.php
    │       ├── stocks
    │       │   ├── inventory.blade.php
    │       │   └── requests.blade.php
    │       └── transactions
    │       │   └── index.blade.php
    │   ├── auth
    │       ├── login.blade.php
    │       ├── register-customer.blade.php
    │       └── register-owner.blade.php
    │   ├── customer
    │       ├── dashboard.blade.php
    │       ├── orders
    │       │   ├── create.blade.php
    │       │   ├── index.blade.php
    │       │   └── show.blade.php
    │       ├── profile
    │       │   ├── edit.blade.php
    │       │   └── show.blade.php
    │       ├── quota
    │       │   └── show.blade.php
    │       └── shops
    │       │   └── index.blade.php
    │   ├── owner
    │       ├── dashboard.blade.php
    │       ├── profile
    │       │   ├── edit.blade.php
    │       │   └── show.blade.php
    │       ├── stocks
    │       │   ├── inventory.blade.php
    │       │   └── requests
    │       │   │   ├── create.blade.php
    │       │   │   └── index.blade.php
    │       └── transactions
    │       │   ├── index.blade.php
    │       │   └── show.blade.php
    │   ├── shared
    │       └── layouts
    │       │   └── app.blade.php
        └── welcome.blade.php
```