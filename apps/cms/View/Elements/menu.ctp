<li class="ic-dashboard"><a href="/dashboard"><span>Dashboard</span></a> </li>
<li class="ic-grid-tables"><a href="/admin/users/index"><span>Users</span></a></li>
<li class="ic-form-style"><a href="javascript:"><span>Bookmark</span></a>
	<ul>
		<li><?php echo $this->Html->link('Public Bookmark', array('controller' => 'bookmarks', 'action' => 'public', 'admin' => TRUE)); ?> </li>
		<li><?php echo $this->Html->link('All Bookmark', array('controller' => 'bookmarks', 'action' => 'index', 'admin' => TRUE)); ?> </li>
		<li><a href="buttons.html">By Category Bookmark</a> </li>
		<li><a href="form-controls.html">By Tag Bookmark</a> </li>
		<li><a href="table.html">Page with Sidebar Example</a> </li>
	</ul>
</li>
<li class="ic-typography"><a href="typography.html"><span>Typography</span></a></li>
<li class="ic-charts"><a href="charts.html"><span>Charts & Graphs</span></a></li>

<li class="ic-gallery dd"><a href="javascript:"><span>Image Galleries</span></a>
	 <ul>
		<li><a href="image-gallery.html">Pretty Photo</a> </li>
		<li><a href="gallery-with-filter.html">Gallery with Filter</a> </li>
	</ul>
</li>
<li class="ic-notifications"><a href="notifications.html"><span>Notifications</span></a></li>