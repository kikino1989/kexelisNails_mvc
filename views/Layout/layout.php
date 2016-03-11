<?php $user = null;?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="robots" content="INDEX,FOLLOW" />

<!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1">
  
<?php if($this->meta !== null): foreach ($this->meta as $metaName => $metaValue):?>
	<meta name="<?php echo strip_tags($metaName);?> "content="<?php echo strip_tags($metaValue);?>" />
<?php endforeach; endif; ?>

<meta name="author" content="Enrique Gonzalez" />

<title><?php echo $this->title;?></title>

<!-- load external libs -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo $this->path('utils/bootstrap/css/bootstrap.css'); ?>" />
<script src="<?php echo $this->path('utils/jquery/jquery.js'); ?>"></script>
<script src="<?php echo $this->path('utils/js/functions.js'); ?>"></script>

<!-- loads the layouts for the pages -->
<link rel="stylesheet" media="(max-width: 900px)" href="<?php echo $this->path('utils/css/mobile/Layout/layout.css');?>">
<link rel="stylesheet" media="(min-width: 900px)" href="<?php echo $this->path('utils/css/pc/Layout/layout.css');?>">

<!-- loads the css style for a phone -->
<link rel="stylesheet" media="(max-width: 900px)" href="<?php if($this->css !== null ) echo $this->path('utils/css/mobile/'.$this->css);?>">
<!-- loads the css style for a pc -->
<link rel="stylesheet" media="(min-width: 900px)" href="<?php if($this->css !== null ) echo $this->path('utils/css/pc/'.$this->css);?>">

<script src="<?php echo $this->path('utils/js/layout/layout.js');?>"></script>
<script src="<?php if($this->js !== null ) echo $this->path($this->js);?>"></script>
</head>

<body>
	<div class="main-container">
		<nav class="main-nav">
			<div class="menu-icon">
				<a href="#">
					<button id="menu-btn" class="btn btn-default menu-btn">
						<span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true" aria-label="menu icon"></span>
					</button>
				</a>
			</div>
			
			<ul id="folding-menu" class="hid">
				<!--li>
					<a href="#">
				  		<form role="search">
						  <div class="form-group">
						    <input type="text" placeholder="Search">
						  </div>
						  <button type="submit" class="btn btn-default searcher">
						  	<span class="glyphicon glyphicon-search" aria-hidden="true" aria-label="menu icon"></span>
						  </button>
						</form>
					</a>
				</li-->
				<li>
					<a href="<?php echo $this->path('index'); ?>" title="go back to home">Home</a>
				</li>
				<li>
					<a href="<?php echo $this->path('gallery/index/1/5'); ?>" title="review our work">Gallery</a>
				</li>
				<li>
					<a href="<?php echo $this->path('account'); ?>" title="manage your account">Account</a>
				</li>
				<li>
					<a href="<?php echo $this->path('staff/index/1/5'); ?>" title="get to know us">Staff</a>
				</li>
				<li class="register-link">
					<?php if(!isset($_SESSION['user'])):?>
						<a href="<?php echo $this->path('Account/register');?>">Register</a>
					<?php else : $user = $_SESSION['user'];?>
						<a href="<?php echo $this->path('Account/logout');?>"> <?php echo ucfirst($_SESSION['user']->firstname);?> logout</a>
					<?php endif;?>
				</li>
				<?php
				if($user !== null){
					switch($user->role){
						case 'admin':
							require_once 'views/AdminAccount/nav.php';
							break;
						case 'employee':
							require_once 'views/EmployeeAccount/nav.php';
							break;
						case 'user':
							require_once 'views/Account/nav.php';
							break;
						default:
							require_once 'views/Account/nav.php';
							break;
					}
				}
				?>
			</ul>
		</nav>
		
		<article id="content" class="content">
			<?php $this->page();?>
			
			<hr />
		</article>
		<footer class="footer"> footer here </footer>
	</div>
</body>
</html>