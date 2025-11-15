<?php
/**
 * Single Post Template (Blog)
 *
 * @package CaninCasa
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">
    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-single' ); ?>>

            <?php caniincasa_breadcrumbs(); ?>

            <div class="container">
                <div class="blog-single__layout">

                    <!-- Main Content -->
                    <div class="blog-single__content">

                        <!-- Header -->
                        <header class="blog-single__header">
                            <?php
                            $categories = get_the_category();
                            if ( ! empty( $categories ) ) :
                            ?>
                                <div class="blog-categories">
                                    <?php foreach ( $categories as $category ) : ?>
                                        <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="category-badge">
                                            <?php echo esc_html( $category->name ); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <h1 class="blog-single__title"><?php the_title(); ?></h1>

                            <div class="blog-meta">
                                <span class="meta-item meta-date">
                                    <i class="icon-calendar">📅</i>
                                    <?php echo get_the_date(); ?>
                                </span>
                                <span class="meta-item meta-author">
                                    <i class="icon-user">👤</i>
                                    <?php the_author(); ?>
                                </span>
                                <?php if ( comments_open() || get_comments_number() ) : ?>
                                    <span class="meta-item meta-comments">
                                        <i class="icon-comments">💬</i>
                                        <?php comments_number( '0 commenti', '1 commento', '% commenti' ); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="blog-single__image">
                                    <?php the_post_thumbnail( 'caniincasa-featured', array( 'alt' => get_the_title() ) ); ?>
                                </div>
                            <?php endif; ?>
                        </header>

                        <!-- Content -->
                        <div class="blog-single__content-area">
                            <?php the_content(); ?>

                            <?php
                            wp_link_pages( array(
                                'before' => '<div class="page-links">' . esc_html__( 'Pagine:', 'caniincasa' ),
                                'after'  => '</div>',
                            ) );
                            ?>
                        </div>

                        <!-- Tags -->
                        <?php
                        $tags = get_the_tags();
                        if ( $tags ) :
                        ?>
                            <div class="blog-tags">
                                <strong><?php esc_html_e( 'Tag:', 'caniincasa' ); ?></strong>
                                <?php foreach ( $tags as $tag ) : ?>
                                    <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="tag-link">
                                        <?php echo esc_html( $tag->name ); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Author Bio -->
                        <?php
                        $author_description = get_the_author_meta( 'description' );
                        if ( $author_description ) :
                        ?>
                            <div class="author-bio">
                                <div class="author-bio__avatar">
                                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
                                </div>
                                <div class="author-bio__content">
                                    <h3 class="author-bio__name">
                                        <?php echo esc_html( get_the_author() ); ?>
                                    </h3>
                                    <p class="author-bio__description">
                                        <?php echo esc_html( $author_description ); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Post Navigation -->
                        <nav class="post-navigation">
                            <div class="nav-previous">
                                <?php previous_post_link( '%link', '<span class="nav-label">← ' . esc_html__( 'Articolo precedente', 'caniincasa' ) . '</span><span class="nav-title">%title</span>' ); ?>
                            </div>
                            <div class="nav-next">
                                <?php next_post_link( '%link', '<span class="nav-label">' . esc_html__( 'Articolo successivo', 'caniincasa' ) . ' →</span><span class="nav-title">%title</span>' ); ?>
                            </div>
                        </nav>

                        <!-- Comments -->
                        <?php
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;
                        ?>

                    </div><!-- .blog-single__content -->

                    <!-- Sidebar -->
                    <aside class="blog-single__sidebar">
                        <?php get_sidebar(); ?>
                    </aside>

                </div><!-- .blog-single__layout -->

                <!-- Related Posts -->
                <?php
                $related = caniincasa_get_related_posts( get_the_ID(), 3 );
                if ( $related ) :
                ?>
                    <div class="related-posts">
                        <h2 class="related-posts__title">
                            <?php esc_html_e( 'Articoli Correlati', 'caniincasa' ); ?>
                        </h2>
                        <div class="grid grid-3">
                            <?php
                            while ( $related->have_posts() ) :
                                $related->the_post();
                                ?>
                                <div class="card post-card">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail( 'caniincasa-card', array( 'class' => 'card-image' ) ); ?>
                                        </a>
                                    <?php endif; ?>
                                    <div class="card-content">
                                        <?php
                                        $cat = get_the_category();
                                        if ( ! empty( $cat ) ) :
                                        ?>
                                            <a href="<?php echo esc_url( get_category_link( $cat[0]->term_id ) ); ?>" class="post-card__category">
                                                <?php echo esc_html( $cat[0]->name ); ?>
                                            </a>
                                        <?php endif; ?>
                                        <h3 class="card-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <div class="card-excerpt">
                                            <?php the_excerpt(); ?>
                                        </div>
                                        <div class="card-footer">
                                            <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-block">
                                                <?php esc_html_e( 'Leggi tutto', 'caniincasa' ); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div><!-- .container -->

        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
