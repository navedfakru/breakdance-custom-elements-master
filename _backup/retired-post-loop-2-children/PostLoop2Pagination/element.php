<?php

namespace BreakdanceCustomElements;

use function Breakdance\Elements\control;
use function Breakdance\Elements\controlSection;

\Breakdance\ElementStudio\registerElementForEditing(
    'BreakdanceCustomElements\\PostLoop2Pagination',
    \Breakdance\Util\getDirectoryPathRelativeToPluginFolder(__DIR__)
);

/**
 * Loop Pagination for Post Loop 2. Its own element, so it can be placed and
 * styled anywhere inside the loop (never inside the items grid).
 */
class PostLoop2Pagination extends \Breakdance\Elements\Element
{
    static function uiIcon()
    {
        return 'ChevronsRightIcon';
    }

    static function tag()
    {
        return 'nav';
    }

    static function tagOptions()
    {
        return ['nav', 'div'];
    }

    static function tagControlPath()
    {
        return false;
    }

    static function name()
    {
        return 'Loop Pagination';
    }

    static function slug()
    {
        return __CLASS__;
    }

    static function className()
    {
        return 'bdoxce-pl2-pagination';
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
                'pagination' => [
                    'type' => 'numbers_prev_next',
                    'prev_next_display' => 'icon_text',
                    'prev_text' => 'Previous',
                    'next_text' => 'Next',
                    'load_more_text' => 'Load more',
                    'loading_text' => 'Loading…',
                    'mid_size' => 1,
                    'show_disabled' => true,
                    'show_page_info' => false,
                ],
            ],
            'design' => [
                'layout' => ['justify' => 'center'],
            ],
        ];
    }

    static function defaultChildren()
    {
        return false;
    }

    static function contentControls()
    {
        $isNumbers = ['path' => 'content.pagination.type', 'operand' => 'is one of', 'value' => ['numbers', 'numbers_prev_next']];
        $hasPrevNext = ['path' => 'content.pagination.type', 'operand' => 'is one of', 'value' => ['prev_next', 'numbers_prev_next']];
        $isLoadMore = ['path' => 'content.pagination.type', 'operand' => 'equals', 'value' => 'load_more'];

        return [
            controlSection('pagination', 'Pagination', [
                control('type', 'Type', [
                    'type' => 'dropdown',
                    'layout' => 'vertical',
                    'items' => [
                        ['value' => 'numbers_prev_next', 'text' => 'Numbers + Prev/Next'],
                        ['value' => 'numbers', 'text' => 'Numbers'],
                        ['value' => 'prev_next', 'text' => 'Prev/Next'],
                        ['value' => 'load_more', 'text' => 'Load More Button'],
                    ],
                ]),
                control('prev_next_display', 'Prev/Next Display', [
                    'type' => 'button_bar',
                    'layout' => 'vertical',
                    'items' => [
                        ['value' => 'text', 'text' => 'Text'],
                        ['value' => 'icon', 'text' => 'Icon'],
                        ['value' => 'icon_text', 'text' => 'Icon + Text'],
                    ],
                    'condition' => $hasPrevNext,
                ]),
                control('prev_text', 'Previous Text', ['type' => 'text', 'layout' => 'vertical', 'condition' => $hasPrevNext]),
                control('next_text', 'Next Text', ['type' => 'text', 'layout' => 'vertical', 'condition' => $hasPrevNext]),
                control('prev_icon', 'Previous Icon', [
                    'type' => 'icon',
                    'layout' => 'vertical',
                    'condition' => ['path' => 'content.pagination.prev_next_display', 'operand' => 'is one of', 'value' => ['icon', 'icon_text']],
                ]),
                control('next_icon', 'Next Icon', [
                    'type' => 'icon',
                    'layout' => 'vertical',
                    'condition' => ['path' => 'content.pagination.prev_next_display', 'operand' => 'is one of', 'value' => ['icon', 'icon_text']],
                ]),
                control('show_disabled', 'Show Disabled Prev/Next', ['type' => 'toggle', 'layout' => 'inline', 'condition' => $hasPrevNext]),
                control('mid_size', 'Pages Around Current', [
                    'type' => 'number',
                    'layout' => 'inline',
                    'rangeOptions' => ['min' => 0, 'max' => 5, 'step' => 1],
                    'condition' => $isNumbers,
                ]),
                control('show_all', 'Show All Page Numbers', ['type' => 'toggle', 'layout' => 'inline', 'condition' => $isNumbers]),
                control('show_page_info', 'Show "Page X of Y"', ['type' => 'toggle', 'layout' => 'inline']),
                control('load_more_text', 'Button Text', ['type' => 'text', 'layout' => 'vertical', 'condition' => $isLoadMore]),
                control('loading_text', 'Loading Text', ['type' => 'text', 'layout' => 'vertical', 'condition' => $isLoadMore]),
            ]),
        ];
    }

    static function designControls()
    {
        return [
            controlSection('layout', 'Layout', [
                control('justify', 'Alignment', [
                    'type' => 'dropdown',
                    'layout' => 'inline',
                    'items' => [
                        ['value' => 'flex-start', 'text' => 'Start'],
                        ['value' => 'center', 'text' => 'Center'],
                        ['value' => 'flex-end', 'text' => 'End'],
                        ['value' => 'space-between', 'text' => 'Space Between'],
                    ],
                ], true),
                control('gap', 'Gap', ['type' => 'unit', 'layout' => 'inline'], true),
                control('full_width_button', 'Full Width Load More', ['type' => 'toggle', 'layout' => 'inline'], true),
            ]),
            controlSection('links', 'Links', [
                control('size', 'Size (min width/height)', ['type' => 'unit', 'layout' => 'inline'], true),
                control('icon_size', 'Prev/Next Icon Size', ['type' => 'unit', 'layout' => 'inline'], true),
                control('padding_x', 'Horizontal Padding', ['type' => 'unit', 'layout' => 'inline'], true),
                control('font_size', 'Font Size', ['type' => 'unit', 'layout' => 'inline'], true),
                control('font_weight', 'Font Weight', [
                    'type' => 'dropdown',
                    'layout' => 'inline',
                    'items' => [
                        ['value' => '400', 'text' => '400'],
                        ['value' => '500', 'text' => '500'],
                        ['value' => '600', 'text' => '600'],
                        ['value' => '700', 'text' => '700'],
                    ],
                ]),
                control('radius', 'Border Radius', ['type' => 'unit', 'layout' => 'inline']),
                control('border_width', 'Border Width', ['type' => 'unit', 'layout' => 'inline']),
                control('color', 'Text', ['type' => 'color', 'layout' => 'inline']),
                control('background', 'Background', ['type' => 'color', 'layout' => 'inline']),
                control('border_color', 'Border', ['type' => 'color', 'layout' => 'inline']),
            ]),
            controlSection('hover', 'Hover', [
                control('color', 'Text', ['type' => 'color', 'layout' => 'inline']),
                control('background', 'Background', ['type' => 'color', 'layout' => 'inline']),
                control('border_color', 'Border', ['type' => 'color', 'layout' => 'inline']),
            ]),
            controlSection('active', 'Current Page', [
                control('color', 'Text', ['type' => 'color', 'layout' => 'inline']),
                control('background', 'Background', ['type' => 'color', 'layout' => 'inline']),
                control('border_color', 'Border', ['type' => 'color', 'layout' => 'inline']),
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
            ['name' => 'aria-label', 'template' => 'Pagination'],
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
        return 2;
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
