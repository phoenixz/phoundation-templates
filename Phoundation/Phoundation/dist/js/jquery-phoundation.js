/**
 * This is the translation tr() marker call
 *
 * @param text
 * @returns {*}
 */
function tr(text) {
    return text;
}


(($) => {
    /**
     * String::until() return this string starting from the first occurrence of the specified needle
     *
     *
     * @param needle
     * @param needle_required
     * @returns {String|string}
     */
    String.prototype.from = function(needle, needle_required = false) {
        let pos = this.indexOf(needle);

        if (pos === -1) {
            if (needle_required) {
                return '';
            }

            return this.toString();
        }

        return this.substring(pos + 1);
    }


    /**
     * String::until() return this string until the first occurrence of the specified needle
     *
     *
     * @param needle
     * @param needle_required
     * @returns {String|string}
     */
    String.prototype.until = function(needle, needle_required = false) {
        let pos = this.indexOf(needle);

        if (pos === -1) {
            if (needle_required) {
                return '';
            }

            return this.toString();
        }

        return this.substring(0, pos);
    }


    /**
     * Create the Phoundation main class
     */
    class Phoundation {
        static setDefaults(opt = Phoundation.options) {
            Phoundation.options = $.extend({}, Phoundation.options, opt);
        };
    }


    /**
     * Processes the HTML sections in a Phoundation response
     *
     * @param html
     */
    Phoundation.processHtml = function (html)
    {
        // Process HTML modifications
        if (typeof html != "object") {
            // Invalid response!
            throw "Received invalid Phoundation response json.html, should be object";
        }

        // Process each section
        html.forEach(function(section, id)
        {
            switch (section.method) {
                case "delete":
                    // Replace the selector with the new HTML
                    $(section.selector).delete();
                    break;

                case "replace":
                    // Replace the selector with the new HTML
                    $(section.selector).replaceWith(section.html);
                    break;

                case "append":
                    // Append the specified HTML to the content of the selector
                    $(section.selector).append(section.html);
                    break;

                case "prepend":
                    // Append the specified HTML to the content of the selector
                    $(section.selector).prepend(section.html);
                    break;

                default:
                    throw 'Unknown method "' + section.method + '" in HTML section "' + id + '" in Phoundation reply';
            }
        });
    }


    /**
     * Processes the flash messages in a Phoundation response
     *
     * @param messages
     */
    Phoundation.processFlash = function (messages)
    {
        // Process HTML modifications
        if (typeof messages != "object") {
            // Invalid response!
            throw "Received invalid Phoundation response json.messages, should be object";
        }

        messages.forEach(function(section, id) {
            $(document).Toasts("create", JSON.parse(section));
        });
    }


    /**
     * Set Phoundation options
     *
     * @type {{ajaxSleep: number}}
     */
    Phoundation.options = {
        ajaxSleep: 100
    };

    const old_ajax = $.ajax;


    /**
     * Add $.filterPhoundation() method to jQuery
     */
    $.filterPhoundation = function (response, type)
    {
        let json, jsonp, clean;

        try {
            json = JSON.parse(response);

        } catch (e) {
            // Is it a JSONP response with a callback, perhaps?
            if (!response.match(/^jQuery[0-9]+_[0-9]+\(\{.+?}\)$/)) {
                console.log("Failed to pre-process AJAX request with: " + e);
                return response;
            }

            jsonp = response.until("(");
            clean = response.from("(");
            clean = clean.substr(0, clean.length - 1);

            try {
                // Retry to parse the (now clean) JSON
                json = JSON.parse(clean);

            } catch (e) {
                console.log("Failed to pre-process JSONP AJAX request with: " + e);
            }
        }

        // We got JSON, yay! Is it Phundation JSON tho?
        if (typeof json.phoundation == 'undefined') {
            // Not Phoundation response, just pass it through
            return response;
        }

        // We can safely assume this is a Phoundation response
        console.log('Got Phoundation response "' + json.response + '"')

        // Process response codes
        switch (json.response) {
            case 'ok':
                // All fine!
                break;

            case 'redirect':
                window.location.href(json.data.location);
                break;

            case 'signin':
                window.location.replace(json.data.location);
                break;

            case 'reload':
                window.location.reload(json.data.clearCache);
                break;

            case 'error':
                // Whoopsie! Just continue
        }

        // Process flash and HTML sections
        if (json.flash) {
            Phoundation.processFlash(json.flash);
            delete json.flash;
        }

        if (json.html) {
            Phoundation.processHtml(json.html);
            delete json.html;
        }

        // Ensure we have data in the response
        if (typeof json.data == "undefined") {
            json.data = {};
        }

        response = JSON.stringify(json.data);

        if (jsonp) {
            // Rebuild the JSONP request
            response = jsonp + "(" + response + ")";
        }

        return response;
    }


    /**
     * Add support for jQuery ajax request sleep
     *
     * @param url
     * @param options
     * @returns {*}
     */
    $.ajax = function (url, options)
    {
        // Execute the ajax call
        const ajaxResult = old_ajax(url, options);

        // Shift arguments
        if (typeof url === "object" && typeof options === "undefined") {
            options = url;
        }

        let ajaxSleep = options.ajaxSleep || Phoundation.options.ajaxSleep;

        if (!Number.isInteger(ajaxSleep)) {
            throw new Error('Phoundation "ajaxSleep" options must be a number');
        }

        if (ajaxSleep < 0) {
            throw new Error('Phoundation "ajaxSleep" options must be greater or equal to 0');
        }

        let ajaxSleepId = null;

        ajaxResult.sleep = function (fn) {
            if (typeof fn === "function") ajaxSleepId = setTimeout(fn, ajaxSleep);
            return this;
        };

        return ajaxResult.always(() => {
            if (ajaxSleepId !== null) {
                clearTimeout(ajaxSleepId);
                ajaxSleepId = null;
            }
        });
    };

    console.log("Phoundation jQuery extension setup");
    window.Phoundation = Phoundation;

})(jQuery);


/**
 * Ensure that jQuery pre-processes all Phoundation responses using $.filterPhoundation()
 */
$(function()
{
    $.ajaxSetup({
        dataFilter: function (response, type) {
            return $.filterPhoundation(response, type);
        },
        dataType: "json",
        cache: false
    });

//    console.clear();
    console.log("Phoundation jQuery extension initialized");
    console.log(" ");
    console.warn("YOU ARE NOT SUPPOSED TO BE HERE!");
    console.warn(" ");
    console.warn("THIS PART IN YOUR BROWSER IS DANGEROUS AND UNLESS YOU ARE PART OF IT PERSONNEL YOU SHOULD NEVER GO HERE");
    console.warn(" ");
    console.warn(" SSSSS    TTTTTTTT    OOOOO    PPPPPP    !!");
    console.warn("SS           TT      OO   OO   PP   PP   !!");
    console.warn(" SSSSS       TT      OO   OO   PPPPPP    !!");
    console.warn("     SS      TT      OO   OO   PP          ");
    console.warn(" SSSSS       TT       OOOOO    PP        !!");
    console.warn(" ");
    console.warn("IF SOMEBODY TOLD YOU TO GO AND DO SOMETHING IN THIS AREA, THEN YOU ARE BEING SCAMMED! PLEASE STOP TALKING TO THIS PERSON AND REPORT THIS INCIDENT TO YOUR IT DEPARTMENT DIRECTLY!");
});

