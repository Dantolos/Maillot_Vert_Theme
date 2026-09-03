<?php
/**
 * Fallback template.
 *
 * @package MaillotVert
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div class="default-container">
	<div class="default-content page-content">
		<?php if ( have_posts() ) : ?>

			<?php if ( ! is_singular() ) : ?>
				<header class="archive-header">
					<h1 class="fl"><?php the_archive_title(); ?></h1>
					<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
				</header>
			<?php endif; ?>

			<?php
			while ( have_posts() ) :
				the_post();

				if ( is_singular() ) {
					the_content();
					continue;
				}
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
			<p><?php esc_html_e( 'Nothing found.', 'maillot-vert' ); ?></p>
		<?php endif; ?>
	</div>
</div>
<?php
get_footer();
