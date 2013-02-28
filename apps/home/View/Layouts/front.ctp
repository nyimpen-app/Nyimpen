<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">
<head lang="en">
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<?php echo $this->element('meta/seo'); ?>
	<!-- Framework CSS -->
	<link rel="stylesheet" href="/css/style.css?2012" type="text/css" media="screen, projection">
	
	<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="/js/scrolltopcontrol.js"></script>
	<script type="text/javascript" src="/js/jquery.fancybox-1.3.4.pack.js"></script>
	<script type="text/javascript" src="/js/jquery.easing-1.3.pack.js"></script>
	<script type="text/javascript" src="/js/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="/js/my.function.js"></script>

	
	<!--[if lt IE 8]><link rel="stylesheet" href="assets/blueprint-css/ie.css" type="text/css" media="screen, projection"><![endif]-->
	<link rel="stylesheet" href="/css/screen.css" type="text/css" media="screen, projection">
	<link rel="stylesheet" href="/css/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
	
	<script type="text/javascript">
	$(document).ready(function() {
	
		$("#formadd").fancybox({
			'transitionIn'	:	'elastic',
			'transitionOut'	:	'elastic',
			'speedIn'		:	600, 
			'speedOut'		:	200, 
			'overlayShow'	:	false
		});
		
		$('.closeBtn').click(function() {
		
			$('.status').hide("slow");
		});
		
		textBlur('#username', 'username', '');
		textBlur('#password', 'password', '');
		$('.profileLink').click(function() {
			var id = $(this).attr('id');
		
			$('.box').hide('slow');
			$('#' + id + 'Form').show('slow');
		});
	
	});
	
	</script>
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-17968376-11']);
	  _gaq.push(['_setDomainName', 'nyimpen.com']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
</head>


<body>
	<div class="container">
		<div class="header alt">
			<div class="logo">
				<a href="/home"><img src="/images/logo.png" width="198" alt="Nyimpen" title="Nyimpen"></a>
			</div>	
			<?php echo $this->element('front/header'); ?>
		
		</div>
				
		<div class="content">
			<?php echo $content_for_layout; ?>
		</div>
		
		<div class="sidebar">
			<div class="ads">
				<script type="text/javascript"><!--
				google_ad_client = "ca-pub-5003122787590055";
				/* Nyimpen_home_R1 */
				google_ad_slot = "9677913933";
				google_ad_width = 160;
				google_ad_height = 600;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
			</div>
			
			
		</div>
		<hr class="space">
		<div id="footer-menu">
			<h6>Copyright &copy; 2012 - <a href="/">NyimpeN.com</a>
			/ <a href="/"> Home</a>
			/ <a href="/pages/about"> About</a>
			/ <a href="/pages/terms"> Term Of Services</a>
			/ <a href="/pages/privacy"> Privacy Policy</a>
			</h6>
			
		</div>
	</div><!-- end div .container -->
</body>
</html>
<?php echo $this->element('sql_dump'); ?>