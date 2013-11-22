var Pronamic_Section = function( post_id, id, position ) {
    this.post_id  = post_id;
    
    if ( undefined === id )
        id = null;
    
    if ( undefined === position )
        position = null;
    
    this.id       = id;
    this.position = position;
};

Pronamic_Section.prototype = {
    /**
     * Makes an AJAX request to move the current Section
     * up a position
     */
     moveUp: function() {
        jQuery.ajax({
              type: 'POST'
            , url: ajaxurl
            , data: {
                  action: 'pronamic_section_move_up'
                , post_id: this.post_id
                , current_id: this.id
                , position: this.position
            }
            , dataType: 'json'
            , success: function( data ) {
                console.log( data );
            }
            , failed: function(one,two,three) {
                console.log(one,two,three);
            }
        });
    }
    
    , moveDown: function() {
        jQuery.ajax({
              type: 'POST'
            , url: ajaxurl
            , data: {
                  action: 'pronamic_section_move_down'
                , post_id: this.post_id
                , current_id: this.id
                , position: this.position
            }
            , dataType: 'json'
            , success: function( data ) {
                console.log( data );
            }
            , failed: function( one, two, three ) {
                console.log( one, two, three );
            }
        });
    }
    
    , addSection: function( post_title ) {
        jQuery.ajax({
              type: 'POST'
            , url: ajaxurl
            , data: {
                  action: 'pronamic_section_add'
                , post_id: this.post_id
                , post_title: post_title
            }
            , dataType: 'json'
            , success: function( data ) {
                console.log(data);
            }
            , failed: function( one, two, three ) {
                console.log(one,two,three);
            }
        });
    }
    
    /**
     * Removes a section entirely.
     */
    ,  removeSection: function() {
        
    }
};

// Listeners
jQuery( function( $ ) {
    
    var textAreas = $( '#poststuff' ).find( 'textarea.wp-editor-area' );
    
    $.each( textAreas, function( index, element ) {
        var editor = tinyMCE.EditorManager.get( element.id );
        
        if ( editor ) {
            console.log( 'SOME: ',element.id );
            tinyMCE.execCommand( 'mceRemoveControl', true, element.id );
        }
        
        if ( ! editor ) {
            console.log( 'NONE: ', element.id);
            tinyMCE.execCommand( 'mceAddControl', true, element.id );
        }
    } );
    
    $( '.jPronamicSectionNewButton' ).click( function( e ) {
        e.preventDefault();
        
        var self = $( this ),
            post_id = self.data( 'post-id' ),
            post_title = self.siblings( '.jPronamicSectionNewTitle' ).val();
            
        
        var section = new Pronamic_Section( post_id );
        section.addSection( post_title );
    } );
    
} );
