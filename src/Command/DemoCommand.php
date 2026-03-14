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

namespace CitOmni\ProviderSkeleton\Command;

use CitOmni\Kernel\Command\BaseCommand;
use CitOmni\ProviderSkeleton\Operation\DemoOperation;
use CitOmni\ProviderSkeleton\Util\DemoUtil;

/**
 * DemoCommand.
 *
 * Minimal CLI command example for the provider skeleton.
 *
 * Behavior:
 * - Demonstrates explicit operation instantiation in CLI mode.
 * - Demonstrates service usage through the App service map.
 * - Demonstrates pure helper usage through DemoUtil.
 * - Produces deterministic text output for smoke tests and examples.
 *
 * Notes:
 * - Keeps transport concerns in the command.
 * - Delegates orchestration to the operation layer.
 * - Avoids SQL outside the repository layer.
 */
final class DemoCommand extends BaseCommand {

	/**
	 * Run the demo command.
	 *
	 * Behavior:
	 * - Reads an optional search term from CLI args.
	 * - Loads rows through DemoOperation.
	 * - Decorates rows through DemoService.
	 * - Applies optional in-memory filtering in the command.
	 * - Writes a tiny deterministic report to STDOUT.
	 *
	 * Expected optional argument:
	 * - argv[0]: search term
	 *
	 * @param array<int,string> $args Raw CLI arguments excluding the command name.
	 * @return int Exit status code.
	 */
	public function run(array $args = []): int {
		$search = DemoUtil::normalizeSampleName((string)($args[0] ?? ''));
		$operation = new DemoOperation($this->app);

		$result = $operation->listSamples();
		$items = $this->app->demoService->decorateSamples($result['items'] ?? []);

		if ($search !== '') {
			$needle = \strtolower($search);
			$filtered = [];

			foreach ($items as $item) {
				$name = \strtolower((string)($item['name'] ?? ''));
				if (\str_contains($name, $needle)) {
					$filtered[] = $item;
				}
			}

			$items = $filtered;
		}

		$diagnostics = $this->app->demoService->getDiagnostics();

		$this->writeLine('Provider skeleton demo command');
		$this->writeLine('--------------------------------');
		$this->writeLine('Total rows: ' . (string)\count($items));
		$this->writeLine('Query count: ' . (string)($diagnostics['query_count'] ?? 0));

		if ($search !== '') {
			$this->writeLine('Search filter: ' . $search);
		}

		$this->writeLine('');

		if ($items === []) {
			$this->writeLine('No demo rows found.');
			return 0;
		}

		foreach ($items as $item) {
			$this->writeLine(
				'#' . (string)($item['id'] ?? 0)
				. ' '
				. (string)($item['name'] ?? '')
				. ' ['
				. (string)($item['status_label'] ?? 'unknown')
				. ']'
			);
		}

		return 0;
	}

	/**
	 * Write one line to STDOUT.
	 *
	 * @param string $text Output text.
	 * @return void
	 */
	private function writeLine(string $text): void {
		\fwrite(\STDOUT, $text . \PHP_EOL);
	}
}
