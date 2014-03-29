var UserContactView = Backbone.View.extend({
		tagName: "li",
		template: _.template($("#contact_template").html()),
		initialize: function(options) {
			this.model = options.model;
		    this.listenTo(this.model, "change", this.render);
		},

		render: function(){
			this.$el.html(this.template({data:this.model.attributes}));//le rendu
    		return this;
		}
	});

var UserSearchView = Backbone.View.extend({
	tagName: "li",
	template: _.template($("#search_result_template").html()),
	initialize: function(options) {
		this.model = options.model;
	    this.listenTo(this.model, "change", this.render);
	},
	render: function(){
		this.$el.html(this.template({data:this.model.attributes}));//le rendu
		return this;
	}
});

var UserSearchViewAdd = Backbone.View.extend({
	tagName: "li",
	attributes:{class:"AttributeContact"},
	template: _.template("<a class=\"AttributeContact\" data-id=\"<%= data.id %>\"><%=data.nickname%></a>"),
	events:{
		"click .AttributeContact": "add"
	},
	initialize: function(options) {
		this.model = options.model;
	    this.listenTo(this.model, "change", this.render);
	},
	render: function(){
		this.$el.html(this.template({data:this.model.attributes}));//le rendu
		this.delegateEvents();
		return this;
	},
	add: function(e){
		var that = $(e.target);
		if($("#recipients-container").find('button[data-id='+that.attr('data-id')+']').length == 0){
			$("#recipients-container").append('<button class="btn btn-default remove-recipient" type="button" data-id="'+that.attr('data-id')+'">'+that.html()+'<span class="glyphicon glyphicon-remove "></span></button>')
		}
	}
});


var UserProfileView = Backbone.View.extend({
	el: $("#user-profile-view"),
	template: _.template($("#user-profile-template").html()),
	events:{
		"click #btn-add": "add"
	},
	render: function(){
		this.$el.html(this.template({
			model:this.model.attributes,
			is_contact: contacts_collection.findWhere({id: this.model.id}) != null
			})
		);//le rendu
		this.delegateEvents();
		return this;
	},
	add: function(){
		var that = this;
		$.get("/besked/user/add_contact/"+this.model.id, null,function(data){
			contacts_collection.fetch({
				success: function(){
					alertify.success("Le contact a bien été ajouté.");
				}
			});
		});
	}
});

var ContactsView = Backbone.View.extend({
	el: $("#contact-list>ul"),// point d'attache dans le dom 

	initialize: function() {
		// en cas de changement sur la collection on regénère la vue
	    this.listenTo(contacts_collection, "change", this.render);
	    var that = this;
	    // tableau de vues du model des users
	    this._userViews = []; 
	    contacts_collection.each(function(user) {
	    	// rajout d'un element dans le tableau
	      that._userViews.push(new UserContactView({ 
	        model: user,
	      }));
	    });
	    // en cas d'ajout de contact on rajoute la vue correspondante
	    contacts_collection.on("add", function(usr){
	    	that._userViews.push(new UserContactView({ 
	        	model: usr
	      	}));
	    });
	},

	render: function(){
		var that = this;
		// on nettoie la zone avant d'écrire
	    this.$el.empty();
	    if(this.collection.length == 0){
	    	$(that.el).append("<a href='#add_contacts'>Pas de contacts, voulez-vous en rajouter ?</a>");
	    } else {
	    	// Pour chaques vues on appelle son render qu'on ajoute au el
			_(this._userViews).each(function(userView) {
			    $(that.el).append(userView.render().el);
			});
		}
	}
});

var SearchResultsView = Backbone.View.extend({
	el: "#add-contact-resultbox>ul",// point d'attache dans le dom 

	initialize: function() {
	    //this.listenTo(this.collection, "change", this.render);
	    var that = this;
	    this._userViews = []; 
	    this.collection.each(function(user) {
	    	// rajout d'un element dans le tableau
	      that._userViews.push(new UserSearchView({ 
	        model: user,
	      }));
	    });
	},

	render: function(){
		var that = this;
	    this.$el.empty();
		_(this._userViews).each(function(userView) {
		    $(that.el).append(userView.render().el);
		});
	}
});


var SearchResultsViewAdd = Backbone.View.extend({
	el: "#add-contact-new-msg-resultbox>ul",// point d'attache dans le dom 

	initialize: function() {
	    //this.listenTo(this.collection, "change", this.render);
	    var that = this;
	    this._userViews = []; 
	    this.collection.each(function(user) {
	    	// rajout d'un element dans le tableau
	      that._userViews.push(new UserSearchViewAdd({ 
	        model: user,
	      }));
	    });
	},

	render: function(){
		var that = this;
	    this.$el.empty();
		_(this._userViews).each(function(userView) {
		    $(that.el).append(userView.render().el);
		});
	}
});

var DiscussionHeadView = Backbone.View.extend({
	tagName: 'li',
	template : _.template($("#discussion-head-template").html()),
	events:{
		"click .btn-del": "del"
	},
	render: function(){
		this.$el.html(this.template({model:this.model.attributes}));//le rendu
		this.delegateEvents();
		return this;
	},
	del: function(){
		var that = this;
		$.get("discussion/delete/"+this.model.id, null,function(data){
			discussions_collection.fetch({
				success: function(){
					that.render();
				}
			});
			//alertify.success("La discussion a bien été supprimé.");
		});
	}
})

