<?php

\Breakdance\Forms\registerForm([
    'slug' => 'custom2',
    'args' => [
        'post_id' => ['filter' => FILTER_VALIDATE_INT],
        'form_id' => ['filter' => FILTER_VALIDATE_INT],
        'fields' => ['filter' => FILTER_DEFAULT, 'flags' => FILTER_REQUIRE_ARRAY],
    ],
    'optional_args' => ['fields'],
    'handler' => static function ($post_id, $form_id, $fields) {
        return \Breakdance\Forms\handleSubmission($post_id, $form_id, $fields ?? []);
    },
]);