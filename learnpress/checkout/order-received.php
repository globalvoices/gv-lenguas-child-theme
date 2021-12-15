<?php
/**
 * Template for displaying order detail.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/checkout/order-received.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.0
 */

defined( 'ABSPATH' ) || exit();
?>

<?php
/**
 * @var LP_Order $order_received
 */
if ( ! isset( $order_received ) ) {
	echo wp_sprintf(
		'<p>%s</p>',
		esc_html(
			apply_filters(
				'learn-press/order/received-invalid-order-message',
				__( 'Invalid order.', 'learnpress' )
			)
		)
	);

	return;
}

echo wp_sprintf(
	'<p>%s</p>',
	esc_html(
		apply_filters(
			'learn-press/order/received-order-message',
			'Thank you for enrolling. Click on the link below to continue.'
			// TODO: use translations eventually
			//__( 'Thank you. Your order has been received.', 'learnpress' )
		)
	)
);

?>
<table class="order_details">
	<tr class="item confirm">
		<th></th>
		<td>
			<?php
			$links = array();
			$items = $order_received->get_items();
			$count = count( $items );

			foreach ( $items as $item ) {
				if ( empty( $item['course_id'] ) || get_post_type( $item['course_id'] ) !== LP_COURSE_CPT ) {
					$links[] = apply_filters(
						'learn-press/order-item-not-course-id',
						__( 'Course does not exist', 'learnpress' ),
						$item
					);
				} else {
					$link = '<a href="' . get_the_permalink( $item['course_id'] ) . '">' . get_the_title( $item['course_id'] ) . '</a>';
					if ( $count > 1 ) {
						$link = sprintf( '<li>%s</li>', $link );
					}
					$links[] = apply_filters( 'learn-press/order-received-item-link', $link, $item );
				}
			}

			if ( $count > 1 ) {
				echo sprintf( '<ol>%s</ol>', join( '', $links ) );
			} elseif ( 1 == $count ) {
				echo wp_kses_post( implode( '', $links ) );
			} else {
				echo esc_html__( '(No item)', 'learnpress' );
			}
			?>
		</td>
	</tr>
	<?php
	$method_title = $order_received->get_payment_method_title();
	if ( $method_title ) :
		?>
		<tr class="method">
			<th><?php esc_html_e( 'Payment Method', 'learnpress' ); ?></th>
			<td>
				<?php echo esc_html( $method_title ); ?>
			</td>
		</tr>
	<?php endif; ?>
</table>

<?php do_action( 'learn-press/order/received/' . $order_received->payment_method, $order_received->get_id() ); ?>
<?php do_action( 'learn-press/order/received', $order_received ); ?>
