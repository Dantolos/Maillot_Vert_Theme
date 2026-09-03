<?php
/**
 * Search results template.
 *
 * @package MaillotVert
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div class="default-container">
	<div class="default-content page-content">
		<header class="archive-header">
			<h1 class="fl">
				<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Search results for “%s”', 'maillot-vert' ), esc_html( get_search_query() ) );
				?>
			</h1>
			<?php get_search_form(); ?>
		</header>

		<?php if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class( 'entry-teaser' ); ?>>
					<h2 class="fm"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="entry-excerpt"><?php the_excerpt(); ?></div>
				</article>
				<?php
			endwhile;

			the_posts_pagination(
				[
					'mid_size'  => 1,
					'prev_text' => esc_html__( 'Previous', 'maillot-vert' ),
					'next_text' => esc_html__( 'Next', 'maillot-vert' ),
				]
			);
			?>
		<?php else : ?>
			<p><?php esc_html_e( 'No results. Try a different search term.', 'maillot-vert' ); ?></p>
		<?php endif; ?>
	</div>
</div>
<?php
get_footer();
