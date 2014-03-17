$(function(){
	var Navigation = Backbone.Router.extend({
		routes: {
			"add_contacts": "add_contacts",
			"messages": "messages",
			"user_profile/:user_id": "user_profile",
			"account": "account",
			"new_msg":"new_msg"
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
			$("#new_topic").show();//id de la div 
		}
	});

	var UserModel = Backbone.Model.extend({});


	// 
	// 
	// 
	// COLLECTION 
	// 
	// 
	// 

	var UserCollection = Backbone.Collection.extend({//Collection = ensemble de modèle
  		model: UserModel,

  		getResults: function(){
  			var result = [];
  			_(this.models).each(function(user){
  				result.push(user.nickname);
  			})
  			return result;
  		}
	});


	// 
	// 
	// 
	// VIEW
	// 
	// 
	// 

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
		template: _.template("<%=data.nickname%>"),
		initialize: function(options) {
			this.model = options.model;
		    this.listenTo(this.model, "change", this.render);
		},
		render: function(){
			this.$el.html(this.template({data:this.model.attributes}));//le rendu
    		return this;
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
				contacts_collection.fetch();
				that.render();
				alertify.success("Le contact à bien été ajouté.")
			});
		}
	});

	var ContactsView = Backbone.View.extend({
		el: $("#contact-list>ul"),// point d'attache dans le dom 

		initialize: function() {
		    this.listenTo(this.collection, "change", this.render);
		    var that = this;
		    this._userViews = []; 
		    this.collection.each(function(user) {
		    	// rajout d'un element dans le tableau
		      that._userViews.push(new UserContactView({ 
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



	// 
	// 
	// 
	// APP, DECLARATIONS
	// 
	// 
	// 



	var nav = new Navigation();
	Backbone.history.start();
	
	var contacts_view;
	var contacts_collection = new UserCollection()
	contacts_collection.url = "/besked/user/contacts";
    contacts_collection.fetch({
    	success: function(){
    		contacts_view = new ContactsView({collection: contacts_collection});// this.collection <- ContactsCollection ref 29  (instancié en 29)
    		contacts_view.render();
    	},
    	error: function(){
    		console.log("error");
    	}
    });

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
            console.debug(list_el)
            index = -1;
            nb_items = 0; 
        } 
    }); 


  $("#newTopic").click(

        function() {
           $.ajax({
                    type: "POST",
                    url: "discussions/new",
                    data: { title: $("#titleDiscussion").val(), message: $("#MSGGroup").val()  }
                  })
                    .done(function( data ) {
                      alertify.success(data.message)
                    }); 

        }

    )


});

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
