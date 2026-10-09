<?php

namespace BreakdanceCustomElements;

use function Breakdance\Elements\control;
use function Breakdance\Elements\controlSection;

\Breakdance\ElementStudio\registerElementForEditing(
    'BreakdanceCustomElements\\PostLoop2Items',
    \Breakdance\Util\getDirectoryPathRelativeToPluginFolder(__DIR__)
);

/**
 * Loop Items for Post Loop 2: repeats a Global Block for every post of the
 * parent loop's query. Items are output directly inside this element
 * (no extra wrappers), and this element is the grid.
 */
class PostLoop2Items extends \Breakdance\Elements\Element
{
    static function uiIcon()
    {
        return 'GridIcon';
    }

    static function tag()
    {
        return 'div';
    }

    static function tagOptions()
    {
        return ['div', 'ul', 'ol', 'section'];
    }

    static function tagControlPath()
    {
        return false;
    }

    static function name()
    {
        return 'Loop Items';
    }

    static function slug()
    {
        return __CLASS__;
    }

    static function className()
    {
        return 'bdoxce-pl2-items';
    }

    static function category()
    {
        return 'breakdance-custom-elements';
    }

    static function badge()
    {
        return false;
    }

    static function template()
    {
        return file_get_contents(__DIR__ . '/html.twig');
    }

    static function defaultCss()
    {
        return file_get_contents(__DIR__ . '/default.css');
    }

    static function cssTemplate()
    {
        return file_get_contents(__DIR__ . '/css.twig');
    }

    static function defaultProperties()
    {
        return [
            'content' => [
                'items' => [
                    'item_tag' => '',
                    'empty_message' => 'No posts found.',
                ],
            ],
            'design' => [
                'layout' => [
                    'display' => 'grid',
                    'columns' => [
                        'breakpoint_base' => 3,
                        'breakpoint_tablet_portrait' => 2,
                        'breakpoint_phone_portrait' => 1,
                    ],
                    'gap' => ['breakpoint_base' => ['number' => 24, 'unit' => 'px', 'style' => '24px']],
                ],
            ],
        ];
    }

    static function defaultChildren()
    {
        return false;
    }

    static function contentControls()
    {
        return [
            controlSection('items', 'Items', [
                control('global_block', 'Global Block', ['type' => 'global_block_chooser', 'layout' => 'vertical']),
                control('item_tag', 'Item Wrapper', [
                    'type' => 'dropdown',
                    'layout' => 'vertical',
                    'items' => [
                        ['value' => '', 'text' => 'None (Global Block only)'],
                        ['value' => 'div', 'text' => 'div'],
                        ['value' => 'article', 'text' => 'article'],
                        ['value' => 'li', 'text' => 'li'],
                    ],
                ]),
                control('empty_message', 'No Results Message', ['type' => 'text', 'layout' => 'vertical']),
                control('empty_block', 'No Results Global Block', ['type' => 'global_block_chooser', 'layout' => 'vertical']),
            ]),
        ];
    }

    static function designControls()
    {
        return [
            controlSection('layout', 'Layout', [
                control('display', 'Display', [
                    'type' => 'button_bar',
                    'layout' => 'vertical',
                    'items' => [
                        ['value' => 'grid', 'text' => 'Grid'],
                        ['value' => 'list', 'text' => 'List'],
                    ],
                ]),
                control('columns', 'Columns', [
                    'type' => 'number',
                    'layout' => 'inline',
                    'rangeOptions' => ['min' => 1, 'max' => 12, 'step' => 1],
                    'condition' => ['path' => 'design.layout.display', 'operand' => 'equals', 'value' => 'grid'],
                ], true),
                control('min_item_width', 'Auto-fit Min Item Width', [
                    'type' => 'unit',
                    'layout' => 'inline',
                    'condition' => ['path' => 'design.layout.display', 'operand' => 'equals', 'value' => 'grid'],
                ], true),
                control('gap', 'Gap', ['type' => 'unit', 'layout' => 'inline'], true),
                control('align_items', 'Align Items', [
                    'type' => 'dropdown',
                    'layout' => 'inline',
                    'items' => [
                        ['value' => 'stretch', 'text' => 'Stretch (equal height)'],
                        ['value' => 'start', 'text' => 'Start'],
                        ['value' => 'center', 'text' => 'Center'],
                        ['value' => 'end', 'text' => 'End'],
                    ],
                ]),
            ]),
        ];
    }

    static function settingsControls()
    {
        return [];
    }

    static function dependencies()
    {
        return false;
    }

    static function settings()
    {
        return false;
    }

    static function addPanelRules()
    {
        return false;
    }

    static public function actions()
    {
        return false;
    }

    static function nestingRule()
    {
        return [
            'type' => 'final',
            'restrictedToBeADescendantOf' => ['BreakdanceCustomElements\\PostLoop2'],
        ];
    }

    static function spacingBars()
    {
        return false;
    }

    static function attributes()
    {
        return [
            ['name' => 'aria-live', 'template' => 'polite'],
        ];
    }

    static function experimental()
    {
        return false;
    }

    static function availableIn()
    {
        return ['breakdance', 'oxygen'];
    }

    static function order()
    {
        return 1;
    }

    static function dynamicPropertyPaths()
    {
        return false;
    }

    static function additionalClasses()
    {
        return false;
    }

    static function projectManagement()
    {
        return false;
    }

    static function propertyPathsToWhitelistInFlatProps()
    {
        return false;
    }

    static function propertyPathsToSsrElementWhenValueChanges()
    {
        return ['content'];
    }
}
