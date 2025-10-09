# CitOmni Provider Skeleton

Minimal, deterministic **provider template** for CitOmni (PHP 8.2+).
Contributes **config** and **services** via boot constants - with optional **routes**, **controllers**, **commands**, and **models**. No magic. No surprises.

♻️ **Green by design** - fewer CPU cycles, lower memory, faster deploys. **More requests per watt.**

> **Scope:** Provider/package skeleton (mode-neutral).
> Use with `citomni/http` if you expose HTTP routes; use `citomni/cli` if you wire commands into a runner.
> For application skeletons, see `citomni/http-skeleton`, `citomni/cli-skeleton`, or `citomni/app-skeleton`.

---

## Requirements

* PHP **8.2+**
* Composer
* `citomni/kernel` (required)
* Optional: `citomni/http` (if you use routes/controllers), `citomni/cli` (if you expose commands)

---

## Install (scaffold a new provider repo)

This repository is a **template** (Composer project). Create a new provider from it:

```bash
composer create-project citomni/provider-skeleton my-provider
cd my-provider
```

From here you'll **rename** things (package name, namespace, classes) and turn it into your own provider **library**.

---

## What's included (in this skeleton)

```
provider-skeleton/
  ├─ src/
  │  ├─ Boot/
  │  │  ├─ Services.php         # MAP_*/CFG_* boot constants
  │  │  └─ Routes.php           # Example /hello route map (optional)
  │  ├─ Controller/
  │  │  └─ HelloController.php  # Extends Kernel BaseController
  │  ├─ Command/
  │  │  └─ HelloCommand.php     # Extends Kernel BaseCommand
  │  ├─ Service/
  │  │  └─ GreetingService.php  # Extends Kernel BaseService
  │  └─ Model/
  │     └─ DemoModel.php        # Extends Kernel BaseModel
  ├─ tests/
  │  └─ SkeletonSmokeTest.php   # Tiny smoke-test stub (optional)
  ├─ stubs/
  │  └─ provider.composer.json.stub   # READY-TO-PUBLISH composer.json (library)
  ├─ composer.json              # TYPE: project (template for create-project)
  ├─ README.md
  ├─ LICENSE
  └─ .gitignore
```

**PSR-4:** `"CitOmni\\ProviderSkeleton\\": "src/"`
**SPDX header:** All PHP files should carry the standard CitOmni header.

---

## Deterministic configuration (last wins)

Per execution mode (HTTP|CLI), config merges in this order:

