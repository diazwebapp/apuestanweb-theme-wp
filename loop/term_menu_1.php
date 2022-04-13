<?php
$current_term = get_query_var("item");
$link = get_term_link($current_term);
?>
<li style="text-transform:capitalize;"><a href="<?php echo $link ?>"><?php echo $current_term->name?></a>
    