<?php

/** @var array $propertiesData */

$field = \BreakdanceCustomElements\FormBuilder2\normalizeField($propertiesData['content']['field'] ?? [], '%%ID%%');

echo \Breakdance\Forms\Render\renderField($field, 0, []);
