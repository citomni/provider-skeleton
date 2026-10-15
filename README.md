# CitOmni Provider Skeleton

Neutral provider skeleton for CitOmni.

`citomni/provider-skeleton` is the mode-neutral starting point for reusable CitOmni provider packages. It provides the package container, Composer metadata, PSR-4 autoloading, the provider `Boot\Registry`, neutral source-layer folders, and repository metadata.

It does **not** assume that the provider is an HTTP provider, a CLI provider, or both. HTTP and CLI dependencies are added explicitly only when the concrete provider actually depends on those runtimes.

A finished provider is a Composer dependency installed into a host application. The provider contributes reusable behavior; the host application owns deployment, environment configuration, runtime state, and the final Composer installation.

Lean, deterministic, and pleasantly boring where boring is a feature.

---

## Highlights

- **Mode-neutral provider container** for reusable CitOmni packages.
- **Minimal boot contract** through `src/Boot/Registry.php`.
- **No HTTP assumption** by default.
- **No CLI assumption** by default.
- **No database assumption** by default.
- **No demo domain or placeholder business logic** to delete after creating a package.
- **Optional service, configuration, route, and command contributions** through the provider Registry.
- **Canonical source-layer folders** for commands, controllers, operations, repositories, services, utilities, and exceptions.
- **PSR-4 package autoloading** through Composer.
- **Deterministic line endings and package exports** through `.gitattributes`.

---

## What this package is

`citomni/provider-skeleton` is the neutral package root for CitOmni providers.

It exists so reusable packages can start from a clean structure and explicitly contribute only the behavior they actually own.

A provider may contribute:

- Shared services.
- HTTP-specific services.
- CLI-specific services.
- Shared configuration defaults.
- HTTP-specific configuration defaults.
- CLI-specific configuration defaults.
- HTTP routes.
- CLI commands.
- Reusable application, domain, or infrastructure behavior.

A provider may be:

- Mode-neutral.
- HTTP-specific.
- CLI-specific.
- Shared by both HTTP and CLI.
- Infrastructure-focused without exposing transport behavior at all.

The skeleton itself stays small. It provides the package shape and the provider Registry contract, not an imaginary implementation.

---

## What this package provides

`citomni/provider-skeleton` provides the provider-owned baseline structure.

That includes:

- Root Composer package metadata.
- PSR-4 source autoloading.
- PSR-4 test autoloading.
- `src/Boot/Registry.php`.
- Neutral source-layer directories.
- Optional transport adapter directories.
- An empty test directory.
- `.gitattributes` for deterministic line endings and package export rules.
- `.gitignore` for local development artifacts.
- MIT license, notice, and trademark files.

It gives the package a clean place to exist before any concrete services, configuration, persistence, routes, commands, or domain behavior are added.

---

## What this package does not provide

`citomni/provider-skeleton` deliberately does **not** provide:

- A host application.
- HTTP runtime behavior.
- CLI runtime behavior.
- HTTP routes.
- CLI commands.
- Registered services.
- Package configuration defaults.
- Database connections.
- SQL.
- Templates.
- Public assets.
- Runtime state directories.
- Deployment configuration.
- Environment-specific application configuration.
- Demo controllers.
- Demo commands.
- Demo services.
- Demo repositories.
- Demo business logic.

Those belong to the concrete provider, the relevant CitOmni runtime package, or the host application.

No ceremonial demo service. No fictional database table. No `HelloController` surviving three years because nobody wanted to be the person who deleted it.

---

## Requirements

- PHP **8.5+**
- Composer
- `citomni/kernel`

A concrete provider should require additional packages only when its own implementation depends on them.

Examples:

- Require `citomni/http` when the provider contains HTTP-specific code that depends on the HTTP package.
- Require `citomni/cli` when the provider contains CLI-specific code that depends on the CLI package.

Do not require a runtime package merely because a host application might happen to use that runtime.

---

## Installation

Create a new provider package from the skeleton:

```bash
composer create-project citomni/provider-skeleton my-provider
cd my-provider
```

At this point the package is intentionally neutral. It has no active service registrations, provider configuration, HTTP routes, or CLI commands.

