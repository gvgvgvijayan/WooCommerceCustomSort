<?php
if (!defined('ABSPATH')) {
    exit;
}

?>
<form class="vg-sort-show" method="get">
    <label>Show:
        <select name="show" class="show" aria-label="<?php esc_attr_e('Show', 'woocommerce'); ?>" onchange="this.form.submit()">
            <option value="4" <?php selected(get_query_var('show'), 4) ?>>4</option>
            <option value="8" <?php selected(get_query_var('show'), 8) ?>>8</option>
            <option value="16" <?php selected(get_query_var('show'), 16) ?> <?php selected(get_query_var('show'), ''); ?>>16</option>
            <option value="32" <?php selected(get_query_var('show'), 32) ?>>32</option>
            <option value="-1" <?php selected(get_query_var('show'), -1) ?>>All</option>
        </select> Per Page</label>
    <input type="hidden" name="paged" value="1" />
    <?php wc_query_string_form_fields(null, array('show', 'submit', 'paged', 'product-page')); ?>
</form>