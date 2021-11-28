(function () {
    /**
     * List of callbacks.
     * @type {{}}
     */
    var queue = {};

    /**
     * Add callback to queue.
     * @param name
     * @param callback
     */
    var addCallback = function (name, callback) {
        if (typeof queue[name] === 'undefined') {
            queue[name] = [];
        }

        queue[name].push(callback);
        if (queue[name].length === 1) {
            performNext(name);
        }
    };

    /**
     * Perform next callback from queue.
     * @param name
     */
    var performNext = function (name) {
        if (queue[name].length === 0) {
            return;
        }

        var promise = queue[name][0]();
        if (typeof promise === 'undefined' || typeof promise.always !== 'function') {
            var deferred = $.Deferred();
            deferred.resolve();
            promise = deferred.promise();
        }

        promise.then(function () {
            queue[name].shift();
            performNext(name);
        });
    };


    window.promiseQueue = {
        add: addCallback
    };
})();