/**********************************
 *  GLOBAL SCOPE
 **********************************/

/* COLLECTIONS */
var contacts_collection = new UserCollection(init_contacts_data);
contacts_collection.url = "user/contacts"; 
var discussions_collection = new DiscussionCollection(init_discussions_data);
var latest_messages_collection = new MessageCollection(init_messages_data);

/* AUTOCOMPLETE UTILITIES */
var DOWN = 40; 
var UP = 38; 
var ENTER = 13; 
var ESCAPE = 27; 
var list_el = $(".searchbar-resultbox");
var searchbar_el = $('.searchbar');
var index = -1;
var nb_items = list_el.length;

function change_selection(){
  list_el.children().removeClass('selected');
  list_el.children().eq(index).addClass('selected');
  searchbar_el.val(list_el.children().eq(index).text().trim());
}

function redimension(){
//	$("body").css('height', window.innerHeight+"px");
	var height = window.innerHeight - $("#B1").outerHeight(true);
	$("#B2").css("max-height", height + 'px');

	var Theight = window.innerHeight ;
	$("#B4").css("max-height", Theight + 'px');

	var secondHeight = window.innerHeight - $("#chat-header").outerHeight(true) - $('#chatbar').outerHeight(true);
	$("#msg-container").css("height", secondHeight + 'px');
}

/**********************************
 *  APPLICATION
 **********************************/
$(function(){

	var user_profile_view;
	var chat_view;

	var Navigation = Backbone.Router.extend({
		routes: {
			"add_contacts": "add_contacts",
			"messages": "messages",
			"user_profile/:user_id": "user_profile",
			"account": "account",
			"new_msg":"new_msg",
			"discussion/:discussion_id": "chat"
		},
		add_contacts: function(){
			$(".corpus-view").hide();
			$("#add-contact-view").show();
		},
		messages: function(){
			$(".corpus-view").hide();
			$("#hello-view").show();
		},
		user_profile: function(user_id){
			$(".corpus-view").hide();
			$("#user-profile-view").show();
			user_profile_view = new UserProfileView({model: users_search_results.findWhere({id:user_id})});
			user_profile_view.render();
		},
		account:function(){
			$(".corpus-view").hide();
			$("#account-view").show();
		},
		new_msg:function(){
			$(".corpus-view").hide();
			$("#new_topic").show(); 
		},
		chat: function(discussion_id){
			$(".corpus-view").hide();
			$("#chat-view").show();
			chat_view = new ChatView({model: discussions_collection.findWhere({id:discussion_id})});
			// chat_view.render();
		}
	});

	var nav = new Navigation();
	Backbone.history.start();
	
	var contacts_view = new ContactsView({collection: contacts_collection});// this.collection <- ContactsCollection ref 29  (instancié en 29)
    contacts_view.render();

    var discussions_view = new DiscussionsView({collection: discussions_collection});// this.collection <- ContactsCollection ref 29  (instancié en 29)
    discussions_view.render();
    
    var latest_messages_view = new LatestMessagesView({
    	collection:latest_messages_collection
    });
    latest_messages_view.render();

    // à mettre dans le router
    var users_search_results = new UserCollection();
    users_search_results.url = function(){return 'users/nickname/' + this.search_term;};
    var users_search_results_view ;
    var collection;
    // CONTACT SEARCH

    searchbar_el.keyup(function(e){ 
        var search_term = $(this).attr('value').trim();
        if( search_term != ''){
        	if ($(this).attr('id') == 'add-contact') {
        		list_el = $("#add-contact-resultbox ul");
        	} else {
        		list_el = $("#add-contact-new-msg-resultbox ul");
        	}

        	if(e.keyCode == UP){
        		if(index <= 0){
			        index = nb_items-1;
			    } else {
			    	index--;
			    }
				change_selection();
        	} else if (e.keyCode == DOWN){
    			if(index > nb_items){
			        index = 0;
			    } else {
			    	index++;
			    }
				change_selection();
        	} else if (e.keyCode == ENTER){
				list_el.find('.selected').click();
        	} else if (e.keyCode == ESCAPE){
        		// marche pas
        		searchbar_el.val('');
        		list_el.empty();
        		users_search_results.reset();
        	} else {
        		if ($(this).attr('id') == 'add-contact') {
        			users_search_results.search_term = search_term;
	       			users_search_results.fetch({
		       			success: function(){
		       				users_search_results_view = new SearchResultsView({collection : users_search_results});
		       				users_search_results_view.render();
		       				nb_items = list_el.length;
		       			}
	       			});
        		} else {
        			var resultat = contacts_collection.where({nickname:search_term});
        			if(resultat.length > 0){
	        			var toto = new UserCollection(resultat);
						users_search_results_view = new SearchResultsViewAdd({collection : toto});
			       		users_search_results_view.render();
			       		nb_items = list_el.length;
			       	}
        		}
        	}
        } else { 
            list_el.empty();
            index = -1;
            nb_items = 0; 
        } 
    }); 

	$('#recipients-container').delegate('.remove-recipient', 'click', function(){
		$(this).remove();
	});

	$("#newTopic").click(function() {
		var _recipients = [];
		$("#recipients-container>button").each(function(item){
			_recipients.push($(this).attr('data-id'));
		});
        $.ajax({
                type: "POST",
                url: "discussions/new",
                data: { 
                	title: $("#titleDiscussion").val(), 
                	message: $("#MSGGroup").val(),
                	recipients: _recipients  
                }
              }).done(function( data ) {
              	 discussions_collection.fetch({
              	 	success:function(){
	              	 nav.navigate("discussion/"+data, {trigger: true});
              	 	}
              	 });
              });
    });

	// fix taille des zone de scroll
	redimension();
	$( window ).resize(redimension());

	//logout l'utilisateur à la sortie
	$( window ).unload(function() {
		$.get("/user/logout", null,function(data){
			console.log("logout");
		});
	});
});


