<?php

namespace BreakdanceCustomElements;

use Breakdance\Forms\Actions\ActionProvider;
use function Breakdance\Elements\c;
use function Breakdance\Elements\control;
use function Breakdance\Elements\controlSection;
use function Breakdance\Elements\PresetSections\getPresetSection;

\Breakdance\ElementStudio\registerElementForEditing(
    'BreakdanceCustomElements\\FormBuilder2',
    \Breakdance\Util\getDirectoryPathRelativeToPluginFolder(__DIR__)
);

class FormBuilder2 extends \Breakdance\Elements\Element
{
    static function uiIcon()
    {
        return 'EnvelopeIcon';
    }

    static function tag()
    {
        return 'div';
    }

    static function name()
    {
        return 'Form Builder 2';
    }

    static function slug()
    {
        return __CLASS__;
    }

    static function className()
    {
        return 'bde-form-builder-2';
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

    static function designControls()
    {
        return [
            getPresetSection('EssentialElements\\form-container', 'Container', 'container', ['type' => 'popout']),
            getPresetSection('EssentialElements\\AtomV1FormDesign', 'Form', 'form', ['type' => 'popout']),
            controlSection('layout', 'Layout', [
                control('layout', 'Layout', [
                    'type' => 'button_bar',
                    'layout' => 'inline',
                    'items' => [
                        ['value' => 'vertical', 'text' => 'Vertical'],
                        ['value' => 'horizontal', 'text' => 'Horizontal'],
                    ],
                ]),
                control('vertical_at', 'Vertical at', ['type' => 'breakpoint_dropdown', 'layout' => 'inline']),
            ]),
            getPresetSection('EssentialElements\\spacing_margin_y', 'Spacing', 'spacing', ['type' => 'popout']),
        ];
    }

    static function contentControls()
    {
        $actionProvider = ActionProvider::getInstance();
        $fields = \Breakdance\Forms\fieldTypes();
        $fieldItems = \Breakdance\Subscription\getFieldItemsWithProLabelForProOnlyFields($fields);
        $proFieldTypes = \Breakdance\Subscription\getProOnlyFieldTypes();

        return [
            controlSection('form', 'Form', [
                control('form_name', 'Form Name', ['type' => 'text']),
                \Breakdance\Elements\repeaterControl('fields', 'Fields', array_merge([
                    c(
                        'pro_field_notice',
                        'Pro field notice',
                        [],
                        [
                            'type' => 'pro_only_alert_box',
                            'layout' => 'vertical',
                            'condition' => [
                                'path' => '%%CURRENTPATH%%.type',
                                'operand' => 'is one of',
                                'value' => $proFieldTypes,
                            ],
                            'alertBoxOptions' => [
                                'style' => 'warning',
                                'content' => '<p>This field type requires Breakdance Pro.</p>',
                            ],
                        ],
                        false,
                        false,
                        []
                    ),
                    control('type', 'Type', ['type' => 'dropdown', 'layout' => 'vertical', 'items' => $fieldItems]),
                    control('label', 'Label', ['type' => 'text', 'layout' => 'vertical']),
                ], self::fieldTypeControls(), [
                    controlSection('advanced', 'Field Settings', [
                        control('id', 'Field ID / Name', [
                            'type' => 'text',
                            'condition' => ['path' => '%%CURRENTPATH%%.type', 'operand' => 'is none of', 'value' => ['html', 'step']],
                        ]),
                        control('value', 'Default Value', [
                            'type' => 'text',
                            'layout' => 'vertical',
                            'condition' => ['path' => '%%PARENTPATH%%.type', 'operand' => 'is none of', 'value' => ['radio', 'checkbox', 'select', 'html', 'date', 'time', 'number', 'file', 'step']],
                        ]),
                        control('value', 'Default Value', [
                            'type' => 'number',
                            'condition' => ['path' => '%%PARENTPATH%%.type', 'operand' => 'equals', 'value' => 'number'],
                        ]),
                        control('value', 'Default Value', [
                            'type' => 'date_picker',
                            'condition' => ['path' => '%%PARENTPATH%%.type', 'operand' => 'equals', 'value' => 'date'],
                        ]),
                        control('value', 'Default Value', [
                            'type' => 'time_picker',
                            'condition' => ['path' => '%%PARENTPATH%%.type', 'operand' => 'equals', 'value' => 'time'],
                        ]),
                        control('placeholder', 'Placeholder', [
                            'type' => 'text',
                            'layout' => 'vertical',
                            'condition' => ['path' => '%%PARENTPATH%%.type', 'operand' => 'is none of', 'value' => ['radio', 'checkbox', 'hidden', 'date', 'time', 'file', 'html', 'step']],
                        ]),
                        control('required', 'Required', [
                            'type' => 'toggle',
                            'condition' => ['path' => '%%PARENTPATH%%.type', 'operand' => 'is none of', 'value' => ['hidden', 'html', 'step']],
                        ]),
                        control('width', 'Width (columns)', ['type' => 'number', 'rangeOptions' => ['step' => 1, 'min' => 1, 'max' => 12]]),
                        control('hide_label', 'Hide Label', ['type' => 'toggle']),
                        control('autocomplete', 'Autocomplete', [
                            'type' => 'text',
                            'condition' => ['path' => '%%PARENTPATH%%.type', 'operand' => 'is none of', 'value' => ['radio', 'checkbox', 'hidden', 'html', 'step']],
                        ]),
                        control('mask', 'Input Mask', [
                            'type' => 'text',
                            'condition' => ['path' => '%%PARENTPATH%%.type', 'operand' => 'equals', 'value' => 'text'],
                        ]),
                        control('conditional', 'Conditional Display', ['type' => 'toggle']),
                        control('condition', 'Display Condition', [
                            'type' => 'conditional_form_field',
                            'layout' => 'vertical',
                            'noLabel' => true,
                            'dropdownOptions' => [
                                'populate' => [
                                    'path' => 'content.form.fields',
                                    'text' => 'label',
                                    'value' => 'advanced.id',
                                    'condition' => [
                                        'path' => 'advanced.id',
                                        'operand' => 'not equals',
                                        'value' => 'advanced.id',
                                    ],
                                ],
                            ],
                            'condition' => ['path' => '%%CURRENTPATH%%.conditional', 'operand' => 'equals', 'value' => true],
                        ]),
                    ], ['condition' => ['path' => '%%CURRENTPATH%%.type', 'operand' => 'is none of', 'value' => ['step']]], 'popout'),
                ]), [
                    'repeaterOptions' => [
                        'titleTemplate' => '{label}',
                        'defaultTitle' => 'Field',
                        'buttonName' => 'Add Field',
                        'defaultNewValue' => ['type' => 'text', 'label' => 'New field', 'advanced' => ['id' => '{random_string}']],
                        'duplicateNewValue' => ['advanced' => ['id' => '{random_string}']],
                    ],
                ]),
                control('submit_text', 'Submit Button Text', ['type' => 'text']),
                control('success_message', 'Success Message', ['type' => 'text']),
                control('error_message', 'Error Message', ['type' => 'text']),
                control('hide_on_success', 'Hide Form on Success', ['type' => 'toggle']),
                control('redirect', 'Redirect After Submit', ['type' => 'toggle']),
                control('redirect_url', 'Redirect URL', [
                    'type' => 'url',
                    'condition' => ['path' => 'content.form.redirect', 'operand' => 'equals', 'value' => true],
                ]),
            ]),
            controlSection('actions', 'Submission Actions', array_merge([
                control('actions', 'Actions After Submission', [
                    'type' => 'multiselect',
                    'layout' => 'vertical',
                    'placeholder' => 'No action selected',
                    'items' => \Breakdance\Subscription\getActionItemsWithProAppendedToProOnlyActions($actionProvider->getActions()),
                ]),
            ], $actionProvider->getControls())),
            controlSection('advanced', 'Advanced', [
                control('form_id', 'Form HTML ID', ['type' => 'text']),
                control('submit_button_id', 'Submit Button HTML ID', ['type' => 'text']),
                control('honeypot_enabled', 'Add Honeypot Field', ['type' => 'toggle']),
                control('csrf_enabled', 'Enable CSRF Protection', ['type' => 'toggle']),
                \Breakdance\Forms\Recaptcha\controls(),
            ]),
        ];
    }

    private static function fieldTypeControls()
    {
        $choiceTypes = ['radio', 'checkbox', 'select'];
        $groups = [
            \Breakdance\Elements\repeaterControl('options', 'Options', [
                    control('label', 'Option Label', ['type' => 'text']),
                    control('value', 'Option Value', ['type' => 'text']),
                    control('selected', 'Selected by Default', ['type' => 'toggle']),
                ], [
                    'condition' => self::fieldTypeCondition($choiceTypes),
                    'repeaterOptions' => ['titleTemplate' => '{label}', 'defaultTitle' => 'Option', 'buttonName' => 'Add option'],
                ]),
            self::fieldTypeControl('multiple', 'Allow Multiple Selections', ['type' => 'toggle'], ['select']),
            self::fieldTypeControl('rows_select', 'Visible Rows', ['type' => 'number'], ['select']),
            self::fieldTypeControl('min', 'Minimum', ['type' => 'number'], ['number']),
            self::fieldTypeControl('max', 'Maximum', ['type' => 'number'], ['number']),
            self::fieldTypeControl('step', 'Step', ['type' => 'number'], ['number']),
            self::fieldTypeControl('rows_textarea', 'Rows', ['type' => 'number'], ['textarea']),
            self::fieldTypeControl('min_date', 'Minimum Date', ['type' => 'text', 'placeholder' => 'yyyy-mm-dd'], ['date']),
            self::fieldTypeControl('max_date', 'Maximum Date', ['type' => 'text', 'placeholder' => 'yyyy-mm-dd'], ['date']),
            self::fieldTypeControl('max_file_size', 'Max File Size (MB)', ['type' => 'number'], ['file']),
            self::fieldTypeControl('max_number_of_files', 'Max Number of Files', ['type' => 'number'], ['file']),
            self::fieldTypeControl('allowed_file_types', 'Allowed File Types', [
                    'type' => 'multiselect',
                    'layout' => 'vertical',
                    'searchable' => true,
                    'items' => array_map(static function ($mimeType, $extensions) {
                        return ['text' => str_replace('|', ', ', $extensions), 'value' => $mimeType];
                    }, array_values(get_allowed_mime_types()), array_keys(get_allowed_mime_types())),
                ], ['file']),
            self::fieldTypeControl('drag_and_drop', 'Drag and Drop', ['type' => 'toggle'], ['file']),
            self::fieldTypeControl('html', 'Custom HTML', ['type' => 'code', 'layout' => 'vertical', 'codeOptions' => ['language' => 'html']], ['html']),
            self::fieldTypeControl('previous_button_text', 'Previous Button Text', ['type' => 'text'], ['step']),
            self::fieldTypeControl('next_button_text', 'Next Button Text', ['type' => 'text'], ['step']),
        ];

        return $groups;
    }

    private static function fieldTypeControl($name, $label, $options, $types)
    {
        $options['condition'] = self::fieldTypeCondition($types);
        return control($name, $label, $options);
    }

    private static function fieldTypeCondition($types)
    {
        return [
            'path' => '%%CURRENTPATH%%.type',
            'operand' => 'is one of',
            'value' => $types,
        ];
    }

    static function defaultProperties()
    {
        $currentUser = wp_get_current_user();

        return [
            'content' => [
                'form' => [
                    'form_name' => 'Contact Form',
                    'fields' => [
                        ['type' => 'text', 'label' => 'Name', 'advanced' => ['required' => true, 'id' => 'name']],
                        ['type' => 'email', 'label' => 'Email', 'advanced' => ['required' => true, 'id' => 'email']],
                        ['type' => 'textarea', 'label' => 'Message', 'advanced' => ['required' => true, 'id' => 'message']],
                    ],
                    'submit_text' => 'Submit',
                    'success_message' => 'Your message has been received!',
                    'error_message' => 'Something went wrong',
                ],
                'actions' => [
                    'actions' => ['email', 'store_submission'],
                    'store_submission' => ['submission_title' => '{email}', 'store_files' => true],
                    'email' => ['emails' => [[
                        'message' => '{all_fields}',
                        'subject' => 'New contact form message',
                        'from' => get_option('admin_email'),
                        'from_name' => '{name}',
                        'reply_to' => '{email}',
                        'to' => $currentUser->user_email,
                    ]]],
                ],
            ],
            'design' => ['form' => ['theme' => 'default']],
        ];
    }

    static function dynamicPropertyPaths()
    {
        return [
            ['accepts' => 'string', 'path' => 'content.form.fields[].advanced.value'],
            ['accepts' => 'string', 'path' => 'content.form.fields[].min_date'],
            ['accepts' => 'string', 'path' => 'content.form.fields[].max_date'],
        ];
    }

    static function nestingRule()
    {
        return ['type' => 'final'];
    }

    static function dependencies()
    {
        return \Breakdance\Forms\getAjaxDependencies();
    }

    static function propertyPathsToSsrElementWhenValueChanges()
    {
        return ['content.form.fields', 'content.advanced', 'design.layout', 'content.form.submit_text'];
    }

    static function actions()
    {
        return [
            'onMountedElement' => [[
                'script' => "const form = document.querySelector('%%SELECTOR%% .breakdance-form'); breakdanceForm.initConditionalFields(form, true); breakdanceForm.initSteps(form, true); breakdanceForm.initMask(form, '%%SELECTOR%%');",
            ]],
            'onBeforeDeletingElement' => [[
                'script' => "breakdanceForm.destroy('%%SELECTOR%%');",
            ]],
        ];
    }

    static function availableIn()
    {
        return ['oxygen'];
    }

    static function category()
    {
        return 'breakdance-custom-elements';
    }
}