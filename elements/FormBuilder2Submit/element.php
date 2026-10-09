<?php

namespace BreakdanceCustomElements;

use function Breakdance\Elements\control;
use function Breakdance\Elements\controlSection;
use function Breakdance\Elements\PresetSections\getPresetSection;

\Breakdance\ElementStudio\registerElementForEditing(
    'BreakdanceCustomElements\\FormBuilder2Submit',
    \Breakdance\Util\getDirectoryPathRelativeToPluginFolder(__DIR__)
);

/**
 * Submit button for Form Builder 2. Place it anywhere inside the form.
 * Its look comes from the parent form's "Form Fields & Button" > Submit Button design.
 */
class FormBuilder2Submit extends \Breakdance\Elements\Element
{
    static function uiIcon()
    {
        return 'SquareIcon';
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
        return 'Form Submit Button';
    }

    static function slug()
    {
        return __CLASS__;
    }

    static function className()
    {
        return 'bdoxce-fb2-submit';
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
            controlSection('layout', 'Layout', [
                control('align', 'Alignment', [
                    'type' => 'button_bar',
                    'layout' => 'vertical',
                    'items' => [
                        ['value' => 'flex-start', 'text' => 'Left'],
                        ['value' => 'center', 'text' => 'Center'],
                        ['value' => 'flex-end', 'text' => 'Right'],
                    ],
                ], true),
                control('full_width', 'Full Width Button', ['type' => 'toggle', 'layout' => 'inline'], true),
                control('width', 'Wrapper Width', ['type' => 'unit', 'layout' => 'inline'], true),
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
        return [
            controlSection('button', 'Button', [
                control('text', 'Text', ['type' => 'text']),
                control('id', 'HTML ID', ['type' => 'text']),
            ]),
        ];
    }

    static function settingsControls()
    {
        return [];
    }

    static function defaultProperties()
    {
        return ['content' => ['button' => ['text' => 'Submit']]];
    }

    static function defaultChildren()
    {
        return false;
    }

    static function dynamicPropertyPaths()
    {
        return [['accepts' => 'string', 'path' => 'content.button.text']];
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
        return 2;
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
        return false;
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
