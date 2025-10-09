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

namespace CitOmni\ProviderSkeleton\Command;

use CitOmni\Kernel\Command\BaseCommand;

/**
 * HelloCommand — example command implementing BaseCommand contract.
 *
 * Typical usage (runner-dependent):
 *   $exit = $this->app->hello->run(['Alice']);
 */
final class HelloCommand extends BaseCommand {
	
	/**
	 * One-time setup hook. Called automatically by BaseCommand::__construct().
	 *
	 * Behavior:
	 * - Precompute or validate options if needed.
	 */
	protected function init(): void {
		// no-op; reserved for future tweaks
	}

	/**
	 * Execute the command.
	 *
	 * @param array<int,string> $argv Raw CLI args; $argv[0] is the optional name.
	 * @return int Exit code (0 = success).
	 */
	public function run(array $argv = []): int {
		$name = $argv[0] ?? 'world';
		$line = $this->app->greeting->make($name);
		\fwrite(\STDOUT, $line . \PHP_EOL);
		return 0;
	}
}
