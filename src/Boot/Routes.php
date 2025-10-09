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

namespace CitOmni\ProviderSkeleton\Boot;

final class Routes {
	/**
	 * Provider routes. Kernel keeps cfg['routes'] as a raw array (no wrapper).
	 */
	public const MAP = [
		'/hello' => [
			'controller' => \CitOmni\ProviderSkeleton\Controller\HelloController::class,
			'methods'    => ['GET'],
			'options'    => ['who' => 'world'],
		],
	];
}
