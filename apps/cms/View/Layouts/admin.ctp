<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Dashboard | Nyimpen.com Administration</title>
	<?php echo $this->element('meta'); ?>
    <script type="text/javascript">

        $(document).ready(function () {
            
          
			setupProgressbar('progress-bar');
            setDatePicker('date-picker');
            setupDialogBox('dialog', 'opener');
			  setupLeftMenu();
			setSidebarHeight();
			$('input[type="checkbox"]').fancybutton();
            $('input[type="radio"]').fancybutton();
			$('.datatable').dataTable();

        });
    </script>
</head>
<body>
    <div class="container_12">
        <div class="grid_12 header-repeat">
            <?php echo $this->element('user_menu'); ?>
        </div>
        <div class="clear">
        </div>
        <div class="grid_12">
            <ul class="nav main">
               <?php echo $this->element('menu'); ?>

            </ul>
        </div>
        <div class="clear">
        </div>
        <div class="grid_2">
            <div class="box sidemenu">
                <?php echo $this->element('sidebar'); ?>
            </div>
        </div>
        <?php echo $content_for_layout; ?>
        <div class="clear">
        </div>
    </div>
    <div class="clear">
    </div>
    <div id="site_info">
        <p>
            Copyright 2012 <a href="http://www.nyimpen.com" target="_blank">Nyimpen.com</a>. All Rights Reserved.
        </p>
    </div>
</body>
</html>
<?php echo $this->element('sql_dump'); ?>