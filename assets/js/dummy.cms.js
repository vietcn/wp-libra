(function($){
    "use strict";
    var cmsDummyData = function(current_data,p,theme){
    	$.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action': 'ajax_cmsdummy',
                'current_data':  current_data,
                'theme' : theme,
                'nonce': (window.wpLibraDummy && wpLibraDummy.nonce) ? wpLibraDummy.nonce : ''
            },
            success: function(data, textStatus, XMLHttpRequest){
                $('.cms-dummy-process-bar').css({
                    'width':p+'%',
                    '-webkit-transition':'width 1s',
                    'transition':'width 1s'
                });
                $('#cms-msg .cms-status').text(' Loading '+p+'%');
                if(isNaN(current_data)){
                    $('#cms-msg').parent().css('width','100%');
                    $('#cms-msg').append(data);
                }
                if(current_data=='grid'){
                    p+=5;
                    cmsDummyData(15,p,theme);
                }
                if(current_data>1 && current_data<16){
                    cmsDummyData(current_data-1,p+5,theme);
                }
                if(current_data==1){
                    cmsDummyData(16,100,theme);
                }
                if(current_data==16){
                    $('#cms-msg').parent().css('width','100%');
                    $('#cms-msg .cms-status').text(' Loading 100%');
                    $('#cms-msg').append(data);
                }
            },
            error: function(XMLHttpRequest){
                var message = XMLHttpRequest && XMLHttpRequest.responseText ? XMLHttpRequest.responseText : 'Import failed.';
                $('#cms-msg').append('<br />' + message);
                $('#dummy-data').prop('disabled', false);
            }
        });
    }
    $(document).ready(function(){
    	$("#dummy-data").on("click",function(){
    		var r = confirm("Are you want import the demo data?");
        	if(r == true){
        		$('.cms-dummy-process').show();
	            var theme = $('#smof_data-theme .redux-image-select-selected').find('input').val() || 'libra';
	            $(this).attr('disabled','true');
	            $('#cms-msg .cms-status').text(' Loading ');
	            var p = 0;
	            var arr = ["options","widget","slider","grid"];
	            arr.forEach(function(entry){
	                p+=5;
	                cmsDummyData(entry,p,theme);
	            });
        	}
    	});
    });
})(jQuery)