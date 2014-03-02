$(function(){
	var Navigation = Backbone.Router.extend({
		routes: {
			"add_contacts": "add_contacts",
			"messages": "messages"
		},
		add_contacts: function(){
			$(".corpus-view").each(function(){
				$(this).hide();
			});
			$("#add-contact-view").show();
		},
		messages: function(){
			$(".corpus-view").each(function(){
				$(this).hide();
			});
			$("#hello-view").show();
		}
	});

	var UserModel = Backbone.Model.extend({});

	//var user = new UserModel(USER_DATA);

	var UserCollection = Backbone.Collection.extend({//Collection = ensemble de modèle
  		model: UserModel,
	});

	var UserView = Backbone.View.extend({
		tagName: "li",
		template: _.template($("#"+this.template_id).html()),

		initialize: function() {
		    this.listenTo(this.model, "change", this.render);
		},

		render: function(){
			this.$el.html(this.template({data:this.model.attributes}));//le rendu
    		return this;
		}
	});

	var ContactsView = Backbone.View.extend({
		el: $("#contact-list>ul"),// point d'attache dans le dom 

		initialize: function() {
		    this.listenTo(this.collection, "change", this.render);
		    var that = this;
		    this._userViews = []; 
		    this.collection.each(function(user) {
		      that._userViews.push(new UserView({ // rajout d'un element dans le tableau
		        model: user,
		        template_id: "contact_template"
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
		el: $("#contact-list>ul"),// point d'attache dans le dom 

		initialize: function() {
		    this.listenTo(this.collection, "change", this.render);
		    var that = this;
		    this._userViews = []; 
		    this.collection.each(function(user) {
		      that._userViews.push(new UserView({ // rajout d'un element dans le tableau
		        model: user,
		        template_id: "search_result_template"
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
	})

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
    users_search_result.url = function(){return 'users/nickname/' + this.search_term;}
    var users_search_results_view = new SearchResultsView();
    // CONTACT SEARCH
    $('#add-contact-searchbar').keyup(function(){ 
        var search_term = $(this).attr('value');
        if( search_term != ''){ 
       		users_search_results.search_term = search_term;
       		users_search_results.fetch({
       			success: function(){
       				users_search_results_view.collection = users_search_results;
       				users_search_results_view.render();
       			}
       		});
        } 
        else { 
            $('.result').html(''); 
        } 
    }); 
    
    $('.result li').click(function(){ 
	    var result_val = $(this).children("a").text(); 
	    $('.autosuggest').attr('value',result_val); 
	    $('.result').html(''); 	      
	    var lien = $(this).children('a').attr('href'); 
	}); 

    // pour enlever le dropdown quand on clic hors du dropdown 
    $("*").not('.autosuggest').click(function(){ 
        $('.result').html(''); 
    }); 
});