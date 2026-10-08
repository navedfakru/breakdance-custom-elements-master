<?php

namespace BreakdanceCustomElements\PostLoop2;

const CONTAINER_SLUG = 'BreakdanceCustomElements\\PostLoop2';
const ITEMS_SLUG = 'BreakdanceCustomElements\\PostLoop2Items';
const PAGINATION_SLUG = 'BreakdanceCustomElements\\PostLoop2Pagination';

/**
 * Current page number for the loop. Works for static pages (/page/2/),
 * archives and the "page" query var used by single posts.
 *
 * @return int
 */
function getPaged()
{
    return max(1, (int) get_query_var('paged'), (int) get_query_var('page'));
}

/**
 * Build (once per request) the WP_Query for a Post Loop 2 container.
 * Items and Pagination both call this with the container's properties,
 * so they always share the exact same query.
 *
 * @param array $containerProps The Post Loop 2 properties (shared with SSR children).
 * @return \WP_Query
 */
function getQuery($containerProps)
{
    static $cache = [];

    $queryProps = $containerProps['content']['query']['query'] ?? null;
    $paged = getPaged();
    $key = md5(wp_json_encode($queryProps) . '|' . $paged);

    if (!isset($cache[$key])) {
        $args = \Breakdance\WpQueryControl\getWpQueryArgumentsFromWpQueryControlProperties(
            $queryProps,
            ['paged' => $paged > 1 ? $paged : null]
        );

        $cache[$key] = new \WP_Query($args);
    }

    $cache[$key]->rewind_posts();

    return $cache[$key];
}

/**
 * Whether this render is the builder's server side render (not the frontend).
 *
 * @return bool
 */
function isBuilder()
{
    return function_exists('\Breakdance\isRequestFromBuilderSsr') && \Breakdance\isRequestFromBuilderSsr();
}

/**
 * Message shown only inside the builder.
 *
 * @param string $message
 * @return string
 */
function builderMessage($message)
{
    return isBuilder()
        ? '<div class="breakdance-empty-ssr-message">' . esc_html($message) . '</div>'
        : '';
}

/**
 * Link for a given page of the loop. In the builder there is no real URL to point at.
 *
 * @param int $page
 * @return string
 */
function pageLink($page)
{
    return isBuilder() ? '#' : get_pagenum_link($page);
}

/**
 * Page numbers to show: always first + last, current +/- $midSize, "…" for gaps.
 *
 * @param int $current
 * @param int $max
 * @param int $midSize
 * @param bool $showAll
 * @return array<int|string> Page numbers and '…' markers.
 */
function pageNumbers($current, $max, $midSize, $showAll)
{
    if ($showAll) {
        return range(1, $max);
    }

    $pages = [];

    for ($i = 1; $i <= $max; $i++) {
        $isEdge = $i === 1 || $i === $max;
        $isNearCurrent = abs($i - $current) <= $midSize;

        if ($isEdge || $isNearCurrent) {
            $pages[] = $i;
        } elseif (end($pages) !== '…') {
            $pages[] = '…';
        }
    }

    return $pages;
}
