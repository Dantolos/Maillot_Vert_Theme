<?php
add_action("acf/include_fields", function () {
    if (!function_exists("acf_add_local_field_group")) {
        return;
    }

    acf_add_local_field_group([
        "key" => "group_685a4e56bdf31",
        "title" => "Global",
        "fields" => [
            [
                "key" => "field_685a4e57e042e",
                "label" => "Display",
                "name" => "display",
                "aria-label" => "",
                "type" => "true_false",
                "instructions" => "",
                "required" => 0,
                "conditional_logic" => 0,
                "wrapper" => [
                    "width" => "",
                    "class" => "",
                    "id" => "",
                ],
                "wpml_cf_preferences" => 1,
                "message" => "",
                "default_value" => 1,
                "allow_in_bindings" => 0,
                "ui_on_text" => "show",
                "ui_off_text" => "hide",
                "ui" => 1,
            ],
        ],
        "location" => [
            [
                [
                    "param" => "block",
                    "operator" => "==",
                    "value" => "all",
                ],
            ],
        ],
        "menu_order" => 0,
        "position" => "normal",
        "style" => "default",
        "label_placement" => "top",
        "instruction_placement" => "label",
        "hide_on_screen" => "",
        "active" => true,
        "description" => "",
        "show_in_rest" => 0,
        "acfml_field_group_mode" => "translation",
    ]);
});