The CitOmni DevKit may also create providers from this skeleton and fill in the concrete package identity automatically.

---

## Turn the skeleton into a provider

The first step is package identity, not placeholder implementation.

Update `composer.json` for the concrete package:

- Package name.
- Description.
- Package type.
- PSR-4 namespace.
- Homepage and repository URLs.
- Package-specific keywords where useful.
- Required CitOmni packages.
- Other package dependencies.

A finished reusable provider should normally use:

```json
{
	"type": "library"
}
```

Update the namespace in:

```text
src/Boot/Registry.php
```

For example:

```php
namespace Vendor\Package\Boot;
```

and update Composer autoloading accordingly:

```json
{
	"autoload": {
		"psr-4": {
			"Vendor\\Package\\": "src/"
		}
	}
}
```

If tests are used, update the test namespace too:

```json
{
	"autoload-dev": {
		"psr-4": {
			"Vendor\\Package\\Tests\\": "tests/"
		}
	}
}
```

After changing package identity or autoloading:

```bash
composer validate
composer dump-autoload
```

Then add only the implementation the provider actually needs.

---

## Add HTTP support

If the provider itself depends on CitOmni HTTP classes or contracts, add `citomni/http` to the provider package:

```bash
composer require citomni/http
```

HTTP-specific provider behavior may include:

```text
src/Controller/
Registry::MAP_HTTP
Registry::CFG_HTTP
Registry::ROUTES_HTTP
```

Only add those contributions when the package actually owns HTTP behavior.

A provider does not need to require `citomni/http` merely because it can also be installed into an HTTP host application.

The HTTP route contract belongs to `citomni/http`.

---

## Add CLI support

If the provider itself depends on CitOmni CLI classes or contracts, add `citomni/cli` to the provider package:

```bash
composer require citomni/cli
```

CLI-specific provider behavior may include:

```text
src/Command/
Registry::MAP_CLI
Registry::CFG_CLI
Registry::COMMANDS_CLI
```

Only add those contributions when the package actually owns CLI behavior.

A provider does not need to require `citomni/cli` merely because it can also be installed into a CLI host application.

The CLI command contract belongs to `citomni/cli`.

---

## Add both HTTP and CLI

A provider may support both runtime modes:

```bash
composer require citomni/http citomni/cli
```

Shared package behavior should remain mode-neutral where possible.

Typical shared layers include:

```text
src/Operation/
src/Repository/
src/Service/
src/Util/
src/Exception/
```

Mode-specific transport adapters stay separate:

```text
src/Controller/
src/Command/
```

Shared Registry contributions belong in:

```text
MAP_COMMON
CFG_COMMON
```

Mode-specific Registry contributions belong in:

```text
MAP_HTTP
CFG_HTTP
ROUTES_HTTP

MAP_CLI
CFG_CLI
COMMANDS_CLI
```

---

## Fresh package layout

A fresh `citomni/provider-skeleton` project contains only the neutral provider structure:

```text
/provider-root
	/src
		/Boot
			/Registry.php
		/Command
			/.gitkeep
		/Controller
			/.gitkeep
		/Exception
			/.gitkeep
		/Operation
			/.gitkeep
		/Repository
			/.gitkeep
		/Service
			/.gitkeep
		/Util
			/.gitkeep

	/tests
		/.gitkeep

	.gitattributes
	.gitignore
	composer.json
	LICENSE
	NOTICE
	README.md
	TRADEMARKS.md
```

The empty directories are extension points, not obligations.

A concrete provider may remove unused directories or leave their `.gitkeep` files in place while the package is being developed.

Additional CitOmni layers may be added when the concrete package genuinely needs them:

```text
src/Contract/
src/Policy/
src/State/
src/Support/
src/Enum/
```

---

## Provider Registry

Provider boot contributions belong in:

```text
src/Boot/Registry.php
```

The skeleton documents every provider contribution currently recognized by `citomni/kernel`.

### `MAP_COMMON`

Defines services shared by HTTP and CLI.

```php
public const array MAP_COMMON = [
	'example' => \Vendor\Package\Service\ExampleService::class,
];
```

A service may also be registered with constructor options:

