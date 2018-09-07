<?php
/**
 * Template for Links module
 *
 * $this is an instace of the Links object.
 *
 * Available properties:
 * $this->list (array) List with link items.
 *
 * @package Hogan
 */

declare( strict_types = 1 );
namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof Links ) ) {
	return; // Exit if accessed directly.
}

$classnames = hogan_classnames( 'hogan-links', apply_filters( 'hogan/module/links/list_classes', [], $this ) );
?>
<ul class="<?php echo esc_attr( $classnames ); ?>">

<?php
$item_counter = 0;

foreach ( $this->list as $item ) :

	$list_li_classes = hogan_classnames( apply_filters( 'hogan/module/links/list_li_classes', [ 'hogan-links-item' ], $item, $this, $item_counter ) );

	?>
	<li class="<?php echo esc_attr( $list_li_classes ); ?>">
		<?php $unique_item_id = 'link-list-item-' . $this->counter . '-' . $item_counter; ?>

		<a href="<?php echo esc_url( $item['href'] ); ?>"
			<?php if ( ! empty( $item['target'] ) ) : ?>
				target="<?php echo esc_attr( $item['target'] ); ?>"
			<?php endif; ?>
			<?php if ( '_blank' === $item['target'] ) : ?>
				rel="noopener noreferrer"
			<?php endif; ?>
			<?php if ( ! empty( $item['description'] ) ) : ?>
				aria-label="<?php echo esc_attr( $item['title'] ); ?>"
				aria-describedby="<?php echo esc_attr( $unique_item_id ); ?>"
			<?php endif; ?>
			>
			<?php echo esc_html( $item['title'] ); ?>

			<?php if ( ! empty( $item['description'] ) ) : ?>
				<span id="<?php echo esc_attr( $unique_item_id ); ?>" class="hogan-link-description"><?php echo esc_html( $item['description'] ); ?></span>
			<?php endif; ?>

			<?php do_action( 'hogan_links_after_text' ); ?>
		</a>
	</li>
	<?php
	$item_counter++;
endforeach;
?>
</ul>
