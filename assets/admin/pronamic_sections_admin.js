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
              context: this
            , type: 'POST'
            , url: ajaxurl
            , data: {
                  action: 'pronamic_section_move_up'
                , post_id: this.post_id
                , current_id: this.id
                , position: this.position
            }
            , dataType: 'json'
            , success: this.success
            , failed: this.failed
        });
    }
    
    , moveDown: function() {
        jQuery.ajax({
              context: this
            , type: 'POST'
            , url: ajaxurl
            , data: {
                  action: 'pronamic_section_move_down'
                , post_id: this.post_id
                , current_id: this.id
                , position: this.position
            }
            , dataType: 'json'
            , success: this.success
            , failed: this.failed
        });
    }
    
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
            type: 'POST'
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
    
    , setNoticeHolder: function( noticeHolder ) {
        this.noticeHolder = noticeHolder;
    }
    
    , success: function( data ) {
        if ( data.ret ) {
            this.showMessage( data.msg, 'success', this.noticeHolder );
        } else {
            this.showMessage( data.msg, 'failed', this.noticeHolder );
        }
    }
    
    , failed: function( one, two, three ) {
        console.log(one, two, three);
    }
    
    , showMessage: function( message, type, holderElement ) {
        var alertElement = jQuery( '<div></div>' );
        
        alertElement
                .addClass( 'pronamic_section_notification' )
                .addClass( 'pronamic_section_notification_' + type );
        
        alertElement.html( message );
        
        jQuery( holderElement ).html( alertElement );
    }
};

// Listeners
jQuery( function( $ ) {
    
    function buildSection( $el ) {
        var post_id    = $el.data( 'post-id' ),
            position   = $el.data( 'position' ),
            notice_h   = $el.data( 'notice-holder' ),
            current_id = $el.data( 'current-id' );
    
        var section = new Pronamic_Section( post_id, current_id, position );
        section.setNoticeHolder( notice_h );
        
        return section;
    }
    
    $( '.jPronamicSectionNewButton' ).click( function( e ) {
        e.preventDefault();
        console.log('clicked');
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
    } );
    
    $( '.jPronamicSectionName' ).click( function( e ) {
        e.stopPropagation();
    } );
} );
