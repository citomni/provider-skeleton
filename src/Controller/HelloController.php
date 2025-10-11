<?php
declare(strict_types=1);
/*
 * This file is part of the CitOmni framework.
 * Low overhead, high performance, ready for anything.
 *
 * For more information, visit https://github.com/citomni
 *
 * Copyright (c) 2012-present Lars Grove Mortensen
 * SPDX-License-Identifier: MIT
 *
 * For full copyright, trademark, and license information,
 * please see the LICENSE file distributed with this source code.
 */

namespace CitOmni\ProviderSkeleton\Controller;

use CitOmni\Kernel\Controller\BaseController;

/**
 * HelloController — minimal demo controller.
 *
 * Contract:
 * - Constructed by the router with (App $app, array $routeConfig).
 * - Exposes public action methods (e.g., index()) per route declaration.
 *
 * Behavior:
 * - Inherits $this->app and $this->routeConfig from BaseController.
 * - BaseController automatically calls ->init() once after construction.
 *
 * Typical usage:
 *   GET /hello  → index()
 */
final class HelloController extends BaseController {
	
	/**
	 * One-time setup hook. Called automatically by BaseController::__construct().
	 *
	 * Behavior:
	 * - Read/validate $this->routeConfig['options'] if needed.
	 * - Precompute cheap derived state for the request lifetime.
	 */
	protected function init(): void {
		// no-op; keep for future tweaks (e.g., normalize 'who' option)
	}

	/**
	 * GET /hello
	 *
	 * @return void Outputs a tiny HTML page.
	 */
	public function index(): void {
		$who = (string)($this->routeConfig['options']['who'] ?? 'world');
		$msg = $this->app->greeting->make($who);

		echo "<!doctype html><meta charset=\"utf-8\"><title>Hello</title>";
		echo "<p>{$msg}</p>";
	}
}
