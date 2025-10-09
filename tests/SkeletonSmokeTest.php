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

namespace CitOmni\ProviderSkeleton\Tests;

use PHPUnit\Framework\TestCase;

final class SkeletonSmokeTest extends TestCase {
	public function testBootConstantsExist(): void {
		$this->assertTrue(\defined(\CitOmni\ProviderSkeleton\Boot\Services::class . '::MAP_HTTP'));
		$this->assertTrue(\defined(\CitOmni\ProviderSkeleton\Boot\Services::class . '::CFG_HTTP'));
		$this->assertTrue(\defined(\CitOmni\ProviderSkeleton\Boot\Services::class . '::MAP_CLI'));
		$this->assertTrue(\defined(\CitOmni\ProviderSkeleton\Boot\Services::class . '::CFG_CLI'));
	}
}
