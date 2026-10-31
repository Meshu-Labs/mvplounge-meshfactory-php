# BV Behavior Overview

This folder contains behavior-domain guidance for decision process, quality assessment, and clarification outputs.

## Behavior Documents

- Implementation backlog (Given-When-Then stories for every known gap): `BV-element-factory-implementation-backlog.md`
- Rendered output catalog (what the sandbox suite exercises and what elements render): `BV-element-factory-rendered-output-catalog.md`
- Quality assurance framework: `BV-quality-assurance-framework.md`
- Form and table use cases: `BV-meshfactory-form-table-use-cases.md`
- Clarification report examples:
  - `BV-20261011-initial-meshfactory-distribution.md`
  - `BV-20261012-library-finalization-and-domain-consolidation.md` (historical: its `Element/Html/*` paths were later flattened to `Element/{Domain}`)

## Policy

- Keep process behavior and quality gates in BV documents.
- Keep architecture contracts in AX documents.
- Keep task execution procedures in TK documents.
- Track every new gap as a backlog story with evidence, a stable `EF-` ID, and Given-When-Then acceptance.