1. **Vendor baseline** (by mode)
2. **Providers** (classes listed in your app's `/config/providers.php`; order matters)
3. **App base** (`/config/citomni_{http|cli}_cfg.php`)
4. **Env overlay** (`/config/citomni_{http|cli}_cfg.{dev|stage|prod}.php`)

Merged config is exposed as a **deep, read-only** wrapper; large lists (e.g., `routes`) remain raw arrays for performance:

```php
$baseUrl = $this->app->cfg->http->base_url;
$routes  = $this->app->cfg->routes; // raw array by design
```

Services use the same precedence (app overrides provider overrides vendor).

---

## Quick start checklist (after scaffold)

1. **Switch to your identity**

   * Open `/stubs/provider.composer.json.stub`.
   * Replace placeholders:

     * `your-vendor/your-provider`
     * `YourVendor\\YourProvider\\`
     * URLs and author fields
   * Save it **as** `/composer.json` (overwriting the skeleton's), and ensure `"type": "library"`.

2. **Rename the namespace in code**

   * Update PSR-4 in `/composer.json` to `"YourVendor\\YourProvider\\": "src/"`
   * Search/replace namespaces in `src/` (and `tests/` if used):

   **GNU sed (bash):**

   ```bash
   find src tests -type f -name '*.php' -print0 \
     | xargs -0 sed -i 's/CitOmni\\ProviderSkeleton\\/YourVendor\\YourProvider\\/g'
   ```

   **PowerShell:**

   ```powershell
   gci -rec src,tests -filter *.php | % {
     (Get-Content $_.FullName) -replace 'CitOmni\\ProviderSkeleton\\','YourVendor\\YourProvider\\' |
       Set-Content $_.FullName
   }
   ```

3. **Rename the boot provider class**

   * Keep the file path: `src/Boot/Services.php`
   * Change the class namespace to `YourVendor\YourProvider\Boot\Services`

4. **Decide what to keep**

   * The examples (`GreetingService`, `HelloController`, `HelloCommand`, `DemoModel`) are there to smoke-test your wiring. Keep or prune freely.

5. **Validate & autoload**

   ```bash
   composer validate
   composer dump-autoload -o
   ```

6. **Publish**

   * Push to your Git hosting (e.g., GitHub)
   * Submit to Packagist (or enable auto-submit via webhook)

---

## Provider contract (boot constants)

Your provider contributes config and services through class constants. Only present constants are read.

```php
<?php
declare(strict_types=1);

namespace CitOmni\ProviderSkeleton\Boot;

final class Services {
	public const MAP_HTTP = [
		'greeting' => [
			'class'   => \CitOmni\ProviderSkeleton\Service\GreetingService::class,
			'options' => ['prefix' => 'Hello'],
		],
	];

	public const CFG_HTTP = [
		'provider_skeleton' => [
			'enabled'  => true,
			'greeting' => ['prefix' => 'Hello'],
		],
		'routes' => \CitOmni\ProviderSkeleton\Boot\Routes::MAP,
	];

	public const MAP_CLI = [
		'hello' => \CitOmni\ProviderSkeleton\Command\HelloCommand::class,
	];

	public const CFG_CLI = [
		'provider_skeleton' => ['enabled' => true],
	];
}
```

* **Service definitions**: either FQCN or `['class' => FQCN, 'options' => [...]]`
* **Ctor contract**: `__construct(App $app, array $options = [])`
* **Routes** live in config and remain a raw array (performance)

---

## Example route & controller (optional)

```php
<?php
declare(strict_types=1);

namespace CitOmni\ProviderSkeleton\Boot;

final class Routes {
	public const MAP = [
		'/hello' => [
			'controller' => \CitOmni\ProviderSkeleton\Controller\HelloController::class,
			'methods'    => ['GET'],
			'options'    => ['who' => 'world'],
		],
	];
}
```

```php
<?php
declare(strict_types=1);

namespace CitOmni\ProviderSkeleton\Controller;

use CitOmni\Kernel\Controller\BaseController;

/**
 * HelloController - minimal demo controller.
 *
 * Behavior:
 * - Inherits $this->app and $this->routeConfig from BaseController.
 * - BaseController automatically calls ->init() after construction.
 */
final class HelloController extends BaseController {
	/** Lightweight, one-time setup (optional). */
	protected function init(): void {
		// no-op; keep it lean
	}

	/** GET /hello - emits tiny HTML. */
	public function index(): void {
		$who = (string)($this->routeConfig['options']['who'] ?? 'world');
		$msg = $this->app->greeting->make($who);

		echo "<!doctype html><meta charset=\"utf-8\"><title>Hello</title>";
		echo "<p>{$msg}</p>";
	}
}
```

---

## Example service

```php
<?php
declare(strict_types=1);

namespace CitOmni\ProviderSkeleton\Service;

use CitOmni\Kernel\Service\BaseService;

/**
 * GreetingService - tiny example with a configurable prefix.
 *
 * Typical usage:
 *   $this->app->greeting->make('Alice'); // "Hello, Alice"
 */
final class GreetingService extends BaseService {
	/** Lightweight, one-time setup (optional). */
	protected function init(): void {
		// reserved for future tweaks (e.g., precompute prefix)
	}

	public function make(string $name): string {
		$cfgPrefix = $this->app->cfg->toArray()['provider_skeleton']['greeting']['prefix'] ?? null;
		$prefix = \is_string($cfgPrefix) && $cfgPrefix !== '' ? $cfgPrefix : ($this->options['prefix'] ?? 'Hello');
		return $prefix . ', ' . $name;
	}
}
```

---

## Example command (optional)

This skeleton assumes the kernel offers a minimal `\CitOmni\Kernel\Command\BaseCommand` (constructor + `init()` + abstract `run()`), and your CLI runner calls `$app->hello->run($argv)`.

```php
<?php
declare(strict_types=1);

namespace CitOmni\ProviderSkeleton\Command;

use CitOmni\Kernel\Command\BaseCommand;

/**
 * HelloCommand - example command implementing BaseCommand contract.
 */
final class HelloCommand extends BaseCommand {
	protected function init(): void {
		// validate/normalize $this->options if needed
	}

	public function run(array $argv = []): int {
		$name = $argv[0] ?? ($this->options['default_name'] ?? 'world');
		$line = $this->app->greeting->make($name);
		\fwrite(\STDOUT, $line . \PHP_EOL);
		return 0;
	}
}
```

---

## Example model (optional)

```php
<?php
declare(strict_types=1);

namespace CitOmni\ProviderSkeleton\Model;

use CitOmni\Kernel\Model\BaseModel;

/**
 * DemoModel - optional skeleton demonstrating BaseModel constructor pattern.
 */
final class DemoModel extends BaseModel {
	protected function init(): void {
		// precompute cheap derived state if needed
	}

	/** @return array<int,string> */
	public function listSamples(): array {
		return ['alpha', 'beta', 'gamma'];
	}
}
```

---

## SPDX header template (use in every PHP file)

```php
<?php
declare(strict_types=1);
/*
 * SPDX-License-Identifier: GPL-3.0-or-later
 * Copyright (C) [START_YEAR]-[CURRENT_YEAR] [YOUR NAME]
 *
 * [PACKAGE TITLE] - [One-line description]
 * Source:  https://github.com/[your-vendor]/[your-repo]
 * License: See the LICENSE file for full terms.
 */
```

---

## From skeleton -> finished provider (library)

1. **Replace composer metadata**
   Use `/stubs/provider.composer.json.stub` as your base: copy to `/composer.json`, set `"type": "library"`, and fill in identity/URLs/authors.

2. **Change namespace**
   Update PSR-4 and classes to `YourVendor\YourProvider\...` (see the sed/PowerShell snippets above).

3. **Rename boot class**
   Keep `src/Boot/Services.php`, but set the FQCN to `YourVendor\YourProvider\Boot\Services`.

4. **Validate & autoload**

   ```bash
   composer validate
   composer dump-autoload -o
   ```

5. **Publish**

   * Push to GitHub
   * Submit to Packagist (or enable auto-hook)

---

## Using your finished provider in an app

1. Install in the **app**:

```bash
composer require your-vendor/your-provider
```

2. Enable the provider (whitelist):

```php
<?php
// app/config/providers.php
return [
	\YourVendor\YourProvider\Boot\Services::class,
];
```

3. (Optional) Override defaults:

```php
<?php
// app/config/citomni_http_cfg.php
return [
	'your_provider' => [
		'enabled'  => true,
		'greeting' => ['prefix' => 'Hej'],
	],
];
```

---

## Performance & caching (production)

* Use **compiled caches**:

  * `<appRoot>/var/cache/cfg.{http|cli}.php`
  * `<appRoot>/var/cache/services.{http|cli}.php`
* Generate atomically during deploy:

  ```php
  $app = new \CitOmni\Kernel\App(__DIR__ . '/../config', \CitOmni\Kernel\Mode::HTTP);
  $app->warmCache(true, true);
  ```
* Enable OPcache; consider `validate_timestamps=0` (then invalidate on deploy).

---

## Testing

This skeleton ships with a tiny smoke test stub (optional).
For integrated, framework-native testing (dev-only), consider `citomni/testing`.

---

## Coding & documentation conventions

* PHP **8.2+**, PSR-1/PSR-4
* **PascalCase** classes, **camelCase** methods/vars, **UPPER_SNAKE_CASE** constants
* **K&R braces**, **tabs** for indentation
* PHPDoc & inline comments in **English**
* Fail fast; do not catch unless necessary (global handler logs)

See: CitOmni **CONVENTIONS.md** (in the kernel repo).

---

## License

Released under **GNU GPL v3.0 or later**.
See [LICENSE](LICENSE) for details.

---

## Trademarks

"CitOmni" and the CitOmni logo are trademarks of Lars Grove Mortensen; factual references are allowed, but do not modify the marks, create confusingly similar logos, or imply endorsement.

---

## Author

Developed by **Lars Grove Mortensen** © 2012-2025
Contributions and pull requests are welcome.

---

Built with ❤️ on the CitOmni philosophy: **low overhead**, **high performance**, **ready for anything**.
