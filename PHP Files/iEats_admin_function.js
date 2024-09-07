// the text that will be typed out
var words = 
    [
        "What Would You Like to Do?"
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
        $(".admin-words").text(part);
    }, speed);
};

$(document).ready(function() {
    wordFlick();
}); 

// for insert
// the text that will be typed out
var words_insert = 
    [
        "Insert Into..."
    ],
    part_insert,
    i = 0,
    offset_insert = 0,
    len_insert = words_insert.length,
    forwards_insert = true,
    skip_count_insert = 0,
    skip_delay_insert = 20,
    speed_insert = 100;

var wordFlick_insert = function() {
    setInterval(function() {
        if (forwards_insert) {
            if (offset_insert >= words_insert[i].length) {
                ++skip_count_insert;

                if (skip_count_insert == skip_delay_insert) {
                    forwards_insert = false;
                    skip_count_insert = 0;
                }
            }
        } else {
            if (offset_insert == 0) {
                forwards_insert = true;
                i++;
                offset_insert = 0;
                
                if (i >= len_insert) {
                    i = 0;
                }
            }
        }
        part_insert = words_insert[i].substring(0, offset_insert);
        
        if (skip_count_insert == 0) {
            if (forwards_insert) {
                offset_insert++;
            } else {
                offset_insert--;
            }
        }
        $(".insert-words").text(part_insert);
    }, speed_insert);
};

$(document).ready(function() {
    wordFlick_insert();
});

// for update
var words_update = 
    [
        "Update Entries For..."
    ],
    part_update,
    i = 0,
    offset_update = 0,
    len_update = words_update.length,
    forwards_update = true,
    skip_count_update = 0,
    skip_delay_update = 20,
    speed_update = 100;

var wordFlick_update = function() {
    setInterval(function() {
        if (forwards_update) {
            if (offset_update >= words_update[i].length) {
                ++skip_count_update;

                if (skip_count_update == skip_delay_update) {
                    forwards_update = false;
                    skip_count_update = 0;
                }
            }
        } else {
            if (offset_update == 0) {
                forwards_update = true;
                i++;
                offset_update = 0;
                
                if (i >= len_update) {
                    i = 0;
                }
            }
        }
        part_update = words_update[i].substring(0, offset_update);
        
        if (skip_count_update == 0) {
            if (forwards_update) {
                offset_update++;
            } else {
                offset_update--;
            }
        }
        $(".update-words").text(part_update);
    }, speed_update);
};

$(document).ready(function() {
    wordFlick_update();
});

// for deleteing
var words_delete = 
    [
        "Delete Entries For..."
    ],
    part_delete,
    i = 0,
    offset_delete = 0,
    len_delete = words_delete.length,
    forwards_delete = true,
    skip_count_delete = 0,
    skip_delay_delete = 20,
    speed_delete = 100;

var wordFlick_delete = function() {
    setInterval(function() {
        if (forwards_delete) {
            if (offset_delete >= words_delete[i].length) {
                ++skip_count_delete;

                if (skip_count_delete == skip_delay_delete) {
                    forwards_delete = false;
                    skip_count_delete = 0;
                }
            }
        } else {
            if (offset_delete == 0) {
                forwards_delete = true;
                i++;
                offset_delete = 0;
                
                if (i >= len_delete) {
                    i = 0;
                }
            }
        }
        part_delete = words_delete[i].substring(0, offset_delete);
        
        if (skip_count_delete == 0) {
            if (forwards_delete) {
                offset_delete++;
            } else {
                offset_delete--;
            }
        }
        $(".delete-words").text(part_delete);
    }, speed_delete);
};

$(document).ready(function() {
    wordFlick_delete();
});