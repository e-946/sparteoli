# Level 1 — System Context

Who uses Sparteoli, and what does it talk to outside its own boundary.

```mermaid
C4Context
    title System Context diagram for Sparteoli

    Person(operator, "Rescue Operator", "Fire/rescue department staff who log occurrences, victims and resources used")
    Person(admin, "Administrator", "Staff member with the 'admin' privilege who manages reference data and user accounts")

    System(sparteoli, "Sparteoli", "Records fire/rescue occurrences and produces occurrence reports")

    System_Ext(mail, "SMTP Mail Server", "Delivers transactional email, e.g. account email verification")

    Rel(operator, sparteoli, "Logs in, registers occurrences, victims and resources, views occurrence history/PDF", "HTTPS")
    Rel(admin, sparteoli, "Manages reference data (nature, type, fire protection, place use/feature, means used, problems), rescuers and users", "HTTPS")
    Rel(sparteoli, mail, "Sends email verification notifications", "SMTP")
```

## Notes

- There is a single first-party user population — internal department staff — split
  into two authorization tiers by the `admin` boolean flag on `users` (see
  `App\Providers\AppServiceProvider`'s `Gate::define('admin', ...)`), not two separate
  systems. Both are modeled as `Person` actors here because they interact with the
  system directly through a browser.
- There is no public/anonymous-facing part of the system; every route except `/login`
  sits behind the `auth` middleware.
- The only outbound integration is transactional email (Laravel's built-in email
  verification listener). In local development this is caught by Mailpit; in
  production it goes through a real SMTP relay (`MAIL_MAILER=smtp`).
- The application does not call out to any third-party APIs (payment, SMS, maps, etc.).
