!function(){"use strict";"undefined"!=typeof tinymce&&(tinymce.create("tinymce.plugins.TablePressPlugin",{init(e,t){e.addCommand("TablePress_insert_table",window.tablepress_open_shortcode_thickbox),e.addButton("tablepress_insert_table",{title:tablepress_editor_button.title,cmd:"TablePress_insert_table",image:t.slice(0,t.length-8)+"img/tablepress-editor-button.png"})}}),tinymce.PluginManager.add("tablepress_tinymce",tinymce.plugins.TablePressPlugin))}();