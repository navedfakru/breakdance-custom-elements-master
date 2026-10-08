<?php

/**
 * @var array $propertiesData
 * @var array $parentPropertiesData Post Loop 2 properties (shared via sharePropsWithSSRChildren).
 */

use function BreakdanceCustomElements\PostLoop2\getQuery;
use function BreakdanceCustomElements\PostLoop2\getPaged;
use function BreakdanceCustomElements\PostLoop2\pageLink;
use function BreakdanceCustomElements\PostLoop2\pageNumbers;
use function BreakdanceCustomElements\PostLoop2\builderMessage;

if (empty($parentPropertiesData)) {
    echo builderMessage('Loop Pagination must be placed inside a Post Loop 2 element.');
    return 1; // Breakdance treats a falsy include result as "no ssr.php file".
}

$settings = $propertiesData['content']['pagination'] ?? [];
$type = $settings['type'] ?? 'numbers_prev_next';

$query = getQuery($parentPropertiesData);
$max = (int) $query->max_num_pages;
$current = min(getPaged(), max(1, $max));

if ($max <= 1) {
    echo builderMessage('Loop Pagination: all posts fit on one page, so nothing is shown on the frontend.');
    return 1; // Breakdance treats a falsy include result as "no ssr.php file".
}

$showNumbers = in_array($type, ['numbers', 'numbers_prev_next'], true);
$showPrevNext = in_array($type, ['prev_next', 'numbers_prev_next'], true);
$showDisabled = $settings['show_disabled'] ?? true;

/**
 * Prev / Next link, or a disabled placeholder at the first / last page.
 */
$prevNext = function ($direction) use ($current, $max, $settings, $showDisabled) {
    $isPrev = $direction === 'prev';
    $target = $isPrev ? $current - 1 : $current + 1;
    $text = $isPrev ? ($settings['prev_text'] ?? 'Previous') : ($settings['next_text'] ?? 'Next');
    $display = $settings['prev_next_display'] ?? 'text';

    $defaultIcon = $isPrev
        ? '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>'
        : '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>';
    $chosenIcon = $settings[$isPrev ? 'prev_icon' : 'next_icon']['svgCode'] ?? '';
    $icon = '<span class="bde-pl2-pagination__icon" aria-hidden="true">' . ($chosenIcon ?: $defaultIcon) . '</span>';
    $label = '<span class="bde-pl2-pagination__label">' . esc_html($text) . '</span>';

    if ($display === 'icon') {
        $inner = $icon;
    } elseif ($display === 'icon_text') {
        $inner = $isPrev ? $icon . $label : $label . $icon;
    } else {
        $inner = $label;
    }

    $class = 'bde-pl2-pagination__link bde-pl2-pagination__' . $direction . ' is-' . str_replace('_', '-', $display);
    // Icon-only links still need an accessible name.
    $ariaLabel = $display === 'icon' ? ' aria-label="' . esc_attr($isPrev ? 'Previous page' : 'Next page') . '"' : '';

    if ($target < 1 || $target > $max) {
        return $showDisabled
            ? '<span class="' . $class . ' is-disabled" aria-disabled="true"' . $ariaLabel . '>' . $inner . '</span>'
            : '';
    }

    return '<a class="' . $class . '" href="' . esc_url(pageLink($target)) . '" rel="' . $direction . '"' . $ariaLabel . '>' . $inner . '</a>';
};

if ($type === 'load_more') {
    if ($current < $max) {
        printf(
            '<a class="bde-pl2-pagination__loadmore" href="%s" data-pl2-loadmore data-loading-text="%s">%s</a>',
            esc_url(pageLink($current + 1)),
            esc_attr($settings['loading_text'] ?? 'Loading…'),
            esc_html($settings['load_more_text'] ?? 'Load more')
        );
    }
} else {
    if ($showPrevNext) {
        echo $prevNext('prev');
    }

    if ($showNumbers) {
        echo '<ul class="bde-pl2-pagination__list">';

        foreach (pageNumbers($current, $max, (int) ($settings['mid_size'] ?? 1), !empty($settings['show_all'])) as $page) {
            if ($page === '…') {
                echo '<li><span class="bde-pl2-pagination__dots" aria-hidden="true">…</span></li>';
            } elseif ($page === $current) {
                echo '<li><span class="bde-pl2-pagination__link is-current" aria-current="page">' . (int) $page . '</span></li>';
            } else {
                echo '<li><a class="bde-pl2-pagination__link" href="' . esc_url(pageLink($page)) . '" aria-label="Page ' . (int) $page . '">' . (int) $page . '</a></li>';
            }
        }

        echo '</ul>';
    }

    if ($showPrevNext) {
        echo $prevNext('next');
    }
}

if (!empty($settings['show_page_info'])) {
    echo '<span class="bde-pl2-pagination__info">Page ' . (int) $current . ' of ' . (int) $max . '</span>';
}
