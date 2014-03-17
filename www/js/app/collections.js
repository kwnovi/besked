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