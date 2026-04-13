# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Symfony bundle (`setono/tag-bag-bundle`) that integrates the [setono/tag-bag](https://github.com/Setono/tag-bag) library into Symfony. It enables injecting dynamic HTML/JS tags (e.g., tracking scripts) into pages via a session-backed tag bag. Tags added during a request cycle are persisted to the session and restored on subsequent page loads.

## Tools

Use `jq` (not `python3`) for JSON parsing in shell commands.

## Commands

```bash
composer phpunit          # Run all tests
composer analyse          # Static analysis (PHPStan, level max)
composer check-style      # Check coding standards (ECS with Sylius coding standard)
composer fix-style        # Auto-fix coding standards
composer rector           # Run Rector (PHP 8.2 level)

# Run a single test file
vendor/bin/phpunit tests/EventListener/RestoreTagBagSubscriberTest.php

# Run a single test method
vendor/bin/phpunit --filter testMethodName
```

## Architecture

### Request Lifecycle (the core mechanism)

1. **Restore** (`RestoreTagBagSubscriber`, priority 7 on `kernel.request`) — restores tags from session on each main request. Priority is below Symfony's `FirewallListener` (8) but above 0.
2. **Use** — application code adds tags to the `TagBagInterface` service during the request.
3. **Render** — Twig functions (`setono_tag_bag_render_head()`, `_body_begin()`, `_body_end()`, `_section()`, `_all()`) output tags in templates.
4. **Store** (`StoreTagBagSubscriber`, priority -900 on `kernel.response`) — persists unrendered tags to session. Priority is above Symfony's `SessionListener` (-1000) but below 0.

### Key Components

- **`SessionStorage`** — implements `StorageInterface` from tag-bag lib; stores/restores serialized tag data via Symfony sessions.
- **`TwigRenderer`** — renders `TemplateTag` instances with `templateType === 'twig'` using the Twig environment.
- **`RegisterRenderersPass`** — compiler pass that collects all services tagged `setono_tag_bag.renderer` into the composite renderer. Custom renderers are auto-tagged via `RendererInterface` autoconfiguration.
- **`Configuration`** — single config option: `setono_tag_bag.renderer.twig` (bool, defaults to true if TwigBundle is available).

### Service Definitions

XML-based service definitions in `src/Resources/config/`. The main `services.xml` imports from `services/` subdirectory (tag_bag, storage, renderer, event_listener, twig, generator). The Twig renderer integration is conditionally loaded.

## CI Matrix

Tests run against PHP 8.2–8.4, Symfony 6.4 and 7.4, with both lowest and highest dependency versions. CI also runs composer-dependency-analyser, PHPStan, ECS, and Rector checks.
