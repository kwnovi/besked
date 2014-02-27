$(function(){

	/*var Navigation = Backbone.Router.extend({
		routes: {
			"contacts": contacts,
			"messages": messages
		},
		contacts: function(){
			$("#contact-list").show();
			$("#msg-list").hide();
		},
		messages: function(){
			$("#contact-list").hide();
			$("#msg-list").show();
		}
	});*/

	var UserModel = Backbone.Model.extend({
	
	});

	//var user = new UserModel(USER_DATA);

	var UserCollection = Backbone.Collection.extend({
  		model: UserModel,
  		url: "/besked/user/contacts"
	});

	var UserView = Backbone.View.extend({
		tagName: "li",
		//el: $("#contacts-list ul"),
		template: _.template($('#contact_template').html()),

		initialize: function() {
		    this.listenTo(this.model, "change", this.render);
		},

		render: function(){
			this.$el.html(this.template({data:this.model.attributes}));
    		return this;
		}
	});

	var ContactsView = Backbone.View.extend({
		el: $("#contact-list>ul"),

		initialize: function() {
		    this.listenTo(this.collection, "change", this.render);
		    var that = this;
		    this._userViews = []; 
		    this.collection.each(function(user) {
			    that._userViews.push(new UserView({
			    	model: user
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

	var contacts_view;
	var contacts_collection = new UserCollection();
    contacts_collection.fetch({
    	success: function(){
    		contacts_view = new ContactsView({collection: contacts_collection});
    		contacts_view.render();
    	},
    	error: function(){
    		console.log("error");
    	}
    });
	 
	
});