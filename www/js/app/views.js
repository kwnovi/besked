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
					that.render();			
				}
			});
			alertify.success("Le contact a bien été ajouté.")
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
			alertify.success("La discussion a bien été supprimé.");
		});
	}
})

var DiscussionsView = Backbone.View.extend({
	el: "#discussions-head-container>ul",

	initialize: function() {
	    var that = this;
	    console.debug(this.el);
	    this._discussionViews = []; 
	    this.collection.each(function(discussion) {
	    	// rajout d'un element dans le tableau
	      that._discussionViews.push(new DiscussionHeadView({ 
	        model: discussion,
	      }));
	    });
	},

	render: function(){
		var that = this;
	    this.$el.empty();
		_(this._discussionViews).each(function(discussionView) {
		    $(that.el).append(discussionView.render().el);
		});
	}
})