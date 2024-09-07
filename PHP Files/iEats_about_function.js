// the text that will be typed out
var words = 
    [
        "We aim for International Eats to be your go-to site for finding great places to travel and great places to eat.",
        "It's an often occurrence to know what you want to eat, but not know any places that serve that food;",
        "And it works vice versa as well. Sometimes you may know where you would like to explore, but not about the foods that are served there.",
        "Great thing we're equipped to help you with both.",
        "Our platform is designed to make it easier for travelers, new and experienced, to find the perfect dining spot, where they an enjoy great views and even greater foods.",
        "With International Eats, it is ensured that every meal you eat, and every place you visit, will become a core memory experience."
    ],
    part,
    i = 0,
    offset = 0,
    len = words.length,
    forwards = true,
    skip_count = 0,
    skip_delay = 20,
    speed = 100;

var wordFlick = function() {
    setInterval(function() {
        if (forwards) {
            if (offset >= words[i].length) {
                ++skip_count;

                if (skip_count == skip_delay) {
                    forwards = false;
                    skip_count = 0;
                }
            }
        } else {
            if (offset == 0) {
                forwards = true;
                i++;
                offset = 0;
                
                if (i >= len) {
                    i = 0;
                }
            }
        }
        part = words[i].substring(0, offset);
        
        if (skip_count == 0) {
            if (forwards) {
                offset++;
            } else {
                offset--;
            }
        }
        $(".main-words").text(part);
    }, speed);
};

$(document).ready(function() {
    wordFlick();
});