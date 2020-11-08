<?php declare(strict_types=1);
/*
 * This file is part of phpunit/php-code-coverage.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianBergmann\CodeCoverage\Report;

use function dirname;
use function file_put_contents;
use lcov\{FunctionCoverage, LineCoverage, LineData, Record, Report};
use SebastianBergmann\CodeCoverage\Directory;
use SebastianBergmann\CodeCoverage\Driver\WriteOperationFailedException;
use SebastianBergmann\CodeCoverage\Node\File;

final class Lcov
{
    public function process(CodeCoverage $coverage, ?string $target = null, ?string $name = null): string
    {
        $report = $coverage->getReport();

        $records = [];
        foreach ($report as $item) {
            if (!$item instanceof File) {
                continue;
            }

            $coverageData = $item->lineCoverageData();

            $linesData = [];

            $record = new Record($item->pathAsString(), [
                'functions' => new FunctionCoverage(1, 1),
                'lines' => $lineCoverage
            ]);
        }

        $report = new Report("Example", $records);

        $lineCoverage = new LineCoverage(2, 2, [
            new LineData(6, 2),
            new LineData(7, 2)
        ]);

        $record = new Record("/home/cedx/lcov.hx/fixture.php", [
            'functions' => new FunctionCoverage(1, 1),
            'lines' => $lineCoverage
        ]);

        $report = new Report("Example", [$record]);

        if ($target !== null) {
            Directory::create(dirname($target));

            if (@file_put_contents($target, $buffer) === false) {
                throw new WriteOperationFailedException($target);
            }
        }

        return $buffer;
    }
}
