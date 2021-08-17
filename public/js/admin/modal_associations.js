(function () {
    /**
     * Builder for elements.
     * @param container
     * @param {String} template
     * @returns {*}
     */
    function createElementBuilder(container, template) {
        /**
         * Builder instance.
         * @type {{container: *, template: String, removeAll: null, search: null, addElementList: null, forEach: null, count: null, addElement: null}}
         */
        var instance = {
            container: container,
            template: template,
            addElement: null,
            addElementList: null,
            forEach: null,
            count: null,
            removeAll: null,
            search: null
        };

        /**
         * Add element.
         * @param {Object} elementData
         */
        instance.addElement = function (elementData) {
            var jElement;
            jElement = $(template);
            jElement.data('elementId', elementData['id'].toString());
            jElement.find('[data-element-field="name"]').text(elementData['name'].toString());
            container.append(jElement);
        };


        /**
         * Add all the elements.
         * @param {Object[]} elementListData
         */
        instance.addElementList = function (elementListData) {
            elementListData.forEach(function (elementData) {
                instance.addElement(elementData);
            });
        };


        /**
         * Go through each element.
         * @param callback
         */
        instance.forEach = function (callback) {
            container.children().each(function (i, element) {
                callback(i, $(element));
            });
        };


        /**
         * Get count of elements.
         * @returns {*}
         */
        instance.count = function () {
            return container.children().length;
        };


        /**
         * Remove all the elements.
         */
        instance.removeAll = function () {
            instance.forEach(function (i, element) {
                element.remove();
            });
        };


        /**
         * Search elements according to text.
         * @param text
         */
        instance.search = function (text) {
            text = text.toLowerCase();
            instance.forEach(function (i, element) {
                var name;
                name = element.find('[data-element-field="name"]').text();
                name = name.toLowerCase();
                if (name.indexOf(text) >= 0) {
                    element.css({display: ''});
                } else {
                    element.css({display: 'none'});
                }
            });
        };


        return instance;
    }


    /**
     * Create available builder.
     * @param availableContainer
     * @returns {*}
     */
    function createAvailableBuilder(availableContainer) {
        var elementBuilder, template;
        template = '<div class="element" data-element-id="">' +
            '   <span class="name-container" data-element-field="name"></span>' +
            '   <span class="control-container">' +
            '       <span class="glyphicon glyphicon-plus text-success" data-element-control="add"></span>' +
            '   </span>' +
            '</div>';

        elementBuilder = createElementBuilder(availableContainer, template);

        /**
         * Add an element.
         * @param elementData
         */
        elementBuilder.addElement = function (elementData) {
            var jElement, name, listName;
            name = elementData['name'].toString();
            if (elementData['listName']) {
                listName = elementData['listName'].toString();
            } else {
                listName = name;
            }
            jElement = $(this.template);
            jElement.data('elementId', elementData['id'].toString());
            jElement.find('[data-element-field="name"]').text(listName).data('name', name);
            this.container.append(jElement);
        };

        /**
         * Allow the element.
         * @param elementData
         */
        elementBuilder.allow = function (elementData) {
            this.forEach(function (_, element) {
                if (element.data('elementId') === elementData['id']) {
                    element.removeClass('active');
                }
            });
        };

        /**
         * Disallow the element.
         * @param elementData
         */
        elementBuilder.disallow = function (elementData) {
            this.forEach(function (_, element) {
                if (element.data('elementId') === elementData['id']) {
                    element.addClass('active');
                }
            });
        };

        /**
         * Enable editor.
         */
        elementBuilder.enable = function () {
            this.container.removeClass('disabled');
        };

        /**
         * Disabled editor.
         */
        elementBuilder.disable = function () {
            this.container.addClass('disabled');
        };

        return elementBuilder;
    }


    /**
     * Create current builder.
     * @param currentContainer
     * @returns {*}
     */
    function createCurrentBuilder(currentContainer) {
        var elementBuilder, addElement, removeAll, refresh, template, limit;

        limit = parseInt(currentContainer.data('editorLimit'), 10);
        if (limit < 1 || isNaN(limit)) {
            limit = null;
        }

        if (currentContainer.data('sortable')) {
            currentContainer.sortable({handle: '[data-sortable-handler]'});
            refresh = function () {
                currentContainer.sortable('refresh');
            };
            template = '<div class="element" data-element-id="">' +
                '   <span class="sorting-container">' +
                '       <span class="glyphicon glyphicon-resize-vertical" data-sortable-handler=""></span>' +
                '   </span>' +
                '   <span class="name-container" data-element-field="name"></span>' +
                '   <span class="control-container">' +
                '       <span class="glyphicon glyphicon-minus text-danger" data-element-control="remove"></span>' +
                '   </span>' +
                '</div>';
        } else {
            refresh = function () {
            };
            template = '<div class="element" data-element-id="">' +
                '   <span class="name-container" data-element-field="name"></span>' +
                '   <span class="control-container">' +
                '       <span class="glyphicon glyphicon-minus text-danger" data-element-control="remove"></span>' +
                '   </span>' +
                '</div>';
        }

        elementBuilder = createElementBuilder(currentContainer, template);

        addElement = elementBuilder.addElement;
        removeAll = elementBuilder.removeAll;

        /**
         * Check if editor is full.
         * @returns {boolean}
         */
        elementBuilder.isFull = function () {
            return limit !== null && elementBuilder.count() >= limit;
        };

        /**
         * Add the element.
         * @param elementData
         */
        elementBuilder.addElement = function (elementData) {
            if (!elementBuilder.isFull()) {
                addElement(elementData);
            }
            refresh();
        };

        /**
         * Add the list of elements.
         * @param elementListData
         */
        elementBuilder.addElementList = function (elementListData) {
            elementListData.forEach(function (elementData) {
                if (!elementBuilder.isFull()) {
                    addElement(elementData);
                }
            });
            refresh();
        };

        /**
         * Remove the element.
         * @param elementData
         */
        elementBuilder.remove = function (elementData) {
            var elementId = elementData['id'];
            elementBuilder.forEach(function (i, element) {
                if (element.data('elementId') === elementId) {
                    element.remove();
                }
            });
            refresh();
        };


        /**
         * Remove all the elements.
         */
        elementBuilder.removeAll = function () {
            removeAll();
            refresh();
        };

        return elementBuilder;
    }

    /**
     * Extract available element.
     * @param element
     * @returns {{name: *, id: *}}
     */
    function extractAvailableElement(element) {
        var id, nameElement, name, listName;
        id = element.data('elementId');
        nameElement = element.find('[data-element-field="name"]');
        name = nameElement.data('name');
        listName = nameElement.text();

        return {
            id: id,
            name: name,
            listName: listName
        }
    }


    /**
     * Extract current element.
     * @param element
     * @returns {{id: *, name: *}}
     */
    function extractCurrentElement(element) {
        var id, name;
        id = element.data('elementId');
        name = element.find('[data-element-field="name"]').text();

        return {
            id: id,
            name: name
        }
    }


    /**
     * Create an editor object from editor container.
     * @param editorContainer
     * @returns {*}
     */
    function createEditor(editorContainer) {
        var availableContainer, availableUrl, currentContainer, availableWait,
            availableBuilder, currentBuilder, searchInputs, searchTimeouts = {};

        availableContainer = editorContainer.find('[data-editor-container="available"]');
        availableUrl = availableContainer.data('url');
        currentContainer = editorContainer.find('[data-editor-container="current"]');

        availableBuilder = createAvailableBuilder(availableContainer);
        currentBuilder = createCurrentBuilder(currentContainer);
        availableWait = editorContainer.find('[data-editor-wait="available"]');


        // add element
        availableContainer.on('click', '[data-element-control="add"]', function (e) {
            var element, elementData;
            element = $(e.currentTarget).parents('[data-element-id]').eq(0);
            elementData = extractAvailableElement(element);
            currentBuilder.addElement(elementData);
            availableBuilder.disallow(elementData);

            if (currentBuilder.isFull()) {
                availableBuilder.disable();
            }
        });


        // remove element
        currentContainer.on('click', '[data-element-control="remove"]', function (e) {
            var element, elementData;
            element = $(e.currentTarget).parents('[data-element-id]').eq(0);
            elementData = extractCurrentElement(element);
            currentBuilder.remove(elementData);
            availableBuilder.allow(elementData);

            if (!currentBuilder.isFull()) {
                availableBuilder.enable();
            }
        });


        // search
        searchInputs = editorContainer.find('[data-editor-search]');
        searchInputs.each(function (_, searchInput) {
            var containerId;
            searchInput = $(searchInput);
            containerId = searchInput.data('editorSearch');

            // Search
            searchInput.on('keyup', function () {
                if (searchTimeouts[containerId]) {
                    clearTimeout(searchTimeouts[containerId]);
                    searchTimeouts[containerId] = null;
                }

                searchTimeouts[containerId] = setTimeout(function () {
                    var value = searchInput.val();
                    if (containerId === 'available') {
                        availableBuilder.search(value);
                    } else if (containerId === 'current') {
                        currentBuilder.search(value);
                    }
                }, 100);
            });

            // Prevent submitting form
            searchInput.on('keypress', function (e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                }
            });
        });


        /**
         * Load editor.
         * @param currentElementData
         */
        function loadEditor(currentElementData) {
            var currentIds = {};
            availableWait.css({display: 'block'});
            currentBuilder.addElementList(currentElementData);
            currentElementData.forEach(function (elementData) {
                currentIds[elementData['id']] = true;
            });

            $.ajax({
                cache: false,
                url: availableUrl,
                type: 'GET',
                dataType: 'json'
            }).then(function (result) {
                availableBuilder.addElementList(result['elements']);
                availableBuilder.forEach(function (_, element) {
                    var id = element.data('elementId');
                    if (currentIds[id]) {
                        element.addClass('active');
                    }
                });
                availableWait.css({display: 'none'});
                if (currentBuilder.isFull()) {
                    availableBuilder.disable();
                }
            });
        }


        /**
         * Clear editor.
         */
        function clearEditor() {
            availableBuilder.removeAll();
            availableBuilder.enable();
            currentBuilder.removeAll();

            searchInputs.each(function (_, searchInput) {
                searchInput.value = '';
            });
        }


        /**
         * Get list of current elements.
         * @returns {Array}
         */
        function getCurrent() {
            var list = [];
            currentBuilder.forEach(function (_, element) {
                list.push(extractCurrentElement(element));
            });

            return list;
        }


        return {
            loadEditor: loadEditor,
            clearEditor: clearEditor,
            getCurrent: getCurrent
        };
    }


    /**
     * Extract current data from form.
     * @param currentContainer
     * @returns {Array}
     */
    function extractCurrentData(currentContainer) {
        var elementList = [];
        currentContainer.find('[data-element-container="element"]').each(function (_, element) {
            var elementData = {};
            element = $(element);
            elementData['id'] = element.find('[data-element="id"]').val();
            elementData['name'] = element.find('[data-element="name"]').text();
            elementList.push(elementData);
        });

        return elementList;
    }


    /**
     * Init associations block.
     * @param modalEl
     */
    function initAssociations(modalEl) {
        var modal, modalSave, modalSaveUrl, editor, sourceContainer;
        modal = $(modalEl);

        // modal
        modalSave = modal.find('[data-editor-action="save"]');
        modalSaveUrl = modalSave.data('url');
        editor = createEditor(modal);

        // load all the data to the editor
        modal.on('show.bs.modal', function (e) {
            sourceContainer = $($(e.relatedTarget).data('source'));
            editor.loadEditor(extractCurrentData(sourceContainer));
        });


        // clear the editor
        modal.on('hide.bs.modal', function () {
            editor.clearEditor();
        });


        // save the editor result
        modalSave.on('click', function () {
            var elementsData = [];
            var rebuildData = sourceContainer.data('rebuildData');
            editor.getCurrent().forEach(function (element, index) {
                elementsData.push({id: element['id'], position: index});
            });

            $.ajax({
                cache: false,
                url: modalSaveUrl,
                type: 'GET',
                dataType: 'json',
                data: {elements: elementsData, rebuildData: rebuildData}
            }).then(function (result) {
                sourceContainer.html(result['content']);
                modal.modal('hide');
            });
        });
    }

    $(function () {
        $('[data-modal-associations="editor"]').each(function (_, editorEl) {
            initAssociations(editorEl);
        });
    });
})();