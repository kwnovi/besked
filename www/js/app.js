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

<<<<<<< HEAD
	var UserContacts = Backbone.Collection.extend({ //Collection = ensemble de modèle 
=======
	var UserCollection = Backbone.Collection.extend({
>>>>>>> 03fedda40c1aa5df4d546c6ee3bee7d2498b4cb4
  		model: UserModel,
  		url: "/besked/user/contacts"
	});

	var UserView = Backbone.View.extend({
		tagName: "li",
<<<<<<< HEAD
		el: $("#contacts-list ul"), // point d'attache dans le dom 
=======
		//el: $("#contacts-list ul"),
>>>>>>> 03fedda40c1aa5df4d546c6ee3bee7d2498b4cb4
		template: _.template($('#contact_template').html()),

		initialize: function() {
		    this.listenTo(this.model, "change", this.render);
		},

		render: function(){
<<<<<<< HEAD
			this.$el.html(this.template(this.model.attributes)); //le rendu 
=======
			this.$el.html(this.template({data:this.model.attributes}));
>>>>>>> 03fedda40c1aa5df4d546c6ee3bee7d2498b4cb4
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
<<<<<<< HEAD
		      that._userViews.push(new UserView({ // rajout d'un element dans le tableau
		        model: user
		      }));
=======
			    that._userViews.push(new UserView({
			    	model: user
			    }));
>>>>>>> 03fedda40c1aa5df4d546c6ee3bee7d2498b4cb4
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

<<<<<<< HEAD
	var contacts = new ContactsView({collection: ContactsCollection}); // this.collection <- ContactsCollection ref 29  (instancié en 29)
=======
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
	 
	
>>>>>>> 03fedda40c1aa5df4d546c6ee3bee7d2498b4cb4
});