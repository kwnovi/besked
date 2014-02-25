$(function(){

	var Navigation = Backbone.Router.extend({
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
	});

	var UserModel = Backbone.Model.extend({
	
	});

	var user = new UserModel(USER_DATA);

	var UserContacts = Backbone.Collection.extend({
  		model: UserModel,
  		url: "/besked/user/contacts"
	});

	var ContactsCollection = new UserContacts();

	var UserView = Backbone.View.extend({
		tagName: "li",
		el: $("#contacts-list ul")
		template: _.template($('#contact_template').html()),

		initialize: function() {
		    this.listenTo(this.model, "change", this.render);
		},

		render: function(){
			this.$el.html(this.template(this.model.attributes));
    		return this;
		}
	});

	var ContactsView = Backbone.View.extend({
		el: $("#contacts-list"),

		initialize: function() {
		    this.listenTo(this.collection, "change", this.render);
		    this.collection.fetch();
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
			    that.$el.append(userView.render().el);
			});
		}
	});

	var contacts = new ContactsView({collection: ContactsCollection});
});