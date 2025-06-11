# PUP PUK in

## Design

### Primary Colors
| Role               | Hex       | Preview                          | Usage                     |
|--------------------|-----------|----------------------------------|---------------------------|
| Primary Green      | `#4ade80` | <div style="background:#4ade80; width:100%; height:24px; border:1px solid #ddd;"></div> | Main CTAs, positive actions |
| Green-Dark         | `#166534` | <div style="background:#166534; width:100%; height:24px; border:1px solid #ddd;"></div> | Headings, important text |
| Green-Light        | `#dcfce7` | <div style="background:#dcfce7; width:100%; height:24px; border:1px solid #ddd;"></div> | Success backgrounds |

### Semantic Colors
| Role               | Hex       | Preview                          | Usage                     |
|--------------------|-----------|----------------------------------|---------------------------|
| Error/Red          | `#ef4444` | <div style="background:#ef4444; width:100%; height:24px; border:1px solid #ddd;"></div> | Delete buttons, errors |
| Warning/Amber      | `#f59e0b` | <div style="background:#f59e0b; width:100%; height:24px; border:1px solid #ddd;"></div> | Warnings, pending states |
| Info/Blue          | `#3b82f6` | <div style="background:#3b82f6; width:100%; height:24px; border:1px solid #ddd;"></div> | Notifications, links |
| Success/Green      | `#10b981` | <div style="background:#10b981; width:100%; height:24px; border:1px solid #ddd;"></div> | Confirmation messages |

### Neutral Scale
| Role               | Hex       | Preview                          | Usage                     |
|--------------------|-----------|----------------------------------|---------------------------|
| Gray-50            | `#f9fafb` | <div style="background:#f9fafb; width:100%; height:24px; border:1px solid #ddd;"></div> | App background |
| Gray-200           | `#e5e7eb` | <div style="background:#e5e7eb; width:100%; height:24px; border:1px solid #ddd;"></div> | Borders, dividers |
| Gray-500           | `#6b7280` | <div style="background:#6b7280; width:100%; height:24px; border:1px solid #ddd;"></div> | Secondary text |
| Gray-900           | `#111827` | <div style="background:#111827; width:100%; height:24px; border:1px solid #ddd;"></div> | Primary text |

### Characteristic
- Clean, Modern Interface with ample white space
- Card-based Layout 
- Subtle Shadows for depth
- Smooth Hover Effects 
- Clear Visual Hierarchy with typography and color

---



## Directory Structure
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
    │   └── welcome.blade.php
```