<?php
/**
 * Template for Links module
 *
 * $this is an instace of the Links object.
 *
 * Available properties:
 * $this->heading (string) Module heading.
 * $this->list (array) List with link items.
 *
 * @package Hogan
 */

declare( strict_types = 1 );
namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof Links ) ) {
	return; // Exit if accessed directly.
}

if ( ! empty( $this->heading ) ) : ?>
	<h2 class="hogan-heading"><?php echo esc_html( $this->heading ); ?></h2>
<?php
endif;
// TODO: base klasse på ul og li?
?>
<ul>
<?php
$list_li_classes = apply_filters( 'hogan/module/links/list_li_classes', [], $this, $this->list );
$item_counter = 0;

foreach ( $this->list as $item ) :
	?>
	<li class="<?php echo esc_attr( implode( ' ', $list_li_classes ) ); ?>">
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
		</a>
	</li>
	<?php
	$item_counter++;
endforeach;
?>
</ul>
