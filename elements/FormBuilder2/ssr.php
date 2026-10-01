<?php

/** @var array $propertiesData */

use BreakdanceCustomElements\FormBuilder2 as FB2;

$content = $propertiesData['content'] ?? [];
$options = \Breakdance\Forms\Render\getFormOptions(FB2\AJAX_SLUG, $content);

$formId = trim((string) ($content['advanced']['form_id'] ?? ''));
if ($formId === '') {
    $formId = (sanitize_title($content['form']['form_name'] ?? '') ?: 'form-builder-2') . '-%%ID%%';
}

$popups = array_merge(
    $content['actions']['popup']['popups_on_success'] ?? [],
    $content['actions']['popup']['popups_on_error'] ?? []
);
foreach ($popups as $popup) {
    if (!empty($popup['popup'])) {
        \Breakdance\Themeless\PopupController::getInstance()->registerPopup($popup['popup']);
    }
}

$extraFields = '';

if (!empty($content['advanced']['honeypot_enabled'])) {
    $extraFields .= \Breakdance\Forms\Render\renderField([
        'type' => 'hpinput',
        'label' => 'HP Name',
        'advanced' => ['id' => 'hpname', 'autocomplete_disabled' => true, 'tabindex' => '-1'],
    ], 0, $content);
}

if (!empty($content['advanced']['csrf_enabled'])) {
    $extraFields .= \Breakdance\Forms\Render\renderField([
        'type' => 'hidden',
        'name' => 'fields[csrfToken]',
        'advanced' => [
            'id' => 'csrf-token-%%ID%%',
            'value' => \Breakdance\AJAX\get_nonce_for_ajax_requests(),
            'autocomplete_disabled' => true,
            'tabindex' => '-1',
        ],
    ], 0, $content);
}
?>
<form id="<?php echo esc_attr($formId); ?>" class="breakdance-form bde-fb2__form" data-options="<?php echo esc_attr(wp_json_encode($options)); ?>" data-steps="0">
%%CHILDREN%%
<?php echo $extraFields; ?>
<input type="hidden" name="form_id" value="%%ID%%">
<input type="hidden" name="post_id" value="%%POSTID%%">
</form>
