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

/**
 * Declare this provider package's boot contributions.
 *
 * Behavior:
 * - Registers shared service maps through MAP_COMMON.
 * - Registers shared cfg overlays through CFG_COMMON.
 * - Registers HTTP and CLI service maps.
 * - Registers HTTP and CLI cfg overlays.
 * - Registers HTTP routes through ROUTES_HTTP.
 * - Registers CLI commands through COMMANDS_CLI.
 *
 * Notes:
 * - Commands belong in COMMANDS_CLI, not in MAP_CLI.
 * - Dispatch maps must remain separate from CFG constants.
 * - Shared services and cfg defaults belong in MAP_COMMON and CFG_COMMON.
 * - Mode-specific constants should only contain genuinely mode-specific entries.
 */
final class Registry {


	/**
	 * Shared service map.
	 *
	 * Services declared here are available in both HTTP and CLI mode.
	 * Use this for transport-neutral singleton services that can safely be
	 * resolved through $this->app->{id} from either runtime.
	 *
	 * Notes:
	 * - Keep controllers, commands, operations, and repositories out of the service map.
	 * - Use MAP_HTTP or MAP_CLI only for genuinely mode-specific services.
	 *
	 * @var array<string, string|array<string, mixed>>
	 */
	public const MAP_COMMON = [
	];


	/**
	 * Shared cfg overlay.
	 *
	 * Config declared here is available in both HTTP and CLI mode.
	 * Use this for package defaults that are not tied to one transport runtime.
	 *
	 * Notes:
	 * - Keep dispatch maps out of cfg constants.
	 * - Use CFG_HTTP or CFG_CLI only for genuinely mode-specific defaults.
	 * - App-level config may override these defaults through the normal CitOmni merge flow.
	 *
	 * @var array<string, mixed>
	 */
	public const CFG_COMMON = [
	];


	/**
	 * HTTP service map.
	 *
	 * @var array<string, string|array<string, mixed>>
	 */
	public const MAP_HTTP = [
		'greeting' => [
			'class'   => \CitOmni\ProviderSkeleton\Service\GreetingService::class,
			'options' => [
				'prefix' => 'Hello',
			],
		],
	];

	/**
	 * HTTP cfg overlay.
	 *
	 * @var array<string, mixed>
	 */
	public const CFG_HTTP = [
		'provider_skeleton' => [
			'enabled'  => true,
			'greeting' => [
				'prefix' => 'Hello',
			],
		],
	];

	/**
	 * HTTP routes.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	public const ROUTES_HTTP = [
		'/hello.html' => [
			'controller' => \CitOmni\ProviderSkeleton\Controller\HelloController::class,
			'action'     => 'index',
			'methods'    => ['GET'],
			'options'    => [
				'who' => 'world',
			],
		],
	];

	/**
	 * CLI service map.
	 *
	 * Reuses the HTTP service map because the demo command uses the same
	 * greeting service. Real packages may keep CLI services narrower.
	 *
	 * @var array<string, string|array<string, mixed>>
	 */
	public const MAP_CLI = self::MAP_HTTP;

	/**
	 * CLI cfg overlay.
	 *
	 * Reuses the HTTP cfg overlay because this skeleton exposes the same
	 * package-level defaults in both modes.
	 *
	 * @var array<string, mixed>
	 */
	public const CFG_CLI = self::CFG_HTTP;

	/**
	 * CLI commands.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	public const COMMANDS_CLI = [
		'provider-skeleton:demo' => [
			'command'     => \CitOmni\ProviderSkeleton\Command\DemoCommand::class,
			'description' => 'Run the provider skeleton demo command',
		],
	];
}
