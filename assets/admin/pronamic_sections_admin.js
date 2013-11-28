/**
 * A class function that is used to represent a specific
 * Pronamic_Section displayed.  Allows you to move it up
 * or down or remove it. Also can add a new Section, if only a post_id
 * is supplied
 * 
 * @param int post_id required
 * @param int id
 * @param int position
 * @returns Pronamic_Section
 */
var Pronamic_Section = function( post_id, id ) {
    this.post_id  = post_id;
    
    if ( undefined === id )
        id = null;
    
    this.id       = id;
};

Pronamic_Section.prototype = {
    /**
     * Makes an AJAX request to move the current Section
     * up a position
     */
     moveUp: function() {
        jQuery.ajax({
              context: this
            , type: 'POST'
            , url: ajaxurl
            , data: {
                  action: 'pronamic_section_move_up'
                , post_id: this.post_id
                , current_id: this.id
            }
            , dataType: 'json'
            , success: this.success
            , failed: this.failed
        });
    }
    
    /**
     * Makes an AJAX request to move the current Section
     * down a position
     */
    , moveDown: function() {
        jQuery.ajax({
              context: this
            , type: 'POST'
            , url: ajaxurl
            , data: {
                  action: 'pronamic_section_move_down'
                , post_id: this.post_id
                , current_id: this.id
            }
            , dataType: 'json'
            , success: this.success
            , failed: this.failed
        });
    }
    
    /**
     * Makes an AJAX request to add a new section to this current
     * post ID.
     * 
     * Requires only a title.
     * 
     * @param string post_title
     */
    , add: function( post_title ) {
        jQuery.ajax({
              context: this
            , type: 'POST'
            , url: ajaxurl
            , data: {
                  action: 'pronamic_section_add'
                , post_id: this.post_id
                , post_title: post_title
            }
            , dataType: 'json'
            , success: this.success
            , failed: this.failed
        });
    }
    
    /**
     * Removes a section entirely.
     */
    ,  remove: function() {
        jQuery.ajax({
            context: this
            , type: 'POST'
            , url: ajaxurl
            , data: {
                  action: 'pronamic_section_remove'
                , current_id: this.id
            }
            , dataType: 'json'
            , success: this.success
            , failed: this.failed
        });
    }
    
    /**
     * Pass in an element identifier than can be used as where
     * the success and failed messages from the AJAX request are sent to.
     * 
     * @param string noticeHolder
     */
    , setNoticeHolder: function( noticeHolder ) {
        this.noticeHolder = noticeHolder;
    }
    
    /**
     * Is the callback for the AJAX requests from the other
     * prototype methods.  Will do nothing is a noticeHolder 
     * is not set.
     * 
     * @param json data
     */
    , success: function( data ) {
        if ( ! this.noticeHolder )
            return;
        
        if ( data.ret ) {
            this.showMessage( data.msg, 'success' );
        } else {
            this.showMessage( data.msg, 'failed' );
        }
    }
    
    /**
     * Failed function callback, just used for debugging at the moment
     */
    , failed: function( one, two, three ) {
        console.log(one, two, three);
    }
    
    /**
     * Shows a message into the defined noticeHolder. Requires a
     * string message to show as text, and a type, which defines the
     * style and color of the message box.
     * 
     * @param string message
     * @param string type
     */
    , showMessage: function( message, type ) {
        var alertElement = jQuery( '<div></div>' );
        
        alertElement.addClass( 'pronamic_section_notification' );
        
        if ( 'success' === type ) {
            alertElement.addClass( 'updated' );
        } else {
            alertElement.addClass( 'form-invalid' );
        }
        
        alertElement.html( '<p>' + message + '</p>' );
        
        jQuery( this.noticeHolder ).append( alertElement );
    }
};

// Listeners
jQuery( function( $ ) {
    
    function buildSection( $el ) {
        var post_id    = $el.data( 'post-id' ),
            notice_h   = $el.data( 'notice-holder' ),
            current_id = $el.data( 'current-id' );
    
        var section = new Pronamic_Section( post_id, current_id );
        section.setNoticeHolder( notice_h );
        
        return section;
    };
    
    $( '.jPronamicSectionNewButton' ).click( function( e ) {
        e.preventDefault();
        
        var self       = $( this ),
            post_title = self.siblings( '.jPronamicSectionNewTitle' ).val();
            
        var section = buildSection( self );
        
        section.add( post_title );
    } );
    
    $( '.jPronamicSectionExistingMoveUp' ).click( function( e ) {
        e.preventDefault();
        
        var self       = $( this ),
            section    = buildSection( self );
            
        section.moveUp();
    } );
    
    $( '.jPronamicSectionExistingMoveDown' ).click( function( e ) {
        e.preventDefault();
        
        var self       = $( this ),
            section    = buildSection( self );
            
        section.moveDown();
    } );
    
    $( '.jPronamicSectionExistingRemove' ).click( function( e ) {
        e.preventDefault();
        
        var self       = $( this ),
            section    = buildSection( self );
            
        section.remove();
        self.closest( '.jPronamicSectionHolder' ).remove();
    } );
    
    $( '.jPronamicSectionName' ).click( function( e ) {
        e.stopPropagation();
    } );
} );
