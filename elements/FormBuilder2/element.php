<?php

namespace BreakdanceCustomElements;

use function Breakdance\Elements\c;
use function Breakdance\Elements\PresetSections\getPresetSection;


\Breakdance\ElementStudio\registerElementForEditing(
    "BreakdanceCustomElements\\FormBuilder2",
    \Breakdance\Util\getdirectoryPathRelativeToPluginFolder(__DIR__)
);

class FormBuilder2 extends \Breakdance\Elements\Element
{
    static function uiIcon()
    {
        return '<svg aria-hidden="true" focusable="false"   class="svg-inline--fa fa-envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M448 64H64C28.65 64 0 92.65 0 128v256c0 35.35 28.65 64 64 64h384c35.35 0 64-28.65 64-64V128C512 92.65 483.3 64 448 64zM64 96h384c17.64 0 32 14.36 32 32v36.01l-195.2 146.4c-17 12.72-40.63 12.72-57.63 0L32 164V128C32 110.4 46.36 96 64 96zM480 384c0 17.64-14.36 32-32 32H64c-17.64 0-32-14.36-32-32V203.1L208 336c14.12 10.61 31.06 16.02 48 16.02S289.9 346.6 304 336L480 203.1V384z"></path></svg>';
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
        return 'Form Builder 2';
    }

    static function className()
    {
        return 'bde-form-builder-2';
    }

    static function category()
    {
        return 'breakdance-custom-elements';
    }

    static function badge()
    {
        return false;
    }

    static function slug()
    {
        return __CLASS__;
    }

    static function template()
    {
        return file_get_contents(__DIR__ . '/html.twig');
    }

    static function defaultCss()
    {
        return file_get_contents(__DIR__ . '/default.css');
    }

    static function defaultProperties()
    {
        return ['content' => ['form' => ['form_name' => 'Contact Form', 'success_message' => 'Your message has been received!', 'error_message' => 'Something went wrong'], 'actions' => ['actions' => ['email', 'store_submission'], 'store_submission' => ['submission_title' => '{email}', 'store_files' => true], 'email' => ['emails' => [['message' => '{all_fields}', 'subject' => 'New contact form message', 'from' => 'dev-email@wpengine.local', 'from_name' => '{name}', 'reply_to' => '{email}', 'to' => 'dev-email@wpengine.local']]]]], 'design' => ['form' => ['theme' => 'default'], 'layout' => ['display' => ['breakpoint_base' => 'vertical'], 'gap' => ['breakpoint_base' => ['number' => 20, 'unit' => 'px', 'style' => '20px']]]]];
    }

    static function defaultChildren()
    {
        return [['slug' => 'BreakdanceCustomElements\FormBuilder2Field', 'defaultProperties' => ['content' => ['field' => ['type' => 'text', 'label' => 'Name', 'advanced' => ['id' => 'name', 'required' => true]]]], 'children' => []], ['slug' => 'BreakdanceCustomElements\FormBuilder2Field', 'defaultProperties' => ['content' => ['field' => ['type' => 'email', 'label' => 'Email', 'advanced' => ['id' => 'email', 'required' => true]]]], 'children' => []], ['slug' => 'BreakdanceCustomElements\FormBuilder2Field', 'defaultProperties' => ['content' => ['field' => ['type' => 'textarea', 'label' => 'Message', 'advanced' => ['id' => 'message', 'required' => true]]]], 'children' => []], ['slug' => 'BreakdanceCustomElements\FormBuilder2Submit', 'defaultProperties' => ['content' => ['button' => ['text' => 'Submit']]], 'children' => []]];
    }

    static function cssTemplate()
    {
        $template = file_get_contents(__DIR__ . '/css.twig');
        return $template;
    }

    static function designControls()
    {
        return [c(
        "layout",
        "Layout",
        [c(
        "display",
        "Display",
        [],
        ['type' => 'button_bar', 'layout' => 'vertical', 'items' => [['value' => 'vertical', 'text' => 'Stack'], ['value' => 'horizontal', 'text' => 'Row'], ['value' => 'grid', 'text' => 'Grid']]],
        true,
        false,
        [],
        
      ), c(
        "columns",
        "Grid Columns",
        [],
        ['type' => 'number', 'layout' => 'inline', 'rangeOptions' => ['min' => 1, 'max' => 12, 'step' => 1]],
        true,
        false,
        [],
        
      ), c(
        "wrap",
        "Wrap Row Items",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
        
      ), c(
        "gap",
        "Gap",
        [],
        ['type' => 'unit', 'layout' => 'inline'],
        true,
        false,
        [],
        
      ), c(
        "align_items",
        "Align Items",
        [],
        ['type' => 'dropdown', 'layout' => 'inline', 'items' => [['value' => 'stretch', 'text' => 'Stretch'], ['value' => 'flex-start', 'text' => 'Start'], ['value' => 'center', 'text' => 'Center'], ['value' => 'flex-end', 'text' => 'End']]],
        true,
        false,
        [],
        
      ), c(
        "justify_content",
        "Justify Content",
        [],
        ['type' => 'dropdown', 'layout' => 'inline', 'items' => [['value' => 'flex-start', 'text' => 'Start'], ['value' => 'center', 'text' => 'Center'], ['value' => 'flex-end', 'text' => 'End'], ['value' => 'space-between', 'text' => 'Space Between'], ['value' => 'space-around', 'text' => 'Space Around']]],
        true,
        false,
        [],
        
      )],
        ['type' => 'section', 'sectionOptions' => ['type' => 'accordion']],
        false,
        false,
        [],
        
      ), getPresetSection(
      "EssentialElements\\form-container",
      "Container",
      "container",
       ['type' => 'popout']
     ), getPresetSection(
      "EssentialElements\\AtomV1FormDesign",
      "Form Fields & Button",
      "form",
       ['type' => 'popout']
     ), getPresetSection(
      "EssentialElements\\spacing_margin_y",
      "Spacing",
      "spacing",
       ['type' => 'popout']
     )];
    }

