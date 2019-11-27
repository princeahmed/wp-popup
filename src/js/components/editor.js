const editor = grapesjs.init({
    // Indicate where to init the editor. You can also pass an HTMLElement
    container: '#gjs',
    // Get the content for the canvas directly from the element
    // As an alternative we could use: `components: '<h1>Hello World Component!</h1>'`,
    fromElement: true,
    // Size of the editor
    height: '500px',
    width: 'auto',
    layerManager: {
        appendTo: '.layers-container'
    },
    // Avoid any default panel
    // We define a default panel as a sidebar to contain layers
    panels: {
        defaults: [
            {
                id: 'layers',
                el: '.panel__right',
                // Make the panel resizable
                resizable: {
                    maxDim: 350,
                    minDim: 200,
                    tc: 0, // Top handler
                    cl: 1, // Left handler
                    cr: 0, // Right handler
                    bc: 0, // Bottom handler
                    // Being a flex child we need to change `flex-basis` property
                    // instead of the `width` (default)
                    keyWidth: 'flex-basis',
                },
            },
            {
                id: 'panel-switcher',
                el: '.panel__switcher',
                buttons: [{
                    id: 'show-layers',
                    active: true,
                    label: 'Layers',
                    command: 'show-layers',
                    togglable: false,
                }, {
                    id: 'show-blocks',
                    active: false,
                    label: 'Blocks',
                    command: 'show-blocks',
                    togglable: false,
                }],
            }
        ]
    },

    blockManager: {
        appendTo: '#blocks',
        blocks: [
            {
                id: 'section', // id is mandatory
                label: '<div class="block-label"><i class="fa fa-2x fa-square d-block"></i> <span class="label-text">Section</span></div>', // You can use HTML/SVG inside labels
                attributes: {class: 'gjs-block-section'},
                content: `<section class="my-section">
                      <h1>This is a simple title</h1>
                      <div>This is just a Lorem text: Lorem ipsum dolor sit amet</div>
                    </section>`,
            }, {
                id: 'text',
                label: '<div class="block-label"><i class="fa fa-2x fa-font d-block"></i> <span class="label-text">Text</span></div>',
                content: '<div data-gjs-type="text">Insert your text here</div>',
            }, {
                id: 'image',
                label: '<div class="block-label"><i class="fa fa-2x fa-image d-block"></i> <span class="label-text">Image</span></div>',
                // Select the component once it's dropped
                select: true,
                // You can pass components as a JSON instead of a simple HTML string,
                // in this case we also use a defined component type `image`
                content: {type: 'image'},
                // This triggers `active` event on dropped components and the `image`
                // reacts by opening the AssetManager
                activate: true,
            }
        ]
    },

    storageManager: {
        id: 'gjs-',
        type: 'remote',
        autosave: true,
        autoload: true,
        stepsBeforeSave: 10,
        storeComponents: true,
        storeStyles: true,
        storeHtml: true,
        storeCss: true,
        urlStore: '<?php echo SITE_URL; ?>event?type=store&campaign_id=<?php echo $data->notification->campaign_id; ?>&notification_id=<?php echo $data->notification->notification_id; ?>',
        urlLoad: '<?php echo SITE_URL; ?>event?type=load&campaign_id=<?php echo $data->notification->campaign_id; ?>&notification_id=<?php echo $data->notification->notification_id; ?>',
        params: {},
        headers: {},
    }

});

//Panels
editor.Panels.addPanel({
    id: 'panel-top',
    el: '.panel__top',
});

editor.Panels.addPanel({
    id: 'basic-actions',
    el: '.panel__basic-actions',
    buttons: [
        {
            id: 'save',
            label: '<span class="btn btn-success btn-sm">Save</span>',
            command: 'save-db',
        }
    ]
});

// Add the command
editor.Commands.add('save-db', {
    run: function (editor, sender) {
        sender && sender.set('active');
        editor.store();
    }
});

editor.Commands.add('show-layers', {
    getRowEl(editor) {
        return editor.getContainer().closest('.editor-row');
    },
    getLayersEl(row) {
        return row.querySelector('.layers-container')
    },
    run(editor, sender) {
        const lmEl = this.getLayersEl(this.getRowEl(editor));
        lmEl.style.display = '';
    },
    stop(editor, sender) {
        const lmEl = this.getLayersEl(this.getRowEl(editor));
        lmEl.style.display = 'none';
    },
});

editor.Commands.add('show-blocks', {
    getRowEl(editor) {
        return editor.getContainer().closest('.editor-row');
    },
    getLayersEl(row) {
        return row.querySelector('#blocks')
    },
    run(editor, sender) {
        const lmEl = this.getLayersEl(this.getRowEl(editor));
        lmEl.style.display = '';
    },
    stop(editor, sender) {
        const lmEl = this.getLayersEl(this.getRowEl(editor));
        lmEl.style.display = 'none';
    },
});