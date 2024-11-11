
$(document).ready(function () {
    $(".front_end_lang .upld_btn").on("click", function () {
        // Get the target class from data-target
        var target = $(this).data("target");

        // Hide all code containers and show only the selected one
        $(".upld_code_con").hide();
        $("." + target).show();

        // Remove 'active' class from all buttons and add it to the clicked button
        $(".upld_btn").removeClass("active");
        $(this).addClass("active");
    });


    require.config({ paths: { vs: 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.31.1/min/vs' } });

    require(['vs/editor/editor.main'], function () {
        const editorOptions = {
            theme: 'vs-dark',
            // fontFamily: '"Inconsolata", monospace',
            fontFamily: 'monospace',
            fontSize: 14,
            letterSpacing: 0, // default is 0
            lineHeight: 0,
            automaticLayout: true
        };


        // Initialize HTML, CSS, and JS editors with font settings
        const htmlEditor = monaco.editor.create(document.getElementById('html_code_editor'), {
            value: '<!-- Enter HTML code here -->',
            language: 'html',
            ...editorOptions
        });

        const cssEditor = monaco.editor.create(document.getElementById('css_code_editor'), {
            value: '/* Enter CSS code here */',
            language: 'css',
            ...editorOptions
        });

        const jsEditor = monaco.editor.create(document.getElementById('js_code_editor'), {
            value: '// Enter JavaScript code here',
            language: 'javascript',
            ...editorOptions
        });

        // Set editor container heights to 600px
        document.getElementById('html_code_editor').style.height = "600px";
        document.getElementById('css_code_editor').style.height = "600px";
        document.getElementById('js_code_editor').style.height = "600px";

        // Set editor content in hidden fields before form submission
        window.setEditorContent = function () {
            document.getElementById('html_code').value = htmlEditor.getValue();
            document.getElementById('css_code').value = cssEditor.getValue();
            document.getElementById('js_code').value = jsEditor.getValue();
        };
    });
});