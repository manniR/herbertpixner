
<!--list child pages-->
<?php
if ($post->post_parent)
		$children = wp_list_pages("title_li=&child_of=" . $post->post_parent . "&echo=0");
else
		$children = wp_list_pages("title_li=&child_of=" . $post->ID . "&echo=0");
if ($children) {
		?>
		<!--responsive nav-->
		<div class="navbar">
				<ul class="nav nav-pills nav-stacked span2">
						<?php echo $children; ?>
				</ul>
		</div>
<?php } ?>
