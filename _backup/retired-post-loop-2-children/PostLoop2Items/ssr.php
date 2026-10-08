<?php

/**
 * @var array $propertiesData
 * @var array $parentPropertiesData Post Loop 2 properties (shared via sharePropsWithSSRChildren).
 */

use function BreakdanceCustomElements\PostLoop2\getQuery;
use function BreakdanceCustomElements\PostLoop2\builderMessage;

$items = $propertiesData['content']['items'] ?? [];
$blockId = (int) ($items['global_block'] ?? 0);
$itemTag = in_array($items['item_tag'] ?? '', ['div', 'article', 'li'], true) ? $items['item_tag'] : '';

if (empty($parentPropertiesData)) {
    echo builderMessage('Loop Items must be placed inside a Post Loop 2 element.');
    return 1; // Breakdance treats a falsy include result as "no ssr.php file".
}

if (!$blockId) {
    echo builderMessage('Choose a Global Block for Loop Items (Content > Items > Global Block).');
    return 1; // Breakdance treats a falsy include result as "no ssr.php file".
}

$query = getQuery($parentPropertiesData);

if (!$query->have_posts()) {
    $emptyBlockId = (int) ($items['empty_block'] ?? 0);

    if ($emptyBlockId) {
        echo \Breakdance\Render\renderGlobalBlock($emptyBlockId);
    } else {
        $message = $items['empty_message'] ?? 'No posts found.';
        echo '<div class="bde-pl2-items__empty">' . esc_html($message) . '</div>';
    }
    return 1; // Breakdance treats a falsy include result as "no ssr.php file".
}

global $post;
$originalPost = $post;

while ($query->have_posts()) {
    $query->the_post();

    $html = \Breakdance\Render\renderGlobalBlock($blockId, get_the_ID());

    if ($itemTag) {
        echo '<' . $itemTag . ' class="bde-pl2-item">' . $html . '</' . $itemTag . '>';
    } else {
        echo $html;
    }
}

wp_reset_postdata();

// Nested loops: restore the outer post if wp_reset_postdata() didn't.
if ($originalPost && get_post() !== $originalPost) {
    $GLOBALS['post'] = $originalPost;
    setup_postdata($originalPost);
}
