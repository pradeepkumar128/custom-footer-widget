jQuery(document).ready(function($){
     // Color Picker
     $('.cfw-color-field').wpColorPicker();
 
     // Media Uploader
     $('#cfw_upload_image_button').click(function(e) {
         e.preventDefault();
         var image_frame;
         if (image_frame) {
             image_frame.open();
         }
        
         image_frame = wp.media({
             title: 'Select Media',
             multiple : false,
             library : {
                 type : 'image',
             }
         });
 
         image_frame.on('close',function() {
             // On close, get selections and save to the hidden input
             var selection = image_frame.state().get('selection');
             var gallery_ids = [];
             var my_index = 0;
             selection.each(function(attachment) {
                 gallery_ids[my_index] = attachment['attributes']['url'];
                 my_index++;
             });
             var ids = gallery_ids.join(",");
             $('#cfw_image').val(ids);
             $('#cfw_image_preview').html('<img src="'+ids+'" style="max-width:200px;"/>');
         });
 
         image_frame.open();
     });
 });
 