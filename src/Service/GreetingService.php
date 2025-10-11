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

namespace CitOmni\ProviderSkeleton\Service;

use CitOmni\Kernel\Service\BaseService;

/**
 * GreetingService — tiny example service with a configurable prefix.
 *
 * Benefits of extending BaseService:
 * - Inherits $this->app and $this->options.
 * - Auto-calls init() if present.
 * - Consistent with Controller/Model base patterns.
 */
final class GreetingService extends BaseService {
	
	/**
	 * Optional: run one-time setup; BaseService calls this automatically.
	 */
	protected function init(): void {
		// no-op; keep for future tweaks (e.g., precompute prefix)
	}

	/**
	 * Build a greeting using cfg override when present.
	 *
	 * @param string $name Non-empty display name.
	 * @return string Greeting line.
	 */
	public function make(string $name): string {
		$cfgPrefix = $this->app->cfg->toArray()['provider_skeleton']['greeting']['prefix'] ?? null;
		$prefix = \is_string($cfgPrefix) && $cfgPrefix !== '' ? $cfgPrefix : ($this->options['prefix'] ?? 'Hello');
		return $prefix . ', ' . $name;
	}
}
