<?php

/**
 * @var array $propertiesData
 *
 * Note: never use a bare `return;` here — Breakdance treats a falsy include
 * result as "This element doesn't have a ssr.php file".
 */

use function BreakdanceCustomElements\PostLoop2\getQuery;
use function BreakdanceCustomElements\PostLoop2\getPaged;
use function BreakdanceCustomElements\PostLoop2\pageLink;
use function BreakdanceCustomElements\PostLoop2\pageNumbers;
use function BreakdanceCustomElements\PostLoop2\builderMessage;

$content = $propertiesData['content'] ?? [];
$items = $content['items'] ?? [];
$pagination = $content['pagination'] ?? [];

$blockId = (int) ($items['global_block'] ?? 0);
$itemTag = in_array($items['item_tag'] ?? '', ['div', 'article', 'li'], true) ? $items['item_tag'] : '';

if (!$blockId) {
    echo builderMessage('Choose a Global Block (Content > Repeated Block > Global Block).');
    return 1;
}

$query = getQuery($propertiesData);

/* ---------- Items ---------- */

echo '<div class="bde-pl2-items" aria-live="polite">';

if ($query->have_posts()) {
    global $post;
    $originalPost = $post;

    while ($query->have_posts()) {
        $query->the_post();

        $html = \Breakdance\Render\renderGlobalBlock($blockId, get_the_ID());

        echo $itemTag
            ? '<' . $itemTag . ' class="bde-pl2-item">' . $html . '</' . $itemTag . '>'
            : $html;
    }

    wp_reset_postdata();

    // Nested loops: restore the outer post if wp_reset_postdata() didn't.
    if ($originalPost && get_post() !== $originalPost) {
        $GLOBALS['post'] = $originalPost;
        setup_postdata($originalPost);
    }
} else {
    $emptyBlockId = (int) ($items['empty_block'] ?? 0);

    echo $emptyBlockId
        ? \Breakdance\Render\renderGlobalBlock($emptyBlockId)
        : '<div class="bde-pl2-items__empty">' . esc_html($items['empty_message'] ?? 'No posts found.') . '</div>';
}

echo '</div>';

/* ---------- Pagination ---------- */

$type = $pagination['type'] ?? 'numbers_prev_next';
$max = (int) $query->max_num_pages;
$current = min(getPaged(), max(1, $max));

if ($type === 'none' || $max <= 1) {
    return 1;
}

$showNumbers = in_array($type, ['numbers', 'numbers_prev_next'], true);
$showPrevNext = in_array($type, ['prev_next', 'numbers_prev_next'], true);
$showDisabled = $pagination['show_disabled'] ?? true;

/**
 * Prev / Next link (text, icon or icon + text), or a disabled placeholder at the first / last page.
 */
$prevNext = function ($direction) use ($current, $max, $pagination, $showDisabled) {
    $isPrev = $direction === 'prev';
    $target = $isPrev ? $current - 1 : $current + 1;
    $text = $isPrev ? ($pagination['prev_text'] ?? 'Previous') : ($pagination['next_text'] ?? 'Next');
    $display = $pagination['prev_next_display'] ?? 'text';

    $defaultIcon = $isPrev
        ? '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>'
        : '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>';
    $chosenIcon = $pagination[$isPrev ? 'prev_icon' : 'next_icon']['svgCode'] ?? '';
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

echo '<nav class="bde-pl2-pagination" aria-label="Pagination">';

if ($type === 'load_more') {
    if ($current < $max) {
        printf(
            '<a class="bde-pl2-pagination__loadmore" href="%s" data-pl2-loadmore data-loading-text="%s">%s</a>',
            esc_url(pageLink($current + 1)),
            esc_attr($pagination['loading_text'] ?? 'Loading…'),
            esc_html($pagination['load_more_text'] ?? 'Load more')
        );
    }
} else {
    if ($showPrevNext) {
        echo $prevNext('prev');
    }

    if ($showNumbers) {
        echo '<ul class="bde-pl2-pagination__list">';

        foreach (pageNumbers($current, $max, (int) ($pagination['mid_size'] ?? 1), !empty($pagination['show_all'])) as $page) {
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

if (!empty($pagination['show_page_info'])) {
    echo '<span class="bde-pl2-pagination__info">Page ' . (int) $current . ' of ' . (int) $max . '</span>';
}

echo '</nav>';

return 1;
