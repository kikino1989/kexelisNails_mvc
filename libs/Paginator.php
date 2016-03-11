<?php
class Paginator {

	function __construct($page_number, $items_per_page, $number_of_pages, $link) {
		// the page number
		$page_number = (( int ) $page_number > 0) ? ( int ) $page_number : 1;
?>
			<nav>
				<ul class="pager pagination-sm">
				    <li><a href="<?php echo "$link/". ((($page_number - 1) < 1) ? 1 : ($page_number - 1)) ."/$items_per_page";?>">Prev</a></li>
					<?php for($i = 0; $i < $number_of_pages; $i ++): ?>
						<li><a href="<?php echo "$link/".($i + 1)."/$items_per_page"; ?>"><span class="sr-only"></span><?php echo ($i + 1); ?></a></li>
					<?php endfor;?>
					<li><a href="<?php echo "$link/". ((($page_number + 1) > $number_of_pages) ? $number_of_pages : ($page_number + 1)) ."/$items_per_page";?>">Next</a></li>
				</ul>
			</nav>
<?php }
 }?>