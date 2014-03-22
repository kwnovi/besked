<!-- MENU -->
<nav id="A1">
  <h2><a href="/besked"><i class="fa fa-bolt"></i></a></h2>
  <h5>
    <a href ="#messages" rel="tooltip" data-original-title="Liste des conversations">
      <i class="fa fa-comments"></i> 
    </a>
  </h5> 
  <h5>
    <a href ="#" rel="tooltip" data-original-title="Liste des contacts">
     <i class="fa fa-bars"></i> 
    </a>
  </h5> 
  <h5>
    <a href ="#account" rel="tooltip" data-original-title="Paramètres de votre compte">
     <i class="fa fa-cog"></i> 
    </a>
  </h5> 
  <h5>
    <a  href="/besked/users/logout" rel="tooltip" data-original-title="Se déconnecter">
     <i class="fa fa-sign-out"></i>
    </a>
  </h5> 
</nav>
<aside id="A2">
  <div class="menu" id="B1">
   <strong>Messages</strong> 
    <span class="right">
      <a href="#add_contacts" rel="tooltip" data-original-title="Ajouter un contact"><i class="fa fa-plus"></i></a>
      <a href="#new_msg" rel="tooltip" data-original-title="Créer un nouveau message"><i class="fa fa-file-text-o"></i> </a>
    </span>
    <!-- <input type="text" class="form-control" placeholder="Rechercher ..." /> -->
    <br>
    <br>
    <div id="discussions-head-container" class="topic">
      <ul></ul>
    </div>
    <hr>
  </div>
  <!-- Fin de la première partie du menu  -->
  <div class="content-area" id="B2">
    <div id="contact-list"  >
      <ul></ul>  
    </div>
  </div>
</aside>

<!-- Derniers messages -->
<aside id="A4">
  <div class="content-area" id="B4">
    <div id="msg-list">
      <ul></ul>
    </div>
  </div>
</aside>

<div class="corpus">
  <!-- VUE A LA CONNEXION -->
  <div id="hello-view" class="corpus-view">
    <h1>Welcome Rachelle Sanschagrin !</h1>
    <p><strong>Meaningful but nonetheless useless shit here ..</strong>  </p>
    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
  </div>

  <!-- VUE AJOUTER CONTACT -->
  <div class="corpus-view" id="add-contact-view" style="display: none">
    
    <div class="description">
      <input id="add-contact" type="text" class="form-control searchbar" placeholder="Entrez les noms des contacts que vous voulez ajouter.."/>
      <div id="add-contact-resultbox" class="searchbar-resultbox">
        <ul></ul>
      </div>
    </div>
  </div>

  <!-- VUE CONTACT -->
  <div class="corpus-view" id="user-profile-view" style="display: none">
  </div>

    <!-- VUE ACCOUNT -->
  <div class="corpus-view" id="account-view" style="display: none">
    <form action="/user/edit" id="account-form" enctype="multipart/form-data" method="post" style="display: block">
      <div class="row">
        <div class="form-group col-xs-6">
          <label for="description">Description</label>
          <textarea class="form-control" type="text-area" row="3" name="description" style="height:200px!important" placeholder="Tell a bit more about yourself"></textarea>
        </div>
      </div>
      <div class="form-group">  
        <label for="picture">Picture</label>
        <input type="file" name="picture">
      </div>
      <button class="btn btn-primary">Submit</button>
    </form>
  </div>

  <!-- VUE NEW TOPIC -->
  <div class="corpus-view" id="new_topic" style="display: none">
    <h3>Contacts</h3>
    <div id="recipients-container"></div>
    <input id="new-contact-msg" type="text" class="form-control searchbar" placeholder="Entrez les noms des contacts que vous voulez ajouter.."/>
    <div id="add-contact-new-msg-resultbox" class="searchbar-resultbox">
      <ul></ul>
    </div>
    <hr>
    <!-- rajouter input pour le title, submit  -->
    <input  id="titleDiscussion" type="text" class="form-control" placeholder="Titre de la discussion"/>
    <textarea class="form-textarea" id="MSGGroup" rows="6"></textarea>
    <br/>
    <button type="button" class="btn btn-primary btn-sm" id="newTopic">Lancer la discussion</button>
  </div>

  <!-- VUE CHAT -->
  <div class="corpus-view" id="chat-view" style="display: none">
    
  </div>
</div>


<script type="text/template" id="contact_template">
  <% if(data.connected){ %> 
  <span class="size-ic connected"><i class="fa fa-circle"></i></span> <%= data.nickname %>
  <% } else { %>
  <span class="size-ic"><i class="fa fa-circle-o"></i></span> <%= data.nickname %>
  <% } %>
</script>

<script type="text/template" id="search_result_template">
  <a href="#user_profile/<%=data.id%>"><%=data.nickname%></a>
</script>


<script type="text/template" id="user-profile-template">
  <div class="photo"><img src="<%= model.picture_path %>" alt="Profil" class="img-circle"/></div>
  <h1><%= model.nickname %></h1>
  <div class="description">
  </div>
  <% if(is_contact){ %>
  <i class="fa fa-check fa-2x"></i>
  <% } else { %>
  <button id="btn-add" type="button" class="btn btn-primary">Ajouter</a>
  <% } %>
</script>

<script type="text/template" id="discussion-head-template">
  #<a href="#discussion/<%= model.id %>"> <%= model.title %></a><span class="next"><a class="btn-del" rel="tooltip" data-original-title="Supprimer"><i class="fa fa-times"></i></a></span>  
</script>

<script type="text/template" id="latest-message-template">
<a class="corps" href="#discussion/<%= message.get("discussion_id") %>">
  <h3 class="<%= (contact.get("connected"))?"selected":"" %>">
    <%= contact.get("nickname") %>
    <span class="next">
      <i class="fa fa-angle-double-right"></i>
    </span>
  </h3>
  <%= message.get("content").substr(0,100) %>
  <hr>
</a>
</script>

<script type="text/template" id="chat-view-template">
<!-- PROFIL -->
    <div class="profil" id="prof">
      <div class="description">
        <span class="titre">Rachelle Sanschagrin</span>
        <p class="connected"><i class="fa fa-circle"></i> <strong>En ligne </strong></p>
      </div>
    </div>
    <!-- MESSAGES -->
    <div class="conversation" id="conver">
      <article class="interlocuteur">
        <p class="msg">
          Définition : c’est une transformation de ressources dans le but de créer des biens et des services. Pour cela il va falloir coordonner et faire circuler des flux de création de valeurs, tout en assurant la ponctualité des rendez-vous avec le besoin client. 
        </p>
        <p class="datetime"><i class="fa fa-check-square-o"></i> 10:16 - 10.02.2014</p>
      </article>
      <article class="intervenant">
        <p class="msg">
       Ok, super cool ! 
        </p>
         <p class="datetime"><i class="fa fa-check-square-o"></i> 10:16 - 10.02.2014</p>
      </article>
    </div>
    <!-- CHATBAR -->
    <div id="chatbar">
     <input type="text"  id="chat"class="form-control" placeholder="Tapez votre message et appuyez sur Entrer pour l'envoyer">
    </div>
</script>

<script>
  var init_user_data = <?php echo $user; ?>;
  var init_contacts_data = <?php echo $contacts; ?>;
  var init_discussions_data = <?php echo $discussions; ?>;
  var init_messages_data = <?php echo $messages; ?>;
</script>
