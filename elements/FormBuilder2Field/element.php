<?php

namespace BreakdanceCustomElements;

use function Breakdance\Elements\control;
use function Breakdance\Elements\controlSection;
use function Breakdance\Elements\PresetSections\getPresetSection;

\Breakdance\ElementStudio\registerElementForEditing(
    'BreakdanceCustomElements\\FormBuilder2Field',
    \Breakdance\Util\getDirectoryPathRelativeToPluginFolder(__DIR__)
);

/**
 * A single input for Form Builder 2. Can sit anywhere inside the form
 * container (inside columns, divs, etc.). Styled by the parent form's
 * "Form Fields & Button" design.
 */
class FormBuilder2Field extends \Breakdance\Elements\Element
{
    static function uiIcon()
    {
        return 'RectangleWideIcon';
    }

    static function tag()
    {
        return 'div';
    }

    static function tagOptions()
    {
        return [];
    }

    static function tagControlPath()
    {
        return false;
    }

    static function name()
    {
        return 'Form Field';
    }

    static function slug()
    {
        return __CLASS__;
    }

    static function className()
    {
        return 'bdoxce-fb2-field';
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
            controlSection('size', 'Size', [
                control('width', 'Width', ['type' => 'unit', 'layout' => 'inline'], true),
                control('grow', 'Fill Remaining Space (Row)', ['type' => 'toggle', 'layout' => 'inline'], true),
                control('grid_span', 'Grid Column Span', [
                    'type' => 'number',
                    'layout' => 'inline',
                    'rangeOptions' => ['min' => 1, 'max' => 12, 'step' => 1],
                ], true),
            ]),
            getPresetSection('EssentialElements\\spacing_margin_y', 'Spacing', 'spacing', ['type' => 'popout']),
        ];
    }

    static function contentControls()
    {
        $fieldItems = array_values(array_filter(
            \Breakdance\Subscription\getFieldItemsWithProLabelForProOnlyFields(\Breakdance\Forms\fieldTypes()),
            static function ($item) {
                // Multi-step forms need the repeater layout; not supported in the free-layout container.
                return ($item['value'] ?? '') !== 'step';
            }
        ));

        return [
            controlSection('field', 'Field', array_merge([
                control('type', 'Type', ['type' => 'dropdown', 'layout' => 'vertical', 'items' => $fieldItems]),
                control('label', 'Label', ['type' => 'text', 'layout' => 'vertical']),
            ], self::fieldTypeControls(), [
                controlSection('advanced', 'Field Settings', [
                    control('id', 'Field ID / Name', [
                        'type' => 'text',
                        'placeholder' => 'auto: field-{element id}',
                        'condition' => self::typeCondition('is none of', ['html']),
                    ]),
                    control('value', 'Default Value', [
                        'type' => 'text',
                        'layout' => 'vertical',
                        'condition' => self::typeCondition('is none of', ['radio', 'checkbox', 'select', 'html', 'date', 'time', 'number', 'file']),
                    ]),
                    control('value', 'Default Value', ['type' => 'number', 'condition' => self::typeCondition('equals', 'number')]),
                    control('value', 'Default Value', ['type' => 'date_picker', 'condition' => self::typeCondition('equals', 'date')]),
                    control('value', 'Default Value', ['type' => 'time_picker', 'condition' => self::typeCondition('equals', 'time')]),
                    control('placeholder', 'Placeholder', [
                        'type' => 'text',
                        'layout' => 'vertical',
                        'condition' => self::typeCondition('is none of', ['radio', 'checkbox', 'hidden', 'date', 'time', 'file', 'html']),
                    ]),
                    control('required', 'Required', [
                        'type' => 'toggle',
                        'condition' => self::typeCondition('is none of', ['hidden', 'html']),
                    ]),
                    control('hide_label', 'Hide Label', ['type' => 'toggle']),
                    control('autocomplete', 'Autocomplete', [
                        'type' => 'text',
                        'condition' => self::typeCondition('is none of', ['radio', 'checkbox', 'hidden', 'html']),
                    ]),
                    control('mask', 'Input Mask', ['type' => 'text', 'condition' => self::typeCondition('equals', 'text')]),
                    control('conditional', 'Conditional Display', ['type' => 'toggle']),
                    controlSection('condition', 'Show When', [
                        control('field', 'Other Field ID', ['type' => 'text']),
                        control('operand', 'Operator', [
                            'type' => 'dropdown',
                            'items' => array_map(static function ($operand) {
                                return ['value' => $operand, 'text' => ucfirst($operand)];
                            }, [
                                'equals', 'not equals', 'is set', 'is not set', 'is one of', 'is none of',
                                'contains', 'does not contain', 'is greater than', 'is less than',
                                'is before date', 'is after date', 'is before time', 'is after time',
                            ]),
                        ]),
                        control('value', 'Value', ['type' => 'text']),
                    ], [
                        'condition' => ['path' => 'content.field.advanced.conditional', 'operand' => 'equals', 'value' => true],
                    ], 'popout'),
                ], null, 'popout'),
            ])),
        ];
    }

    private static function fieldTypeControls()
    {
        return [
            \Breakdance\Elements\repeaterControl('options', 'Options', [
                control('label', 'Option Label', ['type' => 'text']),
                control('value', 'Option Value', ['type' => 'text']),
                control('selected', 'Selected by Default', ['type' => 'toggle']),
            ], [
                'condition' => self::typeCondition('is one of', ['radio', 'checkbox', 'select']),
                'repeaterOptions' => ['titleTemplate' => '{label}', 'defaultTitle' => 'Option', 'buttonName' => 'Add option'],
            ]),
            self::typeControl('multiple', 'Allow Multiple Selections', ['type' => 'toggle'], ['select']),
            self::typeControl('rows_select', 'Visible Rows', ['type' => 'number'], ['select']),
            self::typeControl('min', 'Minimum', ['type' => 'number'], ['number']),
            self::typeControl('max', 'Maximum', ['type' => 'number'], ['number']),
            self::typeControl('step', 'Step', ['type' => 'number'], ['number']),
            self::typeControl('rows_textarea', 'Rows', ['type' => 'number'], ['textarea']),
            self::typeControl('min_date', 'Minimum Date', ['type' => 'text', 'placeholder' => 'yyyy-mm-dd'], ['date']),
            self::typeControl('max_date', 'Maximum Date', ['type' => 'text', 'placeholder' => 'yyyy-mm-dd'], ['date']),
            self::typeControl('max_file_size', 'Max File Size (MB)', ['type' => 'number'], ['file']),
            self::typeControl('max_number_of_files', 'Max Number of Files', ['type' => 'number'], ['file']),
            self::typeControl('allowed_file_types', 'Allowed File Types', [
                'type' => 'multiselect',
                'layout' => 'vertical',
                'searchable' => true,
                'items' => array_map(static function ($mimeType, $extensions) {
                    return ['text' => str_replace('|', ', ', $extensions), 'value' => $mimeType];
                }, array_values(get_allowed_mime_types()), array_keys(get_allowed_mime_types())),
            ], ['file']),
            self::typeControl('drag_and_drop', 'Drag and Drop', ['type' => 'toggle'], ['file']),
            self::typeControl('html', 'Custom HTML', ['type' => 'code', 'layout' => 'vertical', 'codeOptions' => ['language' => 'html']], ['html']),
        ];
    }

    private static function typeControl($name, $label, $options, $types)
    {
        $options['condition'] = self::typeCondition('is one of', $types);
        return control($name, $label, $options);
    }

    private static function typeCondition($operand, $value)
    {
        return ['path' => 'content.field.type', 'operand' => $operand, 'value' => $value];
    }

    static function settingsControls()
    {
        return [];
    }

    static function defaultProperties()
    {
        return [
            'content' => ['field' => [
                'type' => 'text',
                'label' => 'New field',
                'advanced' => ['required' => false],
            ]],
        ];
    }

    static function defaultChildren()
    {
        return false;
    }

    static function dynamicPropertyPaths()
    {
        return [
            ['accepts' => 'string', 'path' => 'content.field.advanced.value'],
            ['accepts' => 'string', 'path' => 'content.field.min_date'],
            ['accepts' => 'string', 'path' => 'content.field.max_date'],
        ];
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

    static function nestingRule()
    {
        return [
            'type' => 'final',
            'restrictedToBeADescendantOf' => ['BreakdanceCustomElements\\FormBuilder2'],
        ];
    }

    static function spacingBars()
    {
        return false;
    }

    static function attributes()
    {
        return false;
    }

    static function experimental()
    {
        return false;
    }

    static function order()
    {
        return 1;
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

    static function availableIn()
    {
        return ['oxygen'];
    }

    static function category()
    {
        return 'breakdance-custom-elements';
    }
}
