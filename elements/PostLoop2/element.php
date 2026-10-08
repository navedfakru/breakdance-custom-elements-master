<?php

namespace BreakdanceCustomElements;

use function Breakdance\Elements\control;
use function Breakdance\Elements\controlSection;
use function Breakdance\Elements\PresetSections\getPresetSection;

\Breakdance\ElementStudio\registerElementForEditing(
    'BreakdanceCustomElements\\PostLoop2',
    \Breakdance\Util\getDirectoryPathRelativeToPluginFolder(__DIR__)
);

/**
 * Post Loop 2 — one element, like Breakdance's Post Loop:
 * query + repeated Global Block (items grid) + pagination + AJAX.
 *
 * Output:
 *   <div class="bde-post-loop-2">
 *     <div class="bde-pl2-items">…items…</div>
 *     <nav class="bde-pl2-pagination">…</nav>
 *   </div>
 * The pagination is always a sibling of the items grid, never inside it.
 */
class PostLoop2 extends \Breakdance\Elements\Element
{
    static function uiIcon()
    {
        return 'DatabaseIcon';
    }

    static function tag()
    {
        return 'div';
    }

    static function tagOptions()
    {
        return ['div', 'section'];
    }

    static function tagControlPath()
    {
        return false;
    }

    static function name()
    {
        return 'Post Loop 2';
    }

    static function className()
    {
        return 'bde-post-loop-2';
    }

    static function category()
    {
        return 'breakdance-custom-elements';
    }

    static function badge()
    {
        return false;
    }