```php
public const array MAP_COMMON = [
	'example' => [
		'class' => \Vendor\Package\Service\ExampleService::class,
		'options' => [
			'enabled' => true,
		],
	],
];
```

CitOmni resolves registered services lazily through the App service map.

Supported service construction is:

```php
new Service($app);
```

or:

```php
new Service($app, $options);
```

### `MAP_HTTP`

Defines services available only in HTTP mode.

Use this when the service genuinely depends on the HTTP runtime.

For the same service ID within one provider, `MAP_HTTP` takes precedence over `MAP_COMMON` in HTTP mode.

### `MAP_CLI`

Defines services available only in CLI mode.

Use this when the service genuinely depends on the CLI runtime.

For the same service ID within one provider, `MAP_CLI` takes precedence over `MAP_COMMON` in CLI mode.

### `CFG_COMMON`

Defines package-owned configuration defaults shared by HTTP and CLI.

```php
public const array CFG_COMMON = [
	'vendor_package' => [
		'enabled' => true,
	],
];
```

Keep defaults under package-owned keys.

Provider configuration should define sensible package defaults, not environment-specific host application policy.

### `CFG_HTTP`

Defines configuration defaults used only in HTTP mode.

`CFG_HTTP` is merged after `CFG_COMMON` for that provider, so mode-specific associative values win on conflicts.

### `CFG_CLI`

Defines configuration defaults used only in CLI mode.

`CFG_CLI` is merged after `CFG_COMMON` for that provider, so mode-specific associative values win on conflicts.

### `ROUTES_HTTP`

Defines HTTP route dispatch entries contributed by the provider.

Routes belong here, not inside provider configuration.

The concrete route entry contract is owned by `citomni/http`.

### `COMMANDS_CLI`

Defines CLI command dispatch entries contributed by the provider.

Commands belong here, not inside provider configuration or service maps merely to make them dispatchable.

The concrete command entry contract is owned by `citomni/cli`.

### Optional contributions

All Registry contributions are optional.

The skeleton keeps the supported constants documented but commented out. Uncomment only the constants the concrete package actually needs.

CitOmni checks whether a provider constant exists before reading it.

---

## Composition and precedence

Provider composition is deterministic.

### Configuration

For the active mode, a provider contributes:

```text
CFG_COMMON
then
CFG_HTTP or CFG_CLI
```

Configuration uses associative last-wins merging.

Within one provider, mode-specific configuration therefore overrides conflicting shared values.

Providers are processed in the order listed by the host application. Later provider configuration overrides earlier provider configuration on conflicting associative keys.

Host application configuration is applied after provider configuration and may override provider defaults.

### Services

For the active mode, a provider may contribute:

```text
MAP_COMMON
then
MAP_HTTP or MAP_CLI
```

Service maps use PHP array-union semantics with the newer contribution on the left.

This means:

- Mode-specific service definitions override the same provider's shared definition for the same service ID.
- Later providers override earlier providers for the same service ID.
- Host application service definitions override provider service definitions.
- Provider service definitions override the selected CitOmni runtime baseline.

Avoid accidental service-ID collisions between unrelated packages.

### Dispatch

HTTP routes and CLI commands are separate dispatch maps.

Provider dispatch contributions use associative last-wins merging.

Later providers therefore override earlier providers on conflicting dispatch keys.

Host application dispatch entries are applied after provider entries and may override provider dispatch.

---

## Configuration access

Merged configuration is exposed through:

```php
$this->app->cfg
```

The configuration object is read-only.

Associative arrays become nested configuration objects. Lists remain arrays.

A direct read throws `\OutOfBoundsException` at the first missing key, at any depth. `??` and `isset()` check every node on the path and never throw on a missing key, so they hide it.

Read the configuration the provider owns directly. The Registry ships a default in `CFG_COMMON`, `CFG_HTTP` or `CFG_CLI` for every path the provider reads; a guard would duplicate that default and hide a missing baseline. A missing baseline is fixed in the Registry, not at the call site:

```php
$enabled = (bool)$this->app->cfg->vendor_package->enabled;
```

A service option over provider-owned configuration falls back to the cfg read, with no further default:

```php
$enabled = (bool)($this->options['enabled'] ?? $this->app->cfg->vendor_package->enabled);
```

