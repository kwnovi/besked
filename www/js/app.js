$(function(){

	var UserModel = Backbone.Model.extend({
	
	})

	var user = new UserModel(USER_DATA)
	console.debug(user)

	var UserContacts = Backbone.Collection.extend({
  		model: UserModel,
  		url: "/besked/user/contacts",
  		
	})

	var contacts = new UserContacts()

	contacts.fetch();

	console.debug(contacts)
})