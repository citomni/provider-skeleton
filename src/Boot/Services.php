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
