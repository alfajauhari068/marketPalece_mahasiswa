# git-workflow.md

Purpose
-------
Menetapkan alur kerja Git, konvensi commit, dan aturan PR untuk kolaborasi tim.

Rules
-----
- Branch strategy: `main` (production), `develop` (integration), feature branches `feature/<name>`.
- Commit messages: use Conventional Commits (`feat:`, `fix:`, `chore:`).
- PRs must include description, linked issue, and at least one reviewer.
- Protect `main` branch; require CI green and review approvals before merge.
