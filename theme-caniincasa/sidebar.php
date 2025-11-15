<?php
/**
 * Sidebar Template
 *
 * @package CaninCasa
 * @since 1.0.0
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
    return;
}
?>

<div class="sidebar-widgets">
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
</div>
