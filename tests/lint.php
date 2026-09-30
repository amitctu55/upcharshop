<?php
/**
 * Upchar.shop Automated PHP Syntax & Lint Verification
 */

$root = dirname(__DIR__);
$directories = [
    $root . '/app',
    $root . '/bootstrap',
    $root . '/config',
    $root . '/database',
    $root . '/routes',
    $root . '/tests',
];

$errors = [];
$totalChecked = 0;

echo "====================================================\n";
echo "🧪 Running UPCHAR Hospital Platform Syntax Verification\n";
echo "====================================================\n";
echo "PHP Version: " . PHP_VERSION . "\n\n";

function checkPhpSyntax($path, &$errors, &$totalChecked, $root) {
    if (
        strpos($path, 'vendor') !== false ||
        strpos($path, 'storage') !== false ||
        strpos($path, 'node_modules') !== false ||
        strpos($path, '.system_generated') !== false
    ) {
        return;
    }

    $totalChecked++;
    $relativePath = str_replace($root . DIRECTORY_SEPARATOR, '', $path);
    $code = file_get_contents($path);

    try {
        @token_get_all($code, TOKEN_PARSE);
    } catch (ParseError $e) {
        $errors[] = [
            'file' => $relativePath,
            'output' => $e->getMessage() . " on line " . $e->getLine()
        ];
        echo "❌ Error in: " . $relativePath . "\n";
        return;
    } catch (Throwable $e) {
        $errors[] = [
            'file' => $relativePath,
            'output' => $e->getMessage() . " on line " . $e->getLine()
        ];
        echo "❌ Error in: " . $relativePath . "\n";
        return;
    }
}

function scanDirectory($dir, &$errors, &$totalChecked, $root) {
    if (!is_dir($dir)) {
        return;
    }

    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }

        $fullPath = $dir . DIRECTORY_SEPARATOR . $item;
        if (is_dir($fullPath)) {
            scanDirectory($fullPath, $errors, $totalChecked, $root);
        } elseif (is_file($fullPath) && pathinfo($fullPath, PATHINFO_EXTENSION) === 'php') {
            checkPhpSyntax($fullPath, $errors, $totalChecked, $root);
        }
    }
}

foreach ($directories as $dir) {
    scanDirectory($dir, $errors, $totalChecked, $root);
}

echo "----------------------------------------------------\n";
echo "📊 Summary:\n";
echo "Scanned Files : " . $totalChecked . "\n";
echo "Syntax Errors : " . count($errors) . "\n\n";

if (count($errors) > 0) {
    echo "❌ FAILED: " . count($errors) . " syntax error(s) encountered.\n\n";
    foreach ($errors as $err) {
        echo "[File]: " . $err['file'] . "\n";
        echo $err['output'] . "\n";
        echo "----------------------------------------------------\n";
    }
    exit(1);
} else {
    echo "✅ SUCCESS: All " . $totalChecked . " PHP files passed syntax verification with 0 errors!\n";
    echo "----------------------------------------------------\n";
    exit(0);
}
