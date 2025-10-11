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

namespace CitOmni\ProviderSkeleton\Model;

use CitOmni\Kernel\Model\BaseModel;

/**
 * DemoModel — optional skeleton demonstrating BaseModel constructor pattern.
 *
 * Behavior:
 * - Inherits $this->app and $this->options from BaseModel.
 * - BaseModel automatically calls ->init() once after construction.
 *
 * Notes:
 * - Keep it tiny; real models may wrap persistence (DB/API) or domain logic.
 *
 * Typical usage:
 *   $items = $this->app->demoModel->listSamples();
 */
final class DemoModel extends BaseModel {
	
	/**
	 * One-time setup hook. Called automatically by BaseModel::__construct().
	 *
	 * Behavior:
	 * - Keep side effects minimal and deterministic (no I/O unless necessary).
	 * - Useful place to precompute derived options/lookup tables.
	 */
	protected function init(): void {
		// no-op; reserved for future tweaks (e.g., precompute caches)
	}

	/**
	 * Return a tiny sample payload.
	 *
	 * @return array<int,string> Example values for downstream tests/demos.
	 */
	public function listSamples(): array {
		return ['alpha', 'beta', 'gamma'];
	}
}
