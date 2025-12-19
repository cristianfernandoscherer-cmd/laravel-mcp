<?php

declare(strict_types=1);

if ($argc < 2) {
    echo "Usage: php check-coverage.php <path-to-clover-xml> [baseline-file]\n";
    exit(1);
}

$cloverFile = $argv[1];
$baselineFile = isset($argv[2]) ? $argv[2] : '.coverage_baseline';

if (!file_exists($cloverFile)) {
    echo "Error: Clover XML file not found at $cloverFile\n";
    exit(1);
}

$xml = new SimpleXMLElement(file_get_contents($cloverFile));
$metrics = $xml->xpath('//metrics');

$totalStatements = 0;
$coveredStatements = 0;

foreach ($metrics as $metric) {
    $totalStatements += (int) $metric['statements'];
    $coveredStatements += (int) $metric['coveredstatements'];
}

if ($totalStatements === 0) {
    echo "No statements found for coverage calculation.\n";
    exit(0);
}

$currentCoverage = ($coveredStatements / $totalStatements) * 100;
$currentCoverageFormatted = number_format($currentCoverage, 2);

$baseline = 0.0;
if (file_exists($baselineFile)) {
    $baseline = (float) file_get_contents($baselineFile);
}

$baselineFormatted = number_format($baseline, 2);

echo "Current Code Coverage: $currentCoverageFormatted%\n";
echo "Baseline Coverage: $baselineFormatted%\n";

if ($currentCoverage < $baseline - 0.01) { // Small margin for floating point
    echo "\033[31mError: Code coverage has decreased! ($currentCoverageFormatted% < $baselineFormatted%)\033[0m\n";
    exit(1);
}

// Update baseline only if it improved or is the same
file_put_contents($baselineFile, (string) $currentCoverage);

if ($currentCoverage > $baseline) {
    echo "\033[32mSuccess: Code coverage improved to $currentCoverageFormatted%!\033[0m\n";
} else {
    echo "\033[32mSuccess: Code coverage maintained at $currentCoverageFormatted%.\033[0m\n";
}

exit(0);
