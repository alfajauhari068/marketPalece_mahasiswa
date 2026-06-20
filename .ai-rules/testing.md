# testing.md

Purpose
-------
Menetapkan strategi testing untuk menjaga kualitas kode: unit, feature, integration, dan acceptance.

Strategy
--------
- Unit tests for domain logic; Feature tests for endpoints; Integration tests for DB workflows.
- Use factories and seeders for deterministic fixtures.
- Aim for meaningful coverage on critical flows: authentication, ordering, payments, reviews.
- Run tests in CI on PRs; fail build on broken tests.
