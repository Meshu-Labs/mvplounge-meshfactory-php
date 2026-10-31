# System Overview

## Purpose

MeshFactory builds HTML elements through PHP factories.
The platform is designed for predictable structure with dynamic attribute handling.

## Architectural Layers

- Enum layer defines supported elements and attributes.
- Abstract layer provides shared behavior and conventions.
- Concrete element layer renders element-specific output.

## Core Direction

- FactoryAbstract handles shared DOM attribute data.
- FactoryElementAbstract handles element-level behavior.
- Enum-backed elements map to DOM elements and TypeScript counterparts.
- Attribute handling is the intentionally dynamic layer.

## Platform Integration Targets

- APP-MESH-UI (see [TypeScript alignment](AX-element-factory-typescript-alignment.md))
- TypeScript component construction
- APP-EELC through its `lab_center` UI facades (see [ElementFactory pattern](AX-element-factory-pattern.md))
- Templating use in ExpressionEngine, WordPress, osTicket, and Drupal

## Stability Model

- Dynamic: attribute management and attribute gating.
- Stable: class shape, inheritance contracts, and namespace organization.
