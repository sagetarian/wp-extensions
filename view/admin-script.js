jQuery(function() {

	// fix for the tinymce editor on the taxonomy inputs
	jQuery('#addtag input#submit').on('click', function() {

		tinyMCE.triggerSave();

	});

	// multiple select handlers for all multiple selects
	jQuery( 'body' ).on( 'wpext-add-row', function() {

		jQuery('.wpext-multiple-select.source').each( function() {

			try {
				wpext_attach_multiple_select( jQuery(this).attr( 'id' ) );
			} catch( exception ) { }

		});

	});

});

function wpext_attach_multiple_select( field_id, name ) {

	var el = jQuery('.wpext-multiple-select.source#'+field_id);
	
	if( !el.length || jQuery( '.wpext-multiple-select.source#'+field_id ).data( 'wpext-attached' ) )
		return;

	jQuery( '.wpext-multiple-select.source#'+field_id ).data( 'wpext-attached', true );

	var name = jQuery( '.wpext-multiple-select.source#'+field_id ).attr('name');
	var original_template = jQuery('input[data-name="'+name+'"]');
	
	var dropevent = function() {

		jQuery('input[data-source="'+field_id+'"]').remove();
		jQuery('#'+field_id+'-destination li').each( function() {
			var template = original_template.clone();
			template
				.attr( 'data-name', null )
				.attr( 'data-source', field_id )
				.attr( 'name', name+"[]" )
				.val( jQuery(this).attr('data-value') );
			original_template.after( template );
		});

	};

	jQuery('form').submit( dropevent );

	var reorder = function() {

		var list = jQuery('#'+field_id);
		var listitems = list.children('li').get();
		listitems.sort(function(a, b) {
		   return jQuery(a).text().toUpperCase().localeCompare(jQuery(b).text().toUpperCase());
		})
		jQuery.each(listitems, function(idx, itm) { list.append(itm); });

		list = jQuery('#'+field_id+'-destination');
		listitems = list.children('li').get();
		listitems.sort(function(a, b) {
		   return jQuery(a).text().toUpperCase().localeCompare(jQuery(b).text().toUpperCase());
		})
		jQuery.each(listitems, function(idx, itm) { list.append(itm); });

	};

	jQuery('#'+field_id+' li').draggable({
		revert: "invalid",
		helper: "clone",
		start: function(e, ui) {
			jQuery(ui.helper).addClass("ui-draggable-helper");
		}
	});

	jQuery('#'+field_id+'-destination').droppable({
		accept: '#'+field_id+' li',
		drop: function( event, ui ) {
			jQuery( this ).append( ui.draggable[0] );
			reorder();
		}
	});

	jQuery('#'+field_id+'-destination li').draggable({
		revert: "invalid",
		helper: "clone",
		start: function(e, ui) {
			jQuery(ui.helper).addClass("ui-draggable-helper");
		}
	});

	jQuery('#'+field_id).droppable({
		accept: '#'+field_id+'-destination li',
		drop: function( event, ui ) {
			jQuery( this ).append( ui.draggable[0] );
			reorder();
		}
	});

	reorder();

}