    static function contentControls()
    {
        return [c(
        "form",
        "Form",
        [c(
        "form_name",
        "Form Name",
        [],
        ['type' => 'text'],
        false,
        false,
        [],
        
      ), c(
        "success_message",
        "Success Message",
        [],
        ['type' => 'text'],
        false,
        false,
        [],
        
      ), c(
        "error_message",
        "Error Message",
        [],
        ['type' => 'text'],
        false,
        false,
        [],
        
      ), c(
        "hide_on_success",
        "Hide Form on Success",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "redirect",
        "Redirect After Submit",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "redirect_url",
        "Redirect URL",
        [],
        ['type' => 'url', 'condition' => ['path' => 'content.form.redirect', 'operand' => 'equals', 'value' => true]],
        false,
        false,
        [],
        
      )],
        ['type' => 'section', 'sectionOptions' => ['type' => 'accordion']],
        false,
        false,
        [],
        
      ), c(
        "actions",
        "Submission Actions",
        [c(
        "actions",
        "Actions After Submission",
        [],
        ['type' => 'multiselect', 'layout' => 'vertical', 'placeholder' => 'No action selected', 'items' => [['text' => 'Store Submission', 'value' => 'store_submission'], ['text' => 'ActiveCampaign', 'value' => 'activecampaign'], ['text' => 'Custom JavaScript', 'value' => 'custom_javascript'], ['text' => 'ConvertKit', 'value' => 'convertkit'], ['text' => 'Drip', 'value' => 'drip'], ['text' => 'Discord', 'value' => 'discord'], ['text' => 'Slack', 'value' => 'slack'], ['text' => 'Email', 'value' => 'email'], ['text' => 'GetResponse', 'value' => 'getresponse'], ['text' => 'MailChimp', 'value' => 'mailchimp'], ['text' => 'MailerLite', 'value' => 'mailerlite'], ['text' => 'Webhook', 'value' => 'webhook'], ['text' => 'Popup', 'value' => 'popup']]],
        false,
        false,
        [],
        
      ), c(
        "store_submission",
        "Store Submission",
        [c(
        "submission_title",
        "Submission Title",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'variableOptions' => ['enabled' => true, 'populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id']]],
        false,
        false,
        [],
        
      ), c(
        "store_files",
        "Store uploaded files",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
        
      ), c(
        "store_files_as_attachment",
        "Add uploaded files to WordPress media library",
        [],
        ['type' => 'toggle', 'layout' => 'inline', 'condition' => ['path' => 'content.actions.store_submission.store_files', 'operand' => 'is set', 'value' => '']],
        false,
        false,
        [],
        
      ), c(
        "restrict_file_access",
        "Restrict uploaded file access to admin users",
        [],
        ['type' => 'toggle', 'layout' => 'inline', 'condition' => ['path' => 'content.actions.store_submission.restrict_file_access', 'operand' => 'is set', 'value' => '']],
        false,
        false,
        [],
        
      ), c(
        "run_action_conditionally",
        "Run Action Conditionally",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "conditions",
        "Conditions",
        [c(
        "condition",
        "Condition",
        [],
        ['type' => 'conditional_form_field', 'layout' => 'vertical', 'noLabel' => true, 'dropdownOptions' => ['populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'advanced.id', 'operand' => 'not equals', 'value' => 'advanced.id']]]],
        false,
        false,
        [],
        
      )],
        ['repeaterOptions' => ['titleTemplate' => '', 'defaultTitle' => 'Condition', 'buttonName' => 'Add Condition'], 'condition' => ['path' => '%%CURRENTPATH%%.run_action_conditionally', 'operand' => 'equals', 'value' => true], 'type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.actions', 'operand' => 'includes', 'value' => 'store_submission'], 'type' => 'section', 'sectionOptions' => ['type' => 'modal']],
        false,
        false,
        [],
        
      ), c(
        "activecampaign",
        "ActiveCampaign",
        [c(
        "api_key_input",
        "Use ActiveCampaign API Key",
        [],
        ['type' => 'api_key_input', 'layout' => 'vertical', 'apiKeyOptions' => ['apiKeyName' => 'activecampaign_api_key', 'urlKeyName' => 'activecampaign_url']],
        false,
        false,
        [],
        
      ), c(
        "account",
        "Account",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'No account selected', 'dropdownOptions' => ['populate' => ['fetchDataAction' => 'breakdance_fetch_activecampaign_accounts', 'fetchContextPath' => 'content.actions.activecampaign', 'refetchPaths' => ['content.actions.activecampaign.api_key_input']]]],
        false,
        false,
        [],
        
      ), c(
        "list",
        "List",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'No list selected', 'dropdownOptions' => ['populate' => ['fetchDataAction' => 'breakdance_fetch_activecampaign_lists', 'fetchContextPath' => 'content.actions.activecampaign', 'refetchPaths' => ['content.actions.activecampaign.api_key_input']]]],
        false,
        false,
        [],
        
      ), c(
        "tags",
        "Tags",
        [],
        ['type' => 'multiselect', 'layout' => 'vertical', 'placeholder' => 'No tags selected', 'multiselectOptions' => ['populate' => ['fetchDataAction' => 'breakdance_fetch_activecampaign_tags', 'fetchContextPath' => 'content.actions.activecampaign', 'refetchPaths' => ['content.actions.activecampaign.api_key_input']]]],
        false,
        false,
        [],
        
      ), c(
        "field_mapping",
        "Field Mapping",
        [c(
        "fields",
        "Custom Fields",
        [c(
        "activecampaign_field",
        "Field",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'No field selected', 'dropdownOptions' => ['populate' => ['fetchDataAction' => 'breakdance_fetch_activecampaign_fields', 'fetchContextPath' => 'content.actions.activecampaign', 'refetchPaths' => ['content.actions.activecampaign.form', 'content.actions.activecampaign.api_key_input']]]],
        false,
        false,
        [],
        
      ), c(
        "formField",
        "Form Field",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => '', 'dropdownOptions' => ['populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id']]],
        false,
        false,
        [],
        
      )],
        ['type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['type' => 'section', 'sectionOptions' => ['type' => 'accordion']],
        false,
        false,
        [],
        
      ), c(
        "run_action_conditionally",
        "Run Action Conditionally",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "conditions",
        "Conditions",
        [c(
        "condition",
        "Condition",
        [],
        ['type' => 'conditional_form_field', 'layout' => 'vertical', 'noLabel' => true, 'dropdownOptions' => ['populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'advanced.id', 'operand' => 'not equals', 'value' => 'advanced.id']]]],
        false,
        false,
        [],
        
      )],
        ['repeaterOptions' => ['titleTemplate' => '', 'defaultTitle' => 'Condition', 'buttonName' => 'Add Condition'], 'condition' => ['path' => '%%CURRENTPATH%%.run_action_conditionally', 'operand' => 'equals', 'value' => true], 'type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.actions', 'operand' => 'includes', 'value' => 'activecampaign'], 'type' => 'section', 'sectionOptions' => ['type' => 'modal']],
        false,
        false,
        [],
        
      ), c(
        "custom_javascript",
        "Custom JavaScript",
        [c(
        "js_on_success",
        "Run JS on Successful Submission",
        [],
        ['type' => 'code', 'layout' => 'vertical', 'placeholder' => 'console.log(formValues);', 'codeOptions' => ['language' => 'javascript']],
        false,
        false,
        [],
        
      ), c(
        "js_on_error",
        "Run JS on Failed Submission",
        [],
        ['type' => 'code', 'layout' => 'vertical', 'placeholder' => 'console.log(formValues);', 'codeOptions' => ['language' => 'javascript']],
        false,
        false,
        [],
        
      ), c(
        "run_action_conditionally",
        "Run Action Conditionally",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "conditions",
        "Conditions",
        [c(
        "condition",
        "Condition",
        [],
        ['type' => 'conditional_form_field', 'layout' => 'vertical', 'noLabel' => true, 'dropdownOptions' => ['populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'advanced.id', 'operand' => 'not equals', 'value' => 'advanced.id']]]],
        false,
        false,
        [],
        
      )],
        ['repeaterOptions' => ['titleTemplate' => '', 'defaultTitle' => 'Condition', 'buttonName' => 'Add Condition'], 'condition' => ['path' => '%%CURRENTPATH%%.run_action_conditionally', 'operand' => 'equals', 'value' => true], 'type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.actions', 'operand' => 'includes', 'value' => 'custom_javascript'], 'type' => 'section', 'sectionOptions' => ['type' => 'modal']],
        false,
        false,
        [],
        
      ), c(
        "convertkit",
        "ConvertKit",
        [c(
        "api_key_input",
        "Use ConvertKit API Key",
        [],
        ['type' => 'api_key_input', 'layout' => 'vertical', 'apiKeyOptions' => ['apiKeyName' => 'convertkit_api_key']],
        false,
        false,
        [],
        
      ), c(
        "form",
        "Form",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'No form selected', 'dropdownOptions' => ['populate' => ['fetchDataAction' => 'breakdance_fetch_convertkit_forms', 'fetchContextPath' => 'content.actions.convertkit', 'refetchPaths' => ['content.actions.convertkit.api_key_input']]]],
        false,
        false,
        [],
        
      ), c(
        "field_mapping",
        "Field Mapping",
        [c(
        "fields",
        "Custom Fields",
        [c(
        "convertkit_field",
        "Field",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'No field selected', 'dropdownOptions' => ['populate' => ['fetchDataAction' => 'breakdance_fetch_convertkit_fields', 'fetchContextPath' => 'content.actions.convertkit', 'refetchPaths' => ['content.actions.convertkit.form', 'content.actions.convertkit.api_key_input']]]],
        false,
        false,
        [],
        
      ), c(
        "formField",
        "Form Field",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => '', 'dropdownOptions' => ['populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id']]],
        false,
        false,
        [],
        
      )],
        ['type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.convertkit.form', 'operand' => 'is set', 'value' => ''], 'type' => 'section', 'sectionOptions' => ['type' => 'accordion']],
        false,
        false,
        [],
        
      ), c(
        "tags",
        "Tags",
        [c(
        "tag",
        "Tag",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'No tag selected', 'dropdownOptions' => ['populate' => ['fetchDataAction' => 'breakdance_fetch_convertkit_tags', 'fetchContextPath' => 'content.actions.convertkit', 'refetchPaths' => ['content.actions.convertkit.api_key_input']]]],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.convertkit.form', 'operand' => 'is set', 'value' => ''], 'type' => 'inline_repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "run_action_conditionally",
        "Run Action Conditionally",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "conditions",
        "Conditions",
        [c(
        "condition",
        "Condition",
        [],
        ['type' => 'conditional_form_field', 'layout' => 'vertical', 'noLabel' => true, 'dropdownOptions' => ['populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'advanced.id', 'operand' => 'not equals', 'value' => 'advanced.id']]]],
        false,
        false,
        [],
        
      )],
        ['repeaterOptions' => ['titleTemplate' => '', 'defaultTitle' => 'Condition', 'buttonName' => 'Add Condition'], 'condition' => ['path' => '%%CURRENTPATH%%.run_action_conditionally', 'operand' => 'equals', 'value' => true], 'type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.actions', 'operand' => 'includes', 'value' => 'convertkit'], 'type' => 'section', 'sectionOptions' => ['type' => 'modal']],
        false,
        false,
        [],
        
      ), c(
        "drip",
        "Drip",
        [c(
        "api_key_input",
        "Use Drip API Key",
        [],
        ['type' => 'api_key_input', 'layout' => 'vertical', 'apiKeyOptions' => ['apiKeyName' => 'drip_api_key']],
        false,
        false,
        [],
        
      ), c(
        "account",
        "Account",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'No account selected', 'dropdownOptions' => ['populate' => ['fetchDataAction' => 'breakdance_fetch_drip_accounts', 'fetchContextPath' => 'content.actions.drip', 'refetchPaths' => ['content.actions.drip.api_key_input']]]],
        false,
        false,
        [],
        
      ), c(
        "field_mapping",
        "Field Mapping",
        [c(
        "fields",
        "Custom Fields",
        [c(
        "drip_field",
        "Field",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'No field selected', 'dropdownOptions' => ['populate' => ['fetchDataAction' => 'breakdance_fetch_drip_fields', 'fetchContextPath' => 'content.actions.drip', 'refetchPaths' => ['content.actions.drip.form', 'content.actions.drip.api_key_input']]]],
        false,
        false,
        [],
        
      ), c(
        "formField",
        "Form Field",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => '', 'dropdownOptions' => ['populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id']]],
        false,
        false,
        [],
        
      )],
        ['type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.drip.account', 'operand' => 'is set', 'value' => ''], 'type' => 'section', 'sectionOptions' => ['type' => 'accordion']],
        false,
        false,
        [],
        
      ), c(
        "tags",
        "Tag",
        [],
        ['type' => 'multiselect', 'layout' => 'vertical', 'placeholder' => 'No tag selected', 'multiselectOptions' => ['populate' => ['fetchDataAction' => 'breakdance_fetch_drip_tags', 'fetchContextPath' => 'content.actions.drip', 'refetchPaths' => ['content.actions.drip.api_key_input']], 'makeCombobox' => true], 'condition' => ['path' => 'content.actions.drip.account', 'operand' => 'is set', 'value' => '']],
        false,
        false,
        [],
        
      ), c(
        "run_action_conditionally",
        "Run Action Conditionally",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "conditions",
        "Conditions",
        [c(
        "condition",
        "Condition",
        [],
        ['type' => 'conditional_form_field', 'layout' => 'vertical', 'noLabel' => true, 'dropdownOptions' => ['populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'advanced.id', 'operand' => 'not equals', 'value' => 'advanced.id']]]],
        false,
        false,
        [],
        
      )],
        ['repeaterOptions' => ['titleTemplate' => '', 'defaultTitle' => 'Condition', 'buttonName' => 'Add Condition'], 'condition' => ['path' => '%%CURRENTPATH%%.run_action_conditionally', 'operand' => 'equals', 'value' => true], 'type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.actions', 'operand' => 'includes', 'value' => 'drip'], 'type' => 'section', 'sectionOptions' => ['type' => 'modal']],
        false,
        false,
        [],
        
      ), c(
        "discord",
        "Discord",
        [c(
        "api_key_input",
        "Use Discord Webhook",
        [],
        ['type' => 'api_key_input', 'layout' => 'vertical', 'apiKeyOptions' => ['apiKeyName' => 'discord_webhook_url', 'apiKeyLabel' => 'Webhook URL']],
        false,
        false,
        [],
        
      ), c(
        "username",
        "Bot Name",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'placeholder' => 'Registration alerts'],
        false,
        false,
        [],
        
      ), c(
        "title",
        "Title",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'placeholder' => 'New user registration'],
        false,
        false,
        [],
        
      ), c(
        "description",
        "Description",
        [],
        ['type' => 'text', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "avatar",
        "Message Icon",
        [],
        ['type' => 'wpmedia', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "image",
        "Main Image",
        [],
        ['type' => 'wpmedia', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "include_form_data",
        "Include form data",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "include_timestamp",
        "Include timestamp",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "color",
        "Border color",
        [],
        ['type' => 'color'],
        false,
        false,
        [],
        
      ), c(
        "run_action_conditionally",
        "Run Action Conditionally",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "conditions",
        "Conditions",
        [c(
        "condition",
        "Condition",
        [],
        ['type' => 'conditional_form_field', 'layout' => 'vertical', 'noLabel' => true, 'dropdownOptions' => ['populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'advanced.id', 'operand' => 'not equals', 'value' => 'advanced.id']]]],
        false,
        false,
        [],
        
      )],
        ['repeaterOptions' => ['titleTemplate' => '', 'defaultTitle' => 'Condition', 'buttonName' => 'Add Condition'], 'condition' => ['path' => '%%CURRENTPATH%%.run_action_conditionally', 'operand' => 'equals', 'value' => true], 'type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.actions', 'operand' => 'includes', 'value' => 'discord'], 'type' => 'section', 'sectionOptions' => ['type' => 'modal']],
        false,
        false,
        [],
        
      ), c(
        "slack",
        "Slack",
        [c(
        "api_key_input",
        "Use Slack Webhook",
        [],
        ['type' => 'api_key_input', 'layout' => 'vertical', 'apiKeyOptions' => ['apiKeyName' => 'slack_webhook_url', 'apiKeyLabel' => 'Webhook URL']],
        false,
        false,
        [],
        
      ), c(
        "pre_text",
        "Message text",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'placeholder' => 'Latest registration'],
        false,
        false,
        [],
        
      ), c(
        "title",
        "Title",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'placeholder' => 'New user registration'],
        false,
        false,
        [],
        
      ), c(
        "description",
        "Description",
        [],
        ['type' => 'text', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "include_form_data",
        "Include form data",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "include_timestamp",
        "Include timestamp",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "color",
        "Border color",
        [],
        ['type' => 'color'],
        false,
        false,
        [],
        
      ), c(
        "run_action_conditionally",
        "Run Action Conditionally",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "conditions",
        "Conditions",
        [c(
        "condition",
        "Condition",
        [],
        ['type' => 'conditional_form_field', 'layout' => 'vertical', 'noLabel' => true, 'dropdownOptions' => ['populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'advanced.id', 'operand' => 'not equals', 'value' => 'advanced.id']]]],
        false,
        false,
        [],
        
      )],
        ['repeaterOptions' => ['titleTemplate' => '', 'defaultTitle' => 'Condition', 'buttonName' => 'Add Condition'], 'condition' => ['path' => '%%CURRENTPATH%%.run_action_conditionally', 'operand' => 'equals', 'value' => true], 'type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.actions', 'operand' => 'includes', 'value' => 'slack'], 'type' => 'section', 'sectionOptions' => ['type' => 'modal']],
        false,
        false,
        [],
        
      ), c(
        "email",
        "Email",
        [c(
        "emails",
        "Emails",
        [c(
        "subject",
        "Subject",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'variableOptions' => ['enabled' => true, 'populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'type', 'operand' => 'is none of', 'value' => ['file', 'html']]]]],
        false,
        false,
        [],
        
      ), c(
        "to",
        "To Email",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'variableOptions' => ['enabled' => true, 'populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'type', 'operand' => 'is one of', 'value' => ['email']]]]],
        false,
        false,
        [],
        
      ), c(
        "from",
        "From Email",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'variableOptions' => ['enabled' => true, 'populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'type', 'operand' => 'is one of', 'value' => ['email']]]]],
        false,
        false,
        [],
        
      ), c(
        "from_name",
        "From Name",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'variableOptions' => ['enabled' => true, 'populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'type', 'operand' => 'is none of', 'value' => ['file', 'html']]]]],
        false,
        false,
        [],
        
      ), c(
        "reply_to",
        "Reply To",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'variableOptions' => ['enabled' => true, 'populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'type', 'operand' => 'is one of', 'value' => ['email']]]]],
        false,
        false,
        [],
        
      ), c(
        "message",
        "Message",
        [],
        ['type' => 'richtext', 'layout' => 'vertical', 'variableOptions' => ['enabled' => true, 'populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'type', 'operand' => 'is none of', 'value' => ['file', 'html']]]], 'variableItems' => [['text' => 'All Fields', 'value' => 'all_fields']]],
        false,
        false,
        [],
        
      ), c(
        "attach_files",
        "Attach uploaded files",
        [],
        ['type' => 'toggle', 'layout' => 'inline'],
        false,
        false,
        [],
        
      ), c(
        "cc",
        "CC",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'variableOptions' => ['enabled' => true, 'populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'type', 'operand' => 'is one of', 'value' => ['email']]]]],
        false,
        false,
        [],
        
      ), c(
        "bcc",
        "BCC",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'variableOptions' => ['enabled' => true, 'populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'type', 'operand' => 'is one of', 'value' => ['email']]]]],
        false,
        false,
        [],
        
      ), c(
        "send_email_conditionally",
        "Send Email Conditionally",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "conditions",
        "Conditions",
        [c(
        "condition",
        "Condition",
        [],
        ['type' => 'conditional_form_field', 'layout' => 'vertical', 'noLabel' => true, 'dropdownOptions' => ['populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'advanced.id', 'operand' => 'not equals', 'value' => 'advanced.id']]]],
        false,
        false,
        [],
        
      )],
        ['repeaterOptions' => ['titleTemplate' => '', 'defaultTitle' => 'Condition', 'buttonName' => 'Add Condition'], 'condition' => ['path' => '%%CURRENTPATH%%.send_email_conditionally', 'operand' => 'equals', 'value' => true], 'type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['repeaterOptions' => ['titleTemplate' => '{subject}', 'defaultTitle' => 'Email', 'buttonName' => 'Add email', 'defaultNewValue' => ['subject' => 'New contact form message', 'message' => '{all_fields}']], 'type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "run_action_conditionally",
        "Run Action Conditionally",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "conditions",
        "Conditions",
        [c(
        "condition",
        "Condition",
        [],
        ['type' => 'conditional_form_field', 'layout' => 'vertical', 'noLabel' => true, 'dropdownOptions' => ['populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'advanced.id', 'operand' => 'not equals', 'value' => 'advanced.id']]]],
        false,
        false,
        [],
        
      )],
        ['repeaterOptions' => ['titleTemplate' => '', 'defaultTitle' => 'Condition', 'buttonName' => 'Add Condition'], 'condition' => ['path' => '%%CURRENTPATH%%.run_action_conditionally', 'operand' => 'equals', 'value' => true], 'type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.actions', 'operand' => 'includes', 'value' => 'email'], 'type' => 'section', 'sectionOptions' => ['type' => 'modal']],
        false,
        false,
        [],
        
      ), c(
        "getresponse",
        "GetResponse",
        [c(
        "api_key_input",
        "Use GetResponse API Key",
        [],
        ['type' => 'api_key_input', 'layout' => 'vertical', 'apiKeyOptions' => ['apiKeyName' => 'getresponse_api_key']],
        false,
        false,
        [],
        
      ), c(
        "list",
        "List",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'No form selected', 'dropdownOptions' => ['populate' => ['fetchDataAction' => 'breakdance_fetch_getresponse_list', 'fetchContextPath' => 'content.actions.getresponse', 'refetchPaths' => ['content.actions.getresponse.api_key_input']]]],
        false,
        false,
        [],
        
      ), c(
        "field_mapping",
        "Field Mapping",
        [c(
        "fields",
        "Custom Fields",
        [c(
        "getresponse_field",
        "Field",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'No field selected', 'dropdownOptions' => ['populate' => ['fetchDataAction' => 'breakdance_fetch_getresponse_fields', 'fetchContextPath' => 'content.actions.getresponse', 'refetchPaths' => ['content.actions.getresponse.form', 'content.actions.getresponse.api_key_input']]]],
        false,
        false,
        [],
        
      ), c(
        "formField",
        "Form Field",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => '', 'dropdownOptions' => ['populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id']]],
        false,
        false,
        [],
        
      )],
        ['type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.getresponse.list', 'operand' => 'is set', 'value' => ''], 'type' => 'section', 'sectionOptions' => ['type' => 'accordion']],
        false,
        false,
        [],
        
      ), c(
        "tags",
        "Tags",
        [c(
        "tagId",
        "Tag",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'No tag selected', 'dropdownOptions' => ['populate' => ['fetchDataAction' => 'breakdance_fetch_getresponse_tags', 'fetchContextPath' => 'content.actions.getresponse', 'refetchPaths' => ['content.actions.getresponse.api_key_input']]]],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.getresponse.list', 'operand' => 'is set', 'value' => ''], 'type' => 'inline_repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "dayOfCycle",
        "Day Of Cycle",
        [],
        ['type' => 'number', 'layout' => 'inline', 'condition' => ['path' => 'content.actions.getresponse.list', 'operand' => 'is set', 'value' => '']],
        false,
        false,
        [],
        
      ), c(
        "run_action_conditionally",
        "Run Action Conditionally",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "conditions",
        "Conditions",
        [c(
        "condition",
        "Condition",
        [],
        ['type' => 'conditional_form_field', 'layout' => 'vertical', 'noLabel' => true, 'dropdownOptions' => ['populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'advanced.id', 'operand' => 'not equals', 'value' => 'advanced.id']]]],
        false,
        false,
        [],
        
      )],
        ['repeaterOptions' => ['titleTemplate' => '', 'defaultTitle' => 'Condition', 'buttonName' => 'Add Condition'], 'condition' => ['path' => '%%CURRENTPATH%%.run_action_conditionally', 'operand' => 'equals', 'value' => true], 'type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.actions', 'operand' => 'includes', 'value' => 'getresponse'], 'type' => 'section', 'sectionOptions' => ['type' => 'modal']],
        false,
        false,
        [],
        
      ), c(
        "mailchimp",
        "MailChimp",
        [c(
        "api_key_input",
        "Use MailChimp API Key",
        [],
        ['type' => 'api_key_input', 'layout' => 'vertical', 'apiKeyOptions' => ['apiKeyName' => 'mailchimp_api_key']],
        false,
        false,
        [],
        
      ), c(
        "audience",
        "Audience",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'No audience selected', 'dropdownOptions' => ['populate' => ['fetchDataAction' => 'breakdance_fetch_mailchimp_lists', 'fetchContextPath' => 'content.actions.mailchimp', 'refetchPaths' => ['content.actions.mailchimp.api_key_input']], 'noDataAvailableMessage' => 'Empty or invalid API key']],
        false,
        false,
        [],
        
      ), c(
        "double_optin",
        "Double Opt-In",
        [],
        ['type' => 'toggle', 'condition' => ['path' => 'content.actions.mailchimp.audience', 'operand' => 'is set', 'value' => '']],
        false,
        false,
        [],
        
      ), c(
        "field_mapping",
        "Field Mapping",
        [c(
        "fields",
        "Fields",
        [c(
        "mailchimp_field",
        "Mailchimp Field",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'No field selected', 'dropdownOptions' => ['populate' => ['fetchDataAction' => 'breakdance_fetch_mailchimp_fields', 'fetchContextPath' => 'content.actions.mailchimp', 'refetchPaths' => ['content.actions.mailchimp.audience', 'content.actions.mailchimp.api_key_input']], 'noDataAvailableMessage' => 'No fields available']],
        false,
        false,
        [],
        
      ), c(
        "formField",
        "Form Field",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => '', 'dropdownOptions' => ['populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id']]],
        false,
        false,
        [],
        
      )],
        ['type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.mailchimp.audience', 'operand' => 'is set', 'value' => ''], 'type' => 'section', 'sectionOptions' => ['type' => 'accordion']],
        false,
        false,
        [],
        
      ), c(
        "interests",
        "Audience Groups",
        [c(
        "category",
        "Category",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'Select Category', 'dropdownOptions' => ['populate' => ['fetchDataAction' => 'breakdance_fetch_mailchimp_interest_categories', 'fetchContextPath' => 'content.actions.mailchimp', 'refetchPaths' => ['content.actions.mailchimp.audience', 'content.actions.mailchimp.api_key_input']], 'noDataAvailableMessage' => 'No audience groups available']],
        false,
        false,
        [],
        
      ), c(
        "interest",
        "Group",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'Select Audience Group', 'dropdownOptions' => ['populate' => ['fetchDataAction' => 'breakdance_fetch_mailchimp_interests', 'fetchContextPath' => 'content.actions.mailchimp', 'refetchPaths' => ['content.actions.mailchimp.audience', '%%CURRENTPATH%%.category', 'content.actions.mailchimp.api_key_input']], 'noDataAvailableMessage' => 'No audience groups available']],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.mailchimp.audience', 'operand' => 'is set', 'value' => ''], 'type' => 'section', 'sectionOptions' => ['type' => 'accordion']],
        false,
        false,
        [],
        
      ), c(
        "run_action_conditionally",
        "Run Action Conditionally",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "conditions",
        "Conditions",
        [c(
        "condition",
        "Condition",
        [],
        ['type' => 'conditional_form_field', 'layout' => 'vertical', 'noLabel' => true, 'dropdownOptions' => ['populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'advanced.id', 'operand' => 'not equals', 'value' => 'advanced.id']]]],
        false,
        false,
        [],
        
      )],
        ['repeaterOptions' => ['titleTemplate' => '', 'defaultTitle' => 'Condition', 'buttonName' => 'Add Condition'], 'condition' => ['path' => '%%CURRENTPATH%%.run_action_conditionally', 'operand' => 'equals', 'value' => true], 'type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.actions', 'operand' => 'includes', 'value' => 'mailchimp'], 'type' => 'section', 'sectionOptions' => ['type' => 'modal']],
        false,
        false,
        [],
        
      ), c(
        "mailerlite",
        "MailerLite",
        [c(
        "api_key_input",
        "Use MailerLite API Key",
        [],
        ['type' => 'api_key_input', 'layout' => 'vertical', 'apiKeyOptions' => ['apiKeyName' => 'mailerlite_api_key']],
        false,
        false,
        [],
        
      ), c(
        "group",
        "group",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'No group selected', 'dropdownOptions' => ['populate' => ['fetchDataAction' => 'breakdance_fetch_mailerlite_groups', 'fetchContextPath' => 'content.actions.mailerlite', 'refetchPaths' => ['content.actions.mailerlite.api_key_input']]]],
        false,
        false,
        [],
        
      ), c(
        "field_mapping",
        "Field Mapping",
        [c(
        "fields",
        "Custom Fields",
        [c(
        "mailerlite_field",
        "Field",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'No field selected', 'dropdownOptions' => ['populate' => ['fetchDataAction' => 'breakdance_fetch_mailerlite_fields', 'fetchContextPath' => 'content.actions.mailerlite', 'refetchPaths' => ['content.actions.mailerlite.group', 'content.actions.mailerlite.api_key_input']]]],
        false,
        false,
        [],
        
      ), c(
        "formField",
        "Form Field",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => '', 'dropdownOptions' => ['populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id']]],
        false,
        false,
        [],
        
      )],
        ['type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.mailerlite.group', 'operand' => 'is set', 'value' => ''], 'type' => 'section', 'sectionOptions' => ['type' => 'accordion']],
        false,
        false,
        [],
        
      ), c(
        "resubscribe",
        "Reactivate subscriber",
        [],
        ['type' => 'toggle', 'layout' => 'inline', 'condition' => ['path' => 'content.actions.mailerlite.group', 'operand' => 'is set', 'value' => '']],
        false,
        false,
        [],
        
      ), c(
        "run_action_conditionally",
        "Run Action Conditionally",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "conditions",
        "Conditions",
        [c(
        "condition",
        "Condition",
        [],
        ['type' => 'conditional_form_field', 'layout' => 'vertical', 'noLabel' => true, 'dropdownOptions' => ['populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'advanced.id', 'operand' => 'not equals', 'value' => 'advanced.id']]]],
        false,
        false,
        [],
        
      )],
        ['repeaterOptions' => ['titleTemplate' => '', 'defaultTitle' => 'Condition', 'buttonName' => 'Add Condition'], 'condition' => ['path' => '%%CURRENTPATH%%.run_action_conditionally', 'operand' => 'equals', 'value' => true], 'type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.actions', 'operand' => 'includes', 'value' => 'mailerlite'], 'type' => 'section', 'sectionOptions' => ['type' => 'modal']],
        false,
        false,
        [],
        
      ), c(
        "webhook",
        "Webhook",
        [c(
        "webhook_url",
        "Webhook URL",
        [],
        ['type' => 'text', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "webhook_field_map",
        "Field Map",
        [c(
        "name",
        "Field Name",
        [],
        ['type' => 'text', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "value",
        "Field Value",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'variableOptions' => ['enabled' => true, 'populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id']]],
        false,
        false,
        [],
        
      )],
        ['repeaterOptions' => ['titleTemplate' => '{name}', 'defaultTitle' => 'Data', 'buttonName' => 'Add data'], 'type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "webhook_headers",
        "Headers",
        [c(
        "name",
        "Header Name",
        [],
        ['type' => 'text', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "value",
        "Header Value",
        [],
        ['type' => 'text', 'layout' => 'vertical', 'variableOptions' => ['enabled' => true, 'populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id']]],
        false,
        false,
        [],
        
      )],
        ['repeaterOptions' => ['titleTemplate' => '{name}', 'defaultTitle' => 'Headers', 'buttonName' => 'Add header'], 'type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "run_action_conditionally",
        "Run Action Conditionally",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "conditions",
        "Conditions",
        [c(
        "condition",
        "Condition",
        [],
        ['type' => 'conditional_form_field', 'layout' => 'vertical', 'noLabel' => true, 'dropdownOptions' => ['populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'advanced.id', 'operand' => 'not equals', 'value' => 'advanced.id']]]],
        false,
        false,
        [],
        
      )],
        ['repeaterOptions' => ['titleTemplate' => '', 'defaultTitle' => 'Condition', 'buttonName' => 'Add Condition'], 'condition' => ['path' => '%%CURRENTPATH%%.run_action_conditionally', 'operand' => 'equals', 'value' => true], 'type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.actions', 'operand' => 'includes', 'value' => 'webhook'], 'type' => 'section', 'sectionOptions' => ['type' => 'modal']],
        false,
        false,
        [],
        
      ), c(
        "popup",
        "Popup",
        [c(
        "popups_on_success",
        "On Success",
        [c(
        "popup",
        "Popup",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'No popup selected', 'dropdownOptions' => ['populate' => ['fetchDataAction' => 'breakdance_get_popups']]],
        false,
        false,
        [],
        
      ), c(
        "action",
        "Popup Action",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'No selected', 'items' => [['text' => 'Open', 'value' => 'open'], ['text' => 'Close', 'value' => 'close'], ['text' => 'Toggle', 'value' => 'toggle']]],
        false,
        false,
        [],
        
      )],
        ['repeaterOptions' => ['titleTemplate' => 'Popup', 'defaultTitle' => 'Popup', 'buttonName' => 'Add Popup'], 'type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "popups_on_error",
        "On Error",
        [c(
        "popup",
        "Popup",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'No popup selected', 'dropdownOptions' => ['populate' => ['fetchDataAction' => 'breakdance_get_popups']]],
        false,
        false,
        [],
        
      ), c(
        "action",
        "Popup Action",
        [],
        ['type' => 'dropdown', 'layout' => 'vertical', 'placeholder' => 'No selected', 'items' => [['text' => 'Open', 'value' => 'open'], ['text' => 'Close', 'value' => 'close'], ['text' => 'Toggle', 'value' => 'toggle']]],
        false,
        false,
        [],
        
      )],
        ['repeaterOptions' => ['titleTemplate' => 'Popup', 'defaultTitle' => 'Popup', 'buttonName' => 'Add Popup'], 'type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      ), c(
        "run_action_conditionally",
        "Run Action Conditionally",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "conditions",
        "Conditions",
        [c(
        "condition",
        "Condition",
        [],
        ['type' => 'conditional_form_field', 'layout' => 'vertical', 'noLabel' => true, 'dropdownOptions' => ['populate' => ['path' => 'content.form.fields', 'text' => 'label', 'value' => 'advanced.id', 'condition' => ['path' => 'advanced.id', 'operand' => 'not equals', 'value' => 'advanced.id']]]],
        false,
        false,
        [],
        
      )],
        ['repeaterOptions' => ['titleTemplate' => '', 'defaultTitle' => 'Condition', 'buttonName' => 'Add Condition'], 'condition' => ['path' => '%%CURRENTPATH%%.run_action_conditionally', 'operand' => 'equals', 'value' => true], 'type' => 'repeater', 'layout' => 'vertical'],
        false,
        false,
        [],
        
      )],
        ['condition' => ['path' => 'content.actions.actions', 'operand' => 'includes', 'value' => 'popup'], 'type' => 'section', 'sectionOptions' => ['type' => 'modal']],
        false,
        false,
        [],
        
      )],
        ['type' => 'section', 'sectionOptions' => ['type' => 'accordion']],
        false,
        false,
        [],
        
      ), c(
        "advanced",
        "Advanced",
        [c(
        "form_id",
        "Form HTML ID",
        [],
        ['type' => 'text'],
        false,
        false,
        [],
        
      ), c(
        "honeypot_enabled",
        "Add Honeypot Field",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "csrf_enabled",
        "Enable CSRF Protection",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "recaptcha",
        "reCAPTCHA",
        [c(
        "enabled",
        "Enable reCAPTCHA",
        [],
        ['type' => 'toggle'],
        false,
        false,
        [],
        
      ), c(
        "api_key_input",
        "Use reCAPTCHA API Key",
        [],
        ['type' => 'api_key_input', 'layout' => 'vertical', 'apiKeyOptions' => ['apiKeyLabel' => 'Secret Key', 'apiKeyName' => 'recaptcha_secret_key', 'urlKeyLabel' => 'Site Key', 'urlKeyName' => 'recaptcha_site_key'], 'condition' => ['path' => '%%CURRENTPATH%%.enabled', 'operand' => 'equals', 'value' => true]],
        false,
        false,
        [],
        
      )],
        ['type' => 'section', 'sectionOptions' => ['type' => 'popout']],
        false,
        false,
        [],
        
      )],
        ['type' => 'section', 'sectionOptions' => ['type' => 'accordion']],
        false,
        false,
        [],
        
      )];
    }

    static function settingsControls()
    {
        return [];
    }

    static function dependencies()
    {
        return ['0' =>  ['styles' => ['%%BREAKDANCE_ELEMENTS_PLUGIN_URL%%dependencies-files/awesome-form@1/css/form.css'],],'1' =>  ['scripts' => ['%%BREAKDANCE_ELEMENTS_PLUGIN_URL%%dependencies-files/maska@3/maska.js'],'builderCondition' => 'return false;',],'2' =>  ['scripts' => ['%%BREAKDANCE_ELEMENTS_PLUGIN_URL%%dependencies-files/awesome-form@1/js/form.js'],'inlineScripts' => ['breakdanceForm.init(\'%%SELECTOR%% .bde-fb2__form\')'],'builderCondition' => 'return false;',],'3' =>  ['inlineStyles' => ['%%SELECTOR%% .breakdance-form-button__submit, %%SELECTOR%% .breakdance-form-field .breakdance-form-file-upload, %%SELECTOR%% .breakdance-form-field .breakdance-form-field__label {pointer-events: none}'],'frontendCondition' => 'return false;',],];
    }

    static function settings()
    {
        return false;
    }

    static function addPanelRules()
    {
        return false;
    }

    static public function actions()
    {
        return false;
    }

    static function nestingRule()
    {
        return ['type' => 'container', 'inlineEditable' => false];
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

    static function availableIn()
    {
        return ['oxygen'];
    }


    static function order()
    {
        return 0;
    }

    static function dynamicPropertyPaths()
    {
        return false;
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
}
