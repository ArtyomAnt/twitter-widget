/**
 * Ak Twitter Wifget functions and definitions.
 */
( function( $ ) {
    "use strict";

    $( function() {

        var Ak_Twitter_Widget = {
            init: function () {
                this.$widget = $("#ak-twitter-widget");
                this.events();
                this.getData();
            },

            events: function() {
                var self = this;
            },

            buildWidget: function() {
                var self = this;

                var html = "<ul>";
                $.each(self.response, function(key, val) {
                    console.log(val);
                    html += "<li>";
                    html += val.text;
                    html += "</li>";
                });
                html += "</ul>";

                this.$widget.html(html);
                var date = new Date();
                var newDate = new Date(date.setHours(date.getHours() + 1));
                this.$widget.attr("data-refresh_time", newDate);
                setInterval(this.getData.bind(this), 60000);
            },

            getData: function() {
                var self = this;

                $.ajax({
                    method: "POST",
                    dataType: 'json',
                    url: ak_twitter_widget_l10n.ajax_url,
                    data: {
                        action: "handle_request",
                        "ak_widget_action": "get_tweets"
                    },
                    success: function(data, textStatus, xhr){
                        delete data.data.response.httpstatus;
                        delete data.data.response.rate;
                        self.response = data.data.response;

                        self.buildWidget();
                    },
                    error: function(errorThrown){
                        console.log(errorThrown);
                    }
                });
            }
        }

        Ak_Twitter_Widget.init();

    });
    
})( jQuery );