Configuration owned by the host application or another package, and a path that exists in one mode only, may be absent. Read it with `?? <default>`, and use `isset()` only to branch on whether a node exists:

```php
$timezone = (string)($this->app->cfg->locale->timezone ?? 'UTC');
```

Environment-specific values belong to the host application rather than the provider package.

---

## Source-layer model

CitOmni keeps responsibility boundaries explicit.

- `src/Boot/`: Provider composition metadata. `Registry.php` belongs here.
- `src/Controller/`: HTTP transport adapters. No SQL and no non-trivial business orchestration.
- `src/Command/`: CLI transport adapters. No SQL and no non-trivial business orchestration.
- `src/Operation/`: Transport-agnostic orchestration and application-level decision logic.
- `src/Repository/`: Persistence boundary. All SQL and datastore IO belongs here.
- `src/Service/`: Reusable App-aware services registered through the provider service map.
- `src/Util/`: Pure helpers only. No App, no config reads, no IO, no logging, no caching, no SQL, and no mutable state.
- `src/Exception/`: Transport-agnostic package, application, and domain failure semantics.

Additional layers may be introduced when their responsibility is real:

- `src/Contract/`: Small, stable public extension interfaces.
- `src/Policy/`: App-aware rules, requirements, and policy decisions.
- `src/State/`: App-aware runtime state handlers with explicit contracts and transitions.
- `src/Support/`: Focused App-aware supporting classes that are not registered services.
- `src/Enum/`: Stable bounded value sets.

Operations are instantiated explicitly when orchestration or reuse justifies the extra layer. They are not service-map services.

Every class placed in `src/Service/` should be a real registered service.

Prefer the shortest architecture that preserves these boundaries.

---

## Package ownership

CitOmni keeps package ownership explicit.

```text
citomni/provider-skeleton
	Owns the neutral provider package container.

citomni/kernel
	Owns provider composition and the Registry contribution contract.

citomni/http
	Owns the HTTP runtime and HTTP route contract.

citomni/cli
	Owns the CLI runtime and CLI command contract.

the concrete provider
	Owns its services, defaults, adapters, persistence, and reusable behavior.

the host application
	Owns provider registration, environment overrides, deployment, runtime state,
	the final Composer installation, and application-specific wiring.
```

A provider should not create host-app config files, runtime directories, public webroots, deployment files, or other application-owned scaffold merely because it may need those concepts at runtime.

The package contributes behavior. The host application decides how that behavior is composed and deployed.

---

## Install a finished provider in a host app

A finished provider is consumed as a Composer dependency.

From the host application:

```bash
composer require vendor/package
```

Then register the provider Registry in:

```text
config/providers.php
```

Example:

```php
<?php
declare(strict_types=1);

return [
	\Vendor\Package\Boot\Registry::class,
];
```

The host application then composes the provider's contributions into its active HTTP or CLI runtime.

Provider order matters when multiple providers contribute conflicting configuration, service IDs, routes, or commands.

---

## Dependency boundaries

A provider should declare dependencies it directly needs.

For example:

- A provider extending HTTP base classes should require the package that provides those classes.
- A provider extending CLI base classes should require the package that provides those classes.
- A provider using database or infrastructure services should require the package that defines the relevant public contract or implementation dependency.
- A mode-neutral provider should not acquire HTTP or CLI dependencies simply because the host application may have them installed.

Do not rely on transitive dependencies supplied accidentally by some host application.

If provider code imports or extends a class from another package, that dependency should normally be explicit in the provider's own `composer.json`.

---

## Autoloading and host-app performance

The provider exposes its classes through Composer PSR-4 autoloading.

The skeleton starts with:

```json
{
	"autoload": {
		"psr-4": {
			"CitOmni\\ProviderSkeleton\\": "src/"
		}
	}
}
```

A concrete provider replaces the skeleton namespace with its own package namespace.

While developing the provider, regenerate its local development autoloader after changing autoload configuration:

```bash
composer dump-autoload
```

When the provider is installed as a dependency, the **host application's Composer installation owns the final combined autoloader**.

Production autoloader optimization, `--no-dev`, authoritative classmaps, APCu autoloading, OPcache, and deployment policy therefore belong to the host application, not to the provider package.

