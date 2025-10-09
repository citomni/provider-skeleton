<?php
declare(strict_types=1);
/*
 * SPDX-License-Identifier: GPL-3.0-or-later
 * Copyright (C) 2012-2025 Lars Grove Mortensen
 *
 * CitOmni Provider Skeleton - Template provider package for CitOmni apps.
 * Source:  https://github.com/citomni/provider-skeleton
 * License: See the LICENSE file for full terms.
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
