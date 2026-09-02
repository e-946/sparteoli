# Architecture Documentation

This folder documents Sparteoli's architecture using the [C4 model](https://c4model.com)
(Context, Container, Component, Code). Each level zooms in further, starting from
"who uses the system" down to "how the core domain classes relate to each other".

Diagrams are written as [Mermaid](https://mermaid.js.org/syntax/c4.html) C4 diagrams so
they render directly on GitHub/GitLab and in any Mermaid-aware Markdown viewer, and stay
versioned with the code instead of drifting in an external tool.

## What is Sparteoli

Sparteoli is a server-rendered Laravel application used by fire/rescue department staff
to record **occurrences** (incidents attended in the field) together with the **victims**
assisted, the **resources** (equipment/vehicles) used, and the **rescuers** involved. It
also maintains the reference/catalog data used to classify occurrences (nature, type,
fire protection, place use/feature, means used) and manages user accounts.

## Levels

| Level | Diagram | Shows |
|---|---|---|
| 1 | [System Context](c4/01-system-context.md) | Sparteoli in relation to its users and the external mail system |
| 2 | [Container](c4/02-container.md) | The deployable/runtime pieces: web app, database, cache, file storage, mail |
| 3 | [Component](c4/03-component-web-application.md) | The internal building blocks of the web application container |
| 4 | [Code](c4/04-code-occurrence-domain.md) | The Occurrence aggregate's domain model classes and relationships |

## How to keep this up to date

- Update the relevant level when you add/remove a controller group, an external
  integration, or a container (e.g. enabling Redis for cache/queue in production).
- Prefer editing the narrative text next to each diagram, not just the diagram — the
  text explains *why*, which the diagram alone can't.