A provider should publish correct Composer autoload metadata and leave application-level optimization decisions to the root project.

---

## Line endings

The skeleton ships with `.gitattributes` to keep text files normalized.

This reduces false diffs, keeps package archives predictable, and keeps Windows development from turning line endings into a tiny procedural crime scene.

The same file also uses `export-ignore` for repository-only files that should remain tracked in Git but do not belong in generated package archives.

---

## Testing

The skeleton provides:

```text
tests/
```

with a PSR-4 development namespace in `composer.json`.

A concrete provider should add tests for real package behavior and public integration contracts.

If PHPUnit is needed during provider development:

```bash
composer require --dev phpunit/phpunit
```

Tests belong under:

```text
tests/
```

with the concrete package's test namespace, for example:

```text
Vendor\Package\Tests\
```

Do not add smoke tests whose only purpose is to prove that placeholder skeleton classes exist.

The host application's test suite may additionally test the provider as part of full application integration.

---

## Troubleshooting

### Provider Registry class is not found

Confirm that:

- The provider is installed through Composer.
- The provider's PSR-4 namespace matches its source tree.
- `src/Boot/Registry.php` uses the expected namespace.
- The Registry FQCN in the host application's `config/providers.php` is correct.

During provider development, regenerate the local autoloader after namespace or autoload changes:

```bash
composer dump-autoload
```

### A Registry contribution has no effect

Confirm that the relevant constant is actually declared rather than left commented out.

Also confirm that the contribution matches the active runtime mode.

Examples:

- `MAP_HTTP`, `CFG_HTTP`, and `ROUTES_HTTP` do not contribute in CLI mode.
- `MAP_CLI`, `CFG_CLI`, and `COMMANDS_CLI` do not contribute in HTTP mode.

### A service cannot be resolved

Confirm that:

- The service is registered in the appropriate `MAP_*` constant.
- The service ID matches the ID used by the caller.
- The service definition is either a class string or a supported class/options definition.
- The service constructor accepts the App object, with optional options when that form is used.

### Provider configuration is unexpectedly overridden

Remember that provider configuration supplies defaults.

Later providers may override earlier provider values, and host application configuration is applied after provider configuration.

Use package-owned configuration keys to minimize accidental collisions.

### HTTP or CLI classes are unavailable

If the provider directly depends on HTTP or CLI classes, make that dependency explicit in the provider's own `composer.json`.

Do not assume that a host application or another dependency will provide the package transitively.

---

## Coding and documentation conventions

All CitOmni projects follow the shared conventions documented here:

[CitOmni Coding and Documentation Conventions](https://github.com/citomni/docs/blob/main/contribute/CONVENTIONS.md)

Core conventions:

- PHP **8.5+**
- PSR-1 and PSR-4
- PascalCase classes
- camelCase methods and variables
- UPPER_SNAKE_CASE constants
- K&R brace style
- Tabs for indentation
- PHPDoc and inline comments in English
- Explicit wiring over discovery
- Deterministic behavior over magic
- SQL only in Repositories
- Transport concerns only in Controllers and Commands
- Fail fast unless recovery is intentional

Performance and low runtime overhead are first-class concerns.

Prefer the shortest architecture that preserves clear responsibility boundaries.

---

## License

**CitOmni Provider Skeleton** is open-source under the **MIT License**.

See [LICENSE](LICENSE).

**Trademark notice:** "CitOmni" and the CitOmni logo are trademarks of **Lars Grove Mortensen**. Usage of the name or logo must follow the policy in [NOTICE](NOTICE). Do not imply endorsement or affiliation without prior written permission.

---

## Trademarks

"CitOmni" and the CitOmni logo are trademarks of **Lars Grove Mortensen**.

You may make factual references to "CitOmni", but do not modify the marks, create confusingly similar logos, or imply sponsorship, endorsement, or affiliation without prior written permission.

Do not register or use "citomni" or confusingly similar terms in company names, domains, social handles, or top-level vendor/package names.

For details, see [NOTICE](NOTICE).

---

## Author

Developed by Lars Grove Mortensen © 2012-present.

---

CitOmni - low overhead, high performance, ready for anything.
