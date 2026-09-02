# Level 3 — Component (Web Application container)

The internal building blocks inside the "Web Application" container from the
[Container diagram](02-container.md).

```mermaid
C4Component
    title Component diagram for Sparteoli's Web Application

    Person(operator, "Rescue Operator")
    Person(admin, "Administrator")

    Container_Boundary(webapp, "Web Application") {
        Component(auth, "Authentication", "Controllers + Middleware", "LoginController, RegisterController, Authenticate/RedirectIfAuthenticated middleware — session login, registration, logout")
        Component(authz, "Authorization", "Laravel Gate", "Gate::define('admin', ...) in AppServiceProvider; enforced via the 'can:admin' middleware group on routes/web.php")
        Component(occurrence, "Occurrence Management", "Controllers + Helpers", "OccurrenceController, VictimController, ResourceController, VictimCreator/VictimDestroyer — the core incident-recording workflow")
        Component(catalog, "Reference Data Management", "Controllers", "NatureController, TypeController, FireprotectionController, RescuerController, ProblemController, PlaceuseController, PlacefreatureController, MeanusedController — CRUD for lookup/catalog entities")
        Component(useradmin, "User Administration", "Controllers", "UserController, HomeController — profile, password change, user listing/removal")
        Component(models, "Domain Models", "Eloquent ORM", "App\\Models\\* — Occurrence, Victim, Resource, Rescuer, User and the catalog entities, with their relationships")
        Component(views, "View Layer", "Blade + AdminLTE 3", "Server-rendered HTML forms/listings, and the occurrence.pdf template used for PDF export")
    }

    ContainerDb(mysql, "Database", "MySQL 8")

    Rel(operator, auth, "Logs in / out", "HTTPS")
    Rel(operator, occurrence, "Creates/edits occurrences, victims, resources", "HTTPS")
    Rel(admin, catalog, "Creates/edits/deletes reference data", "HTTPS")
    Rel(admin, useradmin, "Manages users", "HTTPS")

    Rel(occurrence, authz, "Destructive/admin-only actions gated by", "in-process")
    Rel(catalog, authz, "All writes gated by", "in-process")

    Rel(occurrence, models, "Reads/writes via", "Eloquent")
    Rel(catalog, models, "Reads/writes via", "Eloquent")
    Rel(useradmin, models, "Reads/writes via", "Eloquent")
    Rel(auth, models, "Reads User via", "Eloquent")

    Rel(occurrence, views, "Renders", "Blade")
    Rel(catalog, views, "Renders", "Blade")
    Rel(useradmin, views, "Renders", "Blade")

    Rel(models, mysql, "SQL", "TCP 3306")
```

## Component responsibilities

- **Authentication** — `App\Http\Controllers\Auth\LoginController` /
  `RegisterController`, using the stock Laravel `AuthenticatesUsers` /
  `RegistersUsers`-style concerns. Notably, login is by `register` (badge/registration
  number), not email — `LoginController::username()` returns `'register'`.
- **Authorization** — a single Gate, `admin`, checked with the `can:admin` middleware
  around an entire route group in `routes/web.php`. There is no per-resource policy
  class; authorization is coarse-grained (you're either an admin who can create/edit/
  delete everything, or an operator who can only read catalog data and create
  occurrences/victims/resources).
- **Occurrence Management** — the reason the system exists. `OccurrenceController`
  handles the occurrence lifecycle (including `toPdf()` for report export);
  `VictimController` and `ResourceController` manage the children of an occurrence
  (routes are nested under `/occurrence/{occurrence_id}/...`); `VictimCreator` and
  `VictimDestroyer` in `App\Helpers` encapsulate the extra step of attaching/detaching
  the victim's `problems` (a many-to-many) around the create/delete.
- **Reference Data Management** — eight near-identical CRUD controllers for the
  lookup tables operators pick from when filling an occurrence (nature, type, fire
  protection, place use, place feature, means used, problem, rescuer). These are
  admin-only to write, but readable by any authenticated user (index/show routes sit
  outside the `can:admin` group).
- **User Administration** — profile viewing/editing, password changes, and (admin-only)
  user listing/removal. `HomeController` just renders the post-login landing page.
- **Domain Models** — plain Eloquent models under `App\Models`; business rules are
  limited to attribute mutators (e.g. name/address normalization via
  `set*Attribute()`) — there is no separate service/repository layer.
- **View Layer** — Blade templates styled with the `jeroennoten/laravel-adminlte`
  package; one `occurrence.pdf` view doubles as the HTML source rendered to disk and
  streamed back for the "download PDF" feature (see
  [Container notes](02-container.md) on why that's not a real PDF renderer, just an
  HTML file served with a `.html` extension).
