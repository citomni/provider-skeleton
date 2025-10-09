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

final class Services {
	/**
	 * HTTP service map.
	 * Keys are $this->app->{id}; values are FQCN or ['class'=>..., 'options'=>...].
	 */
	public const MAP_HTTP = [
		'greeting' => [
			'class'   => \CitOmni\ProviderSkeleton\Service\GreetingService::class,
			'options' => [
				'prefix' => 'Hello'
			],
		],
	];

	/**
	 * HTTP cfg overlay (merged vendor → providers → app → env; last wins).
	 * Includes provider routes.
	 */
	public const CFG_HTTP = [
		'provider_skeleton' => [
			'enabled'  => true,
			'greeting' => ['prefix' => 'Hello'],
		],
		'routes' => \CitOmni\ProviderSkeleton\Boot\Routes::MAP,
	];

	/**
	 * CLI service map (optional mirror). Kept minimal to avoid overhead.
	 * NOTE: Real CLI wiring depends on citomni/cli runner. This is a service stub.
	 */
	public const MAP_CLI = [
		'hello' => \CitOmni\ProviderSkeleton\Command\HelloCommand::class,
	];

	/**
	 * CLI cfg overlay (optional).
	 */
	public const CFG_CLI = [
		'provider_skeleton' => [
			'enabled' => true,
		],
	];
}
