var Pronamic_Sections_Admin = {
    config: {},
    ready: function() {
        Pronamic_Sections_Admin.tabs.ready();
    },
    tabs: {
        config: {},
        ready: function() {
            Pronamic_Sections_Admin.tabs.config.dom = {
                add_button: jQuery('.js-pronamic-sections-add-tab'),
                remove_button: jQuery('.js-pronamic-section-delete'),
                quantity: jQuery('.js-pronamic-sections-quantity'),
				tabs: jQuery('.js-pronamic-sections-holder'),
				order: jQuery('.js-pronamic-sections-order')
            };

            Pronamic_Sections_Admin.tabs.binds();
        },
        binds: function() {
            Pronamic_Sections_Admin.tabs.config.dom.add_button.click(Pronamic_Sections_Admin.tabs.add_tab);
            Pronamic_Sections_Admin.tabs.config.dom.remove_button.click(Pronamic_Sections_Admin.tabs.remove_tab);
			
			Pronamic_Sections_Admin.tabs.config.dom.tabs.sortable({
				connectWith:".js-pronamic-sections-holder",
				stop:Pronamic_Sections_Admin.tabs.on_sortable_stop
			});
			Pronamic_Sections_Admin.tabs.config.dom.tabs.disableSelection();
        },
        add_tab: function(e) {
            e.preventDefault();
            var current_quantity = Pronamic_Sections_Admin.tabs.config.dom.quantity.val();
			
            if( '' === current_quantity ) current_quantity = 0;

			current_quantity = parseInt( current_quantity );

            var new_quantity = current_quantity + 1;
			console.log(new_quantity);
			
            Pronamic_Sections_Admin.tabs.config.dom.quantity.val(new_quantity);

            jQuery('#post').submit();
        },
        remove_tab: function(e) {
            e.preventDefault();

			jQuery.ajax({
				type:'POST',
				url:ajaxurl,
				data:{
					action:'remove_tab',
					tab_id:jQuery(this).data('id'),
					post_id:jQuery('input[name=post_ID]').val()
				},
				dataType:'json',
				success:function(data) {
					console.log(data);
					window.location.reload();
				},
				error: function(a,b,c){
					console.log(a);
					console.log(b);
					console.log(c);
				}
			});
        },
		on_sortable_stop: function() {
			var order = jQuery('.js-pronamic-sections-order');
			var nbElems = order.length;
			jQuery('.js-pronamic-sections-order').each(function(id){
				jQuery(this).val(nbElems + id);
			});
		}
    }
};

jQuery(Pronamic_Sections_Admin.ready);

