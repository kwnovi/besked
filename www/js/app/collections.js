var UserCollection = Backbone.Collection.extend({//Collection = ensemble de modèle
		model: UserModel,
		url: "/besked/user/contacts",
		getResults: function(){
			var result = [];
			_(this.models).each(function(user){
				result.push(user.nickname);
			})
			return result;
		}
});

var DiscussionCollection = Backbone.Collection.extend({//Collection = ensemble de modèle
		model: DiscussionModel,
		url: "discussions/user/all"
})

var MessageCollection = Backbone.Collection.extend({//Collection = ensemble de modèle
		model: MessageModel
})