var DiscussionsView = Backbone.View.extend({
	el: "#discussions-head-container>ul",

	initialize: function() {
	    var that = this;
	    this.listenTo(this.collection, "change", this.render);
	    this._discussionViews = []; 
	    this.collection.each(function(discussion) {
	    	// rajout d'un element dans le tableau
	      that._discussionViews.push(new DiscussionHeadView({ 
	        model: discussion,
	      }));
	    });
	    this.collection.on("add", function(dis){
	    	that._discussionViews.push(new DiscussionHeadView({ 
	        	model: dis
	      	}));
	    });
	},

	render: function(){
		var that = this;
	    if(this.collection.length == 0){
	    	$(that.el).append("<a href='#new_msg'>Pas de discussion, voulez-vous en créer une ?</a>");
	    } else {
		    this.$el.empty();
			_(this._discussionViews).each(function(discussionView) {
			    $(that.el).append(discussionView.render().el);
			});
		}
	}
});

var LatestMessageView = Backbone.View.extend({
	tagName: 'li',
	template: _.template($("#latest-message-template").html()),
	events:{
		"click #btn-add": "open"
	},
	render: function(){
		this.$el.html(this.template({
			message:this.model.message,
			contact: this.model.contact
			})
		);//le rendu
		return this;
	},
	open:function(){

	}
});

var LatestMessagesView = Backbone.View.extend({
	el: "#msg-list>ul",

	initialize: function() {
	    var that = this;
	    this._messageViews = []; 
	    this.collection.each(function(_message) {
	      that._messageViews.push(new LatestMessageView({ 
	        model: { 
	        	"message": _message,
	        	"contact": contacts_collection.findWhere({id:_message.get("user_id")})
	        }
	      }));
	    });
	},

	render: function(){
		var that = this;
	    if(this.collection.length == 0){
	    	$(that.el).append("Pas de nouveaux messages.");
	    } else {
			this.$el.empty();
			_(this._messageViews).each(function(messageView) {
			    $(that.el).append(messageView.render().el);
			});
		}
	}
});

var ParticipantView = Backbone.View.extend({
	tagName:'div',
	attributes: {
		class:'profil'
	},
	template: _.template($("#participant-template").html()),
	render: function(){
		this.$el.html(this.template({model:this.model.attributes}));
		return this;
	}
});

var ParticipantsView = Backbone.View.extend({
	el: "#participants-container",
	initialize: function() {
	    var that = this;
	    this._userViews = []; 
	    this.collection.each(function(user) {
	      that._userViews.push(new ParticipantView({ 
	        model: user,
	      }));
	    });
	},
	render: function(){
		var that = this;
	    this.$el.empty();
		_(this._userViews).each(function(userView) {
		    $(that.el).append(userView.render().el);
		});
		return this;
	}
});

var MessageChatView = Backbone.View.extend({
	tagName: 'article',
	template: _.template($("#message-chat-template").html()),
	attributes: function(){
		return {class: "clearfix "+ ((this.model.message.get("user_id") == init_user_data.id)?"intervenant":"interlocuteur")};
	},
	render: function(){
		console.debug(this.model);
		this.$el.html(this.template({
			message:this.model.message.attributes,
			contact: this.model.contact.attributes
			})
		);//le rendu
		return this;
	}
});

var MessagesChatView = Backbone.View.extend({
	el: "#msg-container",
	initialize: function() {
	    var that = this;
	    this._messageViews = []; 
	    this.listenTo(this.collection, "change", this.render);
	    this.collection.each(function(_message) {
	    	var contact_tmp = (_message.get("user_id") == USER.id)?USER:contacts_collection.findWhere({id:_message.get("user_id")});
	    	that._messageViews.push(new MessageChatView({ 
	        	model: { 
		        	"message": _message,
		        	"contact": contact_tmp
	        	}
	    	}));
	    });
	    this.collection.on("add", function(_message){
	    	var contact_tmp = (_message.get("user_id") == init_user_data.id)?init_user_data.id:contacts_collection.findWhere({id:_message.get("user_id")});
	    	that._messageViews.push(new MessageChatView({ 
				model: { 
		        	"message": _message,
		        	"contact": contact_tmp
	        	}      	
	    	}));
	    });
	},
	render: function(){
		var that = this;
	    this.$el.empty();
		_(this._messageViews).each(function(messageView) {
		    $(that.el).append(messageView.render().el);
		});
		return this;
	}
});

var ChatView = Backbone.View.extend({
	el: "#chat-view",
	events: {
		"keyup #chat": "keyup"
	},
	initialize: function() {
		var that = this;
		this.delegateEvents();
		this.participants_collection = new UserCollection();
		this.participants_collection.url = 'discussions/participants/'+this.model.id;
		this.messages_collection = new MessageCollection();
		this.messages_collection.url = 'discussions/messages/'+this.model.id;

		// quand les 2 fetch sont terminés
		$.when(this.participants_collection.fetch(), this.messages_collection.fetch()).done(
			// success
			function(){
				that.messages_chat_view = new MessagesChatView({collection:that.messages_collection});
				that.participants_view = new ParticipantsView({collection:that.participants_collection});
				that.render();
			}
		);
	},
	render: function(){
		this.messages_chat_view.render();
		this.participants_view.render();
		redimension();
		this.delegateEvents();
		return this;
	},
	keyup: function(e){
		var that = this;
		if(e.keyCode == ENTER){
			 $.ajax({
                type: "POST",
                url: "discussions/add-msg",
                data: { 
                	discussion_id : this.model.id,
                	message: $("#chat").val()
                }
              }).done(function( data ) {
              	$("#chat").val("");
              	that.messages_collection.fetch({success:function(){ that.render();}})
              });
		}
	}
});
