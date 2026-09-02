# Level 2 — Container

The deployable/runtime pieces that make up Sparteoli, and how they talk to each other.

```mermaid
C4Container
    title Container diagram for Sparteoli

    Person(operator, "Rescue Operator")
    Person(admin, "Administrator")

    System_Boundary(sparteoli, "Sparteoli") {
        Container(webapp, "Web Application", "PHP 8.3, Laravel 13, Blade + AdminLTE 3", "Server-rendered monolith: routing, controllers, authorization, views, PDF export")
        ContainerDb(mysql, "Database", "MySQL 8", "Stores occurrences, victims, resources, reference/catalog data and user accounts")
        ContainerDb(redis, "Cache / Session / Queue store", "Redis", "Provisioned by the local dev stack (Sail); not enabled by default app config")
        Container(storage, "File Storage", "Local disk", "Holds the HTML render used to produce the occurrence PDF export")
    }

    System_Ext(mail, "Mail Server", "Mailpit (dev) / SMTP relay (prod)")

    Rel(operator, webapp, "Uses", "HTTPS")
    Rel(admin, webapp, "Uses", "HTTPS")
    Rel(webapp, mysql, "Reads/writes via Eloquent ORM", "TCP 3306")
    Rel(webapp, redis, "Optional cache/session/queue backend", "TCP 6379")
    Rel(webapp, storage, "Writes rendered occurrence.html, streams it back, then deletes it", "Filesystem")
    Rel(webapp, mail, "Sends verification email", "SMTP")
```

## Notes

- **Single application container.** There is no separate API/backend split — the same
  Laravel app serves HTML pages, handles form submissions, and enforces authorization.
  `routes/api.php` exists (Sanctum is installed) but is unused by the product today.
- **MySQL is the only container the app actually depends on for correctness.** It holds
  every domain table: `occurrences`, `victims`, `resources`, `rescuers`, `users`, and
  the reference/catalog tables (`natures`, `types`, `fireprotections`, `placeuses`,
  `place_features`, `means_used`, `problems`) plus the `occurrence-fireprotection` and
  `victims-problems` pivot tables.
- **Redis is provisioned but not wired in by default.** `docker-compose.yml` (Laravel
  Sail) starts a Redis container, but `.env.example` ships with
  `SESSION_DRIVER=file`, `CACHE_DRIVER=file`, and `QUEUE_CONNECTION=sync`. Treat Redis
  as available infrastructure, not a load-bearing dependency, unless those env vars are
  changed.
- **File storage is transient, not a data store.** `OccurrenceController::toPdf()`
  renders the `occurrence.pdf` Blade view to `storage/app/occurrence.html`, streams it
  back as the response, then deletes it (`deleteFileAfterSend()`). Nothing durable lives
  on disk between requests.
- **Local dev vs. production topology differs.** Locally the stack runs via Laravel
  Sail (`docker-compose.yml`: `laravel.test`, `mysql`, `redis`, `mailpit`). The
  `Procfile` (`web: vendor/bin/heroku-php-apache2 public/`) indicates production target
  is Heroku, where MySQL/Redis/mail would be managed add-ons rather than the containers
  shown above.
