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
            <p class="lead">Besked</p>
            <p class="lead">Messaging system made shockingly simple.</p>
            <p class="lead" id="ctl-buttons" style="display: <?php echo ($signup_data || $login_data)?'none':'block';?>">
              <a href="#" id="btn-login"class="btn btn-lg btn-default">Login</a>
              <a href="#" id="btn-signup"class="btn btn-lg btn-default">Signup</a>
            </p>
            <div style="width: 250px;margin: 0 auto 0 auto;">
              <form id="login-form" action="<?php echo __ROOT__;?>users/login" method="post" style="display: <?php echo ($login_data)?'block':'none';?>" class="form-horizontal" role="form">
                <div class="form-group">
                  <input type="email" class="form-control" name="email" placeholder="email">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password" placeholder="password">
                  <?php if($login_data) echo "<span class=\"help-block\">$login_data</span>";?> 
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-lg btn-default">Signin</button>
                </div>
              </form>
              <form id="signup-form" action="<?php echo __ROOT__;?>users/signup" method="post" style="display: <?php echo ($signup_data)?'block':'none';?>" class="form-horizontal" role="form">
              <?php if(!$signup_data):?>
                <div class="form-group">
                  <input type="nickname" class="form-control" name="nickname" placeholder="nickname">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" name="email" placeholder="email">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password" placeholder="password">
                </div>
              <?php else:?>
              <?php if($signup_data['nickname']['error']):?>
                <div class="form-group has-error has-feedback">
                  <input type="nickname" class="form-control" name="nickname" placeholder="nickname">
                  <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                  <span class="help-block"><?php echo $signup_data['nickname']['message'];?></span>
                </div>
              <?php else: ?>
                <div class="form-group has-success has-feedback">
                  <input type="nickname" class="form-control" name="nickname" placeholder="nickname">
                  <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                </div>
              <?php endif ?>
              <?php if($signup_data['email']['error']):?>
                <div class="form-group has-error has-feedback">
                  <input type="email" class="form-control" name="email" placeholder="email">
                  <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                  <span class="help-block"><?php echo $signup_data['email']['message'];?></span>
                </div>
              <?php else: ?>
                <div class="form-group has-success has-feedback">
                  <input type="email" class="form-control" name="email" placeholder="email">
                  <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                </div>
              <?php endif ?>
              <?php if($signup_data['password']['error']):?>
                <div class="form-group has-error has-feedback">
                  <input type="password" class="form-control" name="password" placeholder="password">
                  <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                  <span class="help-block"><?php echo $signup_data['password']['message'];?></span>
                </div>
              <?php else: ?>
                <div class="form-group has-success has-feedback">
                  <input type="password" class="form-control" name="password" placeholder="password">
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
          <div class="mastfoot">
            <div class="inner">
              <p>Cover template for <a href="http://getbootstrap.com">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
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