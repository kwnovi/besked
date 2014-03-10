    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand"></h3>
              <ul class="nav masthead-nav">
              </ul>
            </div>
          </div>

          <div class="inner cover">
            <header>
             
            <h2><a href="#">Besked</a></h2>
             <h4>Messaging system made shockingly simple.</h4>
            <div class="global_button" id="ctl-buttons" style="display: <?php echo ($signup_data || $login_data)?'none':'block';?>">
              <button id="btn-login">Login</button> 
              
              <button id="btn-signup">Signup</button>
            </div>
          </header>
            <div style="width: 250px;margin: 0 auto 0 auto;">
              <form id="login-form" action="<?php echo __ROOT__;?>users/login" method="post" style="display: <?php echo ($login_data)?'block':'none';?>" class="form-horizontal" role="form">
                <div class="form-group">
                  <input type="email" class="form-control" name="email" placeholder="email"><br/>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password" placeholder="password"><br/>
                  <?php if($login_data) echo "<span class=\"help-block\">$login_data</span>";?> 
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-lg btn-default">Signin</button>
                </div>
              </form>
              <form id="signup-form" action="<?php echo __ROOT__;?>users/signup" method="post" style="display: <?php echo ($signup_data)?'block':'none';?>" class="form-horizontal" role="form">
              <?php if(!$signup_data):?>
                <div class="form-group">
                  <input type="nickname" class="form-control" name="nickname" placeholder="nickname"><br/>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" name="email" placeholder="email"><br/>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password" placeholder="password"><br/>
                </div>
              <?php else:?>
              <?php if($signup_data['nickname']['error']):?>
                <div class="form-group has-error has-feedback">
                  <input type="nickname" class="form-control" name="nickname" placeholder="nickname"><br/>
                  <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                  <span class="help-block"><?php echo $signup_data['nickname']['message'];?></span>
                </div>
              <?php else: ?>
                <div class="form-group has-success has-feedback">
                  <input type="nickname" class="form-control" name="nickname" placeholder="nickname"><br/>
                  <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                </div>
              <?php endif ?>
              <?php if($signup_data['email']['error']):?>
                <div class="form-group has-error has-feedback">
                  <input type="email" class="form-control" name="email" placeholder="email"><br/>
                  <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                  <span class="help-block"><?php echo $signup_data['email']['message'];?></span>
                </div>
              <?php else: ?>
                <div class="form-group has-success has-feedback">
                  <input type="email" class="form-control" name="email" placeholder="email"><br/>
                  <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                </div>
              <?php endif ?>
              <?php if($signup_data['password']['error']):?>
                <div class="form-group has-error has-feedback">
                  <input type="password" class="form-control" name="password" placeholder="password"><br/>
                  <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                  <span class="help-block"><?php echo $signup_data['password']['message'];?></span>
                </div>
              <?php else: ?>
                <div class="form-group has-success has-feedback">
                  <input type="password" class="form-control" name="password" placeholder="password"><br/>
                  <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                </div>
              <?php endif ?>
              <?php endif ?>
                <div class="form-group">
                  <button type="submit" class="btn btn-lg btn-default">Signup</button>
                </div>
              </form>
            </div>
          </div> 
        </div>


        </div>

      </div>

    </div>

    <script type="text/javascript">
      window.onload = function() {    
        
        $('#btn-login').click(function(){
          $('#ctl-buttons').hide();
          $('#login-form').show();
        })

        $('#btn-signup').click(function(){
          $('#ctl-buttons').hide();
          $('#signup-form').show();
        })
      }
    </script>