    static function slug()
    {
        return __CLASS__;
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
                'query' => ['query' => [
                    'active' => 'custom',
                    'custom' => [
                        'source' => 'post_types',
                        'postTypes' => ['post'],
                        'postsPerPage' => 6,
                        'orderBy' => 'date',
                        'order' => 'DESC',
                    ],
                ]],
                'items' => [
                    'item_tag' => '',
                    'empty_message' => 'No posts found.',
                ],
                'pagination' => [
                    'type' => 'numbers_prev_next',
                    'prev_next_display' => 'icon_text',
                    'prev_text' => 'Previous',
                    'next_text' => 'Next',
                    'load_more_text' => 'Load more',
                    'loading_text' => 'Loading…',
                    'mid_size' => 1,
                    'show_disabled' => true,
                ],
                'ajax' => [
                    'enable' => true,
                    'update_url' => true,
                    'scroll_to_top' => true,
                    'scroll_offset' => 100,
                    'prefetch' => true,
                ],
            ],
            'design' => [
                'items' => [
                    'display' => 'grid',
                    'columns' => [
                        'breakpoint_base' => 3,
                        'breakpoint_tablet_portrait' => 2,
                        'breakpoint_phone_portrait' => 1,
                    ],
                    'gap' => ['breakpoint_base' => ['number' => 24, 'unit' => 'px', 'style' => '24px']],
                ],
                'pagination' => [
                    'justify' => 'center',
                    'spacing' => ['breakpoint_base' => ['number' => 32, 'unit' => 'px', 'style' => '32px']],
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
        $hasPagination = ['path' => 'content.pagination.type', 'operand' => 'not equals', 'value' => 'none'];
        $isNumbers = ['path' => 'content.pagination.type', 'operand' => 'is one of', 'value' => ['numbers', 'numbers_prev_next']];
        $hasPrevNext = ['path' => 'content.pagination.type', 'operand' => 'is one of', 'value' => ['prev_next', 'numbers_prev_next']];
        $isLoadMore = ['path' => 'content.pagination.type', 'operand' => 'equals', 'value' => 'load_more'];
        $hasIcons = ['path' => 'content.pagination.prev_next_display', 'operand' => 'is one of', 'value' => ['icon', 'icon_text']];
        $ajaxOn = ['path' => 'content.ajax.enable', 'operand' => 'equals', 'value' => true];

        return [
            controlSection('query', 'Query', [
                control('query', 'Query', ['type' => 'wp_query', 'layout' => 'vertical']),
            ]),
            controlSection('items', 'Repeated Block', [
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
            controlSection('pagination', 'Pagination', [
                control('type', 'Type', [
                    'type' => 'dropdown',
                    'layout' => 'vertical',
                    'items' => [
                        ['value' => 'numbers_prev_next', 'text' => 'Numbers + Prev/Next'],
                        ['value' => 'numbers', 'text' => 'Numbers'],
                        ['value' => 'prev_next', 'text' => 'Prev/Next'],
                        ['value' => 'load_more', 'text' => 'Load More Button'],
                        ['value' => 'none', 'text' => 'None'],
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
                control('prev_icon', 'Previous Icon', ['type' => 'icon', 'layout' => 'vertical', 'condition' => [[$hasPrevNext, $hasIcons]]]),
                control('next_icon', 'Next Icon', ['type' => 'icon', 'layout' => 'vertical', 'condition' => [[$hasPrevNext, $hasIcons]]]),
                control('show_disabled', 'Show Disabled Prev/Next', ['type' => 'toggle', 'layout' => 'inline', 'condition' => $hasPrevNext]),
                control('mid_size', 'Pages Around Current', [
                    'type' => 'number',
                    'layout' => 'inline',
                    'rangeOptions' => ['min' => 0, 'max' => 5, 'step' => 1],
                    'condition' => $isNumbers,
                ]),
                control('show_all', 'Show All Page Numbers', ['type' => 'toggle', 'layout' => 'inline', 'condition' => $isNumbers]),
                control('show_page_info', 'Show "Page X of Y"', ['type' => 'toggle', 'layout' => 'inline', 'condition' => $hasPagination]),
                control('load_more_text', 'Button Text', ['type' => 'text', 'layout' => 'vertical', 'condition' => $isLoadMore]),
                control('loading_text', 'Loading Text', ['type' => 'text', 'layout' => 'vertical', 'condition' => $isLoadMore]),
            ]),
            controlSection('ajax', 'AJAX', [
                control('enable', 'Load Pages With AJAX', ['type' => 'toggle', 'layout' => 'inline']),
                control('update_url', 'Update Browser URL', ['type' => 'toggle', 'layout' => 'inline', 'condition' => $ajaxOn]),
                control('scroll_to_top', 'Scroll To Loop Top', ['type' => 'toggle', 'layout' => 'inline', 'condition' => $ajaxOn]),
                control('scroll_offset', 'Scroll Offset (px)', [
                    'type' => 'number',
                    'layout' => 'inline',
                    'rangeOptions' => ['min' => 0, 'max' => 400, 'step' => 1],
                    'condition' => ['path' => 'content.ajax.scroll_to_top', 'operand' => 'equals', 'value' => true],
                ]),
                control('prefetch', 'Prefetch On Hover', ['type' => 'toggle', 'layout' => 'inline', 'condition' => $ajaxOn]),
            ]),
        ];
    }

    static function designControls()
    {
        $isGrid = ['path' => 'design.items.display', 'operand' => 'equals', 'value' => 'grid'];

        return [
            controlSection('items', 'Items Layout', [
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
                    'condition' => $isGrid,
                ], true),
                control('min_item_width', 'Auto-fit Min Item Width', ['type' => 'unit', 'layout' => 'inline', 'condition' => $isGrid], true),
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
            controlSection('pagination', 'Pagination', [
                control('spacing', 'Space Above Pagination', ['type' => 'unit', 'layout' => 'inline'], true),
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
                controlSection('links', 'Buttons', [
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
                ], null, 'popout'),
                controlSection('hover', 'Buttons Hover', [
                    control('color', 'Text', ['type' => 'color', 'layout' => 'inline']),
                    control('background', 'Background', ['type' => 'color', 'layout' => 'inline']),
                    control('border_color', 'Border', ['type' => 'color', 'layout' => 'inline']),
                ], null, 'popout'),
                controlSection('active', 'Current Page', [
                    control('color', 'Text', ['type' => 'color', 'layout' => 'inline']),
                    control('background', 'Background', ['type' => 'color', 'layout' => 'inline']),
                    control('border_color', 'Border', ['type' => 'color', 'layout' => 'inline']),
                ], null, 'popout'),
            ]),
            controlSection('loading', 'Loading State', [
                control('opacity', 'Items Opacity While Loading', [
                    'type' => 'number',
                    'layout' => 'inline',
                    'rangeOptions' => ['min' => 0, 'max' => 1, 'step' => 0.05],
                ]),
            ]),
            getPresetSection('EssentialElements\\spacing_margin_y', 'Spacing', 'spacing', ['type' => 'popout']),
        ];
    }

    static function settingsControls()
    {
        return [];
    }

    static function dependencies()
    {
        return [
            [
                'scripts' => [plugins_url('post-loop-2.js', __FILE__) . '?ver=1.1.0'],
                'inlineScripts' => ["window.BdePostLoop2 && window.BdePostLoop2.init('%%SELECTOR%%');"],
                'builderCondition' => 'return false;',
                'frontendCondition' => "return {{ content.ajax.enable ? 'true' : 'false' }};",
                'title' => 'Post Loop 2 - AJAX',
            ],
        ];
    }

    static function attributes()
    {
        return [
            ['name' => 'data-pl2-ajax', 'template' => "{{ content.ajax.enable ? '1' : '0' }}"],
            ['name' => 'data-pl2-url', 'template' => "{{ content.ajax.update_url ? '1' : '0' }}"],
            ['name' => 'data-pl2-scroll', 'template' => "{{ content.ajax.scroll_to_top ? (content.ajax.scroll_offset is defined ? content.ajax.scroll_offset : 100) : '' }}"],
            ['name' => 'data-pl2-prefetch', 'template' => "{{ content.ajax.prefetch ? '1' : '0' }}"],
        ];
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
        return ['type' => 'final'];
    }

    static function spacingBars()
    {
        return false;
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
        return 0;
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
