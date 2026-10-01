<?php

namespace BreakdanceCustomElements\FormBuilder2;

const CONTAINER_SLUG = 'BreakdanceCustomElements\\FormBuilder2';
const FIELD_SLUG = 'BreakdanceCustomElements\\FormBuilder2Field';
const AJAX_SLUG = 'fb2_container';

/**
 * Turn a Form Field element's `content.field` props into the StoredFormField
 * shape Breakdance's renderer and submission pipeline expect.
 *
 * @param array $field
 * @param string|int $nodeId Used for the fallback field ID ("%%ID%%" while rendering, the real node ID on submit).
 * @return array
 */
function normalizeField($field, $nodeId)
{
    $field = is_array($field) ? $field : [];
    $field['type'] = $field['type'] ?? 'text';
    $field['label'] = $field['label'] ?? '';
    $field['advanced'] = is_array($field['advanced'] ?? null) ? $field['advanced'] : [];

    $id = trim((string) ($field['advanced']['id'] ?? ''));
    $field['advanced']['id'] = $id !== '' ? $id : 'field-' . $nodeId;

    // The select template reads `rows`, the control is stored as `rows_select`.
    if (isset($field['rows_select'])) {
        $field['rows'] = $field['rows_select'];
    }

    if (empty($field['advanced']['conditional'])) {
        unset($field['advanced']['condition']);
    }

    return $field;
}

/**
 * Walk the form container's subtree and collect every Form Field element,
 * no matter how deeply it is nested (columns, divs, etc.).
 *
 * @param array $children
 * @return array
 */
function collectFields($children)
{
    $fields = [];

    foreach ($children ?: [] as $child) {
        $type = $child['data']['type'] ?? '';

        if ($type === FIELD_SLUG) {
            $fields[] = normalizeField($child['data']['properties']['content']['field'] ?? [], $child['id']);
        }

        // A nested form owns its own fields.
        if ($type !== CONTAINER_SLUG && !empty($child['children'])) {
            $fields = array_merge($fields, collectFields($child['children']));
        }
    }

    return $fields;
}

/**
 * Mirrors \Breakdance\Forms\handleSubmission(), except the field list is
 * built from the container's child elements instead of a repeater.
 *
 * @param int $postId
 * @param int $formId
 * @param array $fields
 * @return array
 */
function handleSubmission($postId, $formId, $fields)
{
    $node = \Breakdance\Render\getNodeById($postId, $formId);

    if (!$node || ($node['data']['type'] ?? '') !== CONTAINER_SLUG) {
        return \Breakdance\Forms\createErrorResponse(__('An unexpected error occurred.', 'breakdance'));
    }

    $settings = $node['data']['properties']['content'] ?? [];
    $settings['form'] = $settings['form'] ?? [];
    $settings['form']['fields'] = collectFields($node['children'] ?? []);

    $metadata = \Breakdance\Forms\extractSubmissionMetadata();
    $hasFullAccess = \Breakdance\Forms\checkUserHasFullAccess();
    $messages = \Breakdance\Forms\extractFormMessages($settings);

    $securityCheck = \Breakdance\Forms\validateSecurityMeasures($settings, $fields, $metadata['ip'], $hasFullAccess, $messages);
    if ($securityCheck !== null) {
        return $securityCheck;
    }

    $actions = \Breakdance\Forms\getFormActions($settings);
    $fieldsAndValues = \Breakdance\Forms\getFormData($settings['form']['fields'], $fields);
    $uploads = \Breakdance\Forms\extractUploadedFiles();

    $validation = \Breakdance\Forms\validateFormData($fieldsAndValues, $uploads, $formId, $postId);
    if (is_wp_error($validation)) {
        return \Breakdance\Forms\createErrorResponse($validation->get_error_message());
    }

    $files = \Breakdance\Forms\handleUploadedFiles($formId, $uploads, $settings);
    $shouldStoreUploadedFiles = $settings['actions']['store_submission']['store_files'] ?? false;

    if (!empty($files) && $shouldStoreUploadedFiles) {
        \Breakdance\Forms\updateFieldValuesWithFileUrls($fieldsAndValues, $fields, $files, $postId, $formId);
    }

    $extra = \Breakdance\Forms\buildFormExtra($formId, $postId, $fields, $uploads, $files, $metadata);
    $response = \Breakdance\Forms\executeActions($actions, [$fieldsAndValues, $settings, $extra]);

    \Breakdance\Forms\handleSubmissionCleanup($response, $files, $shouldStoreUploadedFiles);

    return \Breakdance\Forms\handleSubmissionResponse($response, $messages['success'], $messages['error'], $hasFullAccess);
}
