<?php

declare(strict_types=1);

require_once __DIR__ . '/../../bootstrap.php';

echo '=== Table Sandbox (Params) ===' . PHP_EOL;

// Template reference: docs/tasks/TK-params-sandbox-template.md


try {

    #region Test Definition

    // Agent or Human:
    //
    // Manage logic to instantiate the factory
    //

    $assert = static function (bool $condition, string $message): void {
        if (!$condition) {
            throw new RuntimeException($message);
        }
    };

    $globalParams = static function (string $suffix): array {
        return [
            'id' => 'table_id_' . $suffix,
            'class' => 'table-class-' . $suffix,
            'title' => 'table_title_' . $suffix,
            'style' => 'display:table',
            'lang' => 'en',
            'dir' => 'ltr',
            'hidden' => 'hidden',
            'tabindex' => 6,
            'draggable' => 'false',
            'contenteditable' => 'false',
            'spellcheck' => 'false',
            'translate' => 'no',
            'role' => 'table',
            'aria-label' => 'table_aria_label_' . $suffix,
            'aria-labelledby' => 'table_aria_labelledby_' . $suffix,
            'aria-describedby' => 'table_aria_describedby_' . $suffix
        ];
    };

    $makePayload = static function (object $factory): string {
        return json_encode($factory->compileAsArray(), JSON_UNESCAPED_SLASHES) ?: '';
    };

    $collectStrings = static function ($value) use (&$collectStrings): array {
        if (is_string($value)) {
            return [$value];
        }

        if (!is_array($value)) {
            return [];
        }

        $strings = [];
        foreach ($value as $item) {
            $strings = array_merge($strings, $collectStrings($item));
        }

        return $strings;
    };

    $cases = [
        'FourColumnSummaryTable' => static function () use ($globalParams): array {
            // Agent or Human:
            //
            // Manage logic to instantiate the factory
            //
    
            $factory = new \MvpLounge\MeshFactory\Element\Table\TableBody(array_merge($globalParams('four-column-summary'), [
                'cellspacing' => 0,
                'cellpadding' => 1,
                'border' => 1,
            ]));

            $factory
                ->addHeader('Quarter')
                ->addHeader('Revenue')
                ->addHeader('Growth')
                ->addHeader('Notes');

            $factory->addRow()
                ->addCell('Q1')
                ->addCell('$125,000')
                ->addCell('+8%')
                ->addCell('Baseline quarter');

            $factory->addRow()
                ->addCell('Q2')
                ->addCell('$138,000')
                ->addCell('+10%')
                ->addCell('Campaign lift');

            return [$factory, ['Quarter', 'Revenue', 'Growth', 'Notes', 'Q1', 'Q2', 'Campaign lift', 'cellspacing="0"', 'cellpadding="1"', 'border="1"']];
        },
        'RowspanColspanCell' => static function () use ($globalParams): array {
            $factory = new \MvpLounge\MeshFactory\Element\Table\TableCell(array_merge($globalParams('rowspan-colspan-cell'), [
                'colspan' => 2,
                'rowspan' => 3,
                'headers' => 'summary revenue forecast',
                'content' => 'Merged summary cell',
            ]));

            return [$factory, ['colspan="2"', 'rowspan="3"', 'headers="summary revenue forecast"', 'Merged summary cell']];
        },
        'RowspanColspanHeader' => static function () use ($globalParams): array {
            $factory = new \MvpLounge\MeshFactory\Element\Table\TableHeader(array_merge($globalParams('rowspan-colspan-header'), [
                'colspan' => 1,
                'rowspan' => 2,
                'scope' => 'rowgroup',
                'headers' => 'header-group',
                'abbr' => 'Grp',
                'content' => 'Grouped heading',
            ]));

            return [$factory, ['colspan="1"', 'rowspan="2"', 'scope="rowgroup"', 'headers="header-group"', 'abbr="Grp"', 'Grouped heading']];
        },
        'DataTableBody' => static function () use ($globalParams): array {
            $factory = new \MvpLounge\MeshFactory\Element\Table\DataTableBody(array_merge($globalParams('datatable-body'), [
                'cellspacing' => 0,
                'cellpadding' => 1,
                'border' => 1,
            ]));

            $factory->addHeader('Metric')->addHeader('Current')->addHeader('Previous')->addHeader('Delta');
            $factory->addRow()->addCell('Revenue')->addCell('$138,000')->addCell('$125,000')->addCell('+10%');
            $factory->addRow()->addCell('Users')->addCell('12,400')->addCell('11,900')->addCell('+4%');

            return [$factory, ['Metric', 'Current', 'Previous', 'Delta', 'Revenue', 'Users', 'cellspacing="0"', 'cellpadding="1"', 'border="1"']];
        }
    ];

    foreach ($cases as $label => $builder) {
        [$factory, $expected] = $builder();
        $payload = $makePayload($factory);
        $decoded = json_decode($payload, true);
        $haystack = is_array($decoded) ? implode("\n", $collectStrings($decoded)) : $payload;
        echo '-- ' . $label . ' compileAsArray() --' . PHP_EOL;
        var_dump($payload);
        $assert(is_string($payload) && $payload !== '', $label . ' compileAsArray() must return rendered markup payload.');
        foreach ($expected as $fragment) {
            $assert(str_contains($haystack, $fragment), $label . ' missing fragment: ' . $fragment . ' in ' . $haystack);
        }
    }

    echo 'PASS assertions' . PHP_EOL;
    #endregion

} catch (Throwable $e) {

    #region Error Handling

    // Agent or Human:
    //
    // Emit error diagnostic messages - customize after generation
    //

    echo 'ERROR_CLASS: ' . get_class($e) . PHP_EOL;
    echo 'ERROR_MESSAGE: ' . $e->getMessage() . PHP_EOL;
    echo 'ERROR_FILE: ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    echo 'ERROR_TRACE:' . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
    exit(1);

    #endregion
}