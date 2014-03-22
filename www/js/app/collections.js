var UserCollection = Backbone.Collection.extend({//Collection = ensemble de modèle
		model: UserModel
});

var DiscussionCollection = Backbone.Collection.extend({//Collection = ensemble de modèle
		model: DiscussionModel,
		url: "discussions/user/all"
});

var MessageCollection = Backbone.Collection.extend({//Collection = ensemble de modèle
		model: MessageModel,
		comparator: 'created'
});