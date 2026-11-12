(function() {
    tinymce.PluginManager.add('cshero_tinymce_button', function(editor, url) {
        editor.addButton('cshero_tinymce_button', {
            text: 'CMS Button',
            icon: false,
            onclick: function() {
                editor.windowManager.open({
                    title: 'Insert Button',
                    body: [{
                        type: 'textbox',
                        name: 'textboxbuttonName',
                        label: 'Button Text',
                        value: ''
                    }, 
                    {
                        type: 'textbox',
                        name: 'textboxbuttonLink',
                        label: 'Button Link',
                        value: ''
                    },{
                        type: 'listbox',
                        name: 'classSize',
                        label: 'Button Size',
                        values: [{
                            text: 'Default',
                            value: 'size-default'
                        }, {
                            text: 'Small',
                            value: 'size-small'
                        }]
                    },
                    {
                        type: 'listbox',
                        name: 'classType',
                        label: 'Button Type',
                        values: [{
                            text: 'Button Default',
                            value: 'btn-default'
                        }, {
                            text: 'Button Dark',
                            value: 'btn-dark'
                        },{
                            text: 'Button Grey',
                            value: 'btn-grey'
                        },{
                            text: 'Button Green',
                            value: 'btn-green'
                        },{
                            text: 'Button Blue',
                            value: 'btn-blue'
                        },{
                            text: 'Button Yellow',
                            value: 'btn-yellow'
                        },{
                            text: 'Button Orange',
                            value: 'btn-orange'
                        },{
                            text: 'Button Red',
                            value: 'btn-red'
                        }]
                    } ],
                    onsubmit: function(e) {
                        editor.insertContent(
                            '[cms_button size=&quot;' +
                            e.data.classSize +
                            '&quot; link=&quot;' +
                            e.data.textboxbuttonLink +
                            '&quot; type=&quot;' +
                            e.data.classType +
                            '&quot; text=&quot;' +
                            e.data.textboxbuttonName +
                            '&quot;]' +
                            editor.selection
                            .getContent() +
                            '[/cms_button]'
                        );
                    }
                });
            }
        });
